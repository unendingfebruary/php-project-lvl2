<?php

namespace Differ\Formatters\Plain;

use Exception;

use const Differ\Builder\ADDED_NODE;
use const Differ\Builder\CHANGED_NODE;
use const Differ\Builder\INTERNAL_NODE;
use const Differ\Builder\REMOVED_NODE;
use const Differ\Builder\UNCHANGED_NODE;

/**
 * @param $tree
 * @param string $path
 * @return string
 * @throws Exception
 */
function formatToPlain($tree, string $path = ''): string
{
    $formatTree = function ($node) use ($path) {
        $property = $path . $node['key'];
        $oldValue = stringify($node['oldValue']);
        $newValue = stringify($node['newValue']);

        return match ($node['status']) {
            ADDED_NODE => "Property '{$property}' was added with value: {$newValue}",
            REMOVED_NODE => "Property '{$property}' was removed",
            INTERNAL_NODE => formatToPlain($node['child'], "{$property}."),
            CHANGED_NODE => "Property '{$property}' was updated. From {$oldValue} to {$newValue}",
            UNCHANGED_NODE => [],
            default => throw new Exception("Unexpected node status: '{$node['status']}'"),
        };
    };

    $formatted = array_map($formatTree, $tree);
    $result = array_filter($formatted, function ($item) {
        return !empty($item);
    });

    return implode(PHP_EOL, $result);
}

/**
 * @param $value
 * @return string
 */
function stringify($value): string
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    if (is_null($value)) {
        return 'null';
    }

    if (is_object($value)) {
        return '[complex value]';
    }

    if (is_int($value)) {
        return $value;
    }

    return "'{$value}'";
}
