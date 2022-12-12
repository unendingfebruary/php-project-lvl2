<?php

namespace Differ\Formatters\Stylish;

use Exception;

use const Differ\Builder\ADDED_NODE;
use const Differ\Builder\CHANGED_NODE;
use const Differ\Builder\INTERNAL_NODE;
use const Differ\Builder\REMOVED_NODE;
use const Differ\Builder\UNCHANGED_NODE;

const BASE_INDENT = 4;
const SIGN_INDENT = 2;

/**
 * @param $tree
 * @param int $depth
 * @return string
 * @throws Exception
 */
function formatToStylish($tree, int $depth = 1): string
{
    $indent = getIndent($depth);
    $indentWithSign = getIndent($depth, SIGN_INDENT);

    $formatTree = function ($node) use ($indent, $indentWithSign, $depth) {
        switch ($node['status']) {
            case ADDED_NODE:
                return "{$indentWithSign}+ {$node['key']}: " . stringify($node['newValue'], $depth);

            case REMOVED_NODE:
                return "{$indentWithSign}- {$node['key']}: " . stringify($node['oldValue'], $depth);

            case INTERNAL_NODE:
                $child = formatToStylish($node['child'], $depth + 1);
                return "{$indent}{$node['key']}: {$child}";

            case CHANGED_NODE:
                $old = "{$indentWithSign}- {$node['key']}: " . stringify($node['oldValue'], $depth);
                $new = "{$indentWithSign}+ {$node['key']}: " . stringify($node['newValue'], $depth);
                return implode(PHP_EOL, [$old, $new]);

            case UNCHANGED_NODE:
                return "{$indent}{$node['key']}: " . stringify($node['oldValue'], $depth);

            default:
                throw new Exception("Unexpected node status: '{$node['status']}'");
        }
    };

    $formatted = array_map($formatTree, $tree);
    return addBraces(implode(PHP_EOL, $formatted), $depth - 1);
}

/**
 * @param $depth
 * @param int $signIndent
 * @return string
 */
function getIndent($depth, int $signIndent = 0): string
{
    return str_repeat(' ', BASE_INDENT * $depth - $signIndent);
}

/**
 * @param $value
 * @param $depth
 * @return string
 */
function stringify($value, $depth): string
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    if (is_null($value)) {
        return 'null';
    }

    if (is_object($value)) {
        $object = $value;
        $keys = array_keys(get_object_vars($object));
        $indent = getIndent($depth + 1);

        $formatObj = function ($key) use ($object, $indent, $depth) {
            $value = stringify($object->$key, $depth + 1);
            return "{$indent}{$key}: {$value}";
        };

        $formatted = array_map($formatObj, $keys);
        return addBraces(implode(PHP_EOL, $formatted), $depth);
    }

    return "{$value}";
}

/**
 * @param $data
 * @param $depth
 * @return string
 */
function addBraces($data, $depth): string
{
    $indent = getIndent($depth);
    $openBrace = "{" . PHP_EOL;
    $closeBrace = PHP_EOL . "{$indent}}";

    return "{$openBrace}{$data}{$closeBrace}";
}
