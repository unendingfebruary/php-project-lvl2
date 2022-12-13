<?php

namespace Differ\Builder;

use function Functional\sort;

const ADDED_NODE = 'added';
const REMOVED_NODE = 'removed';
const CHANGED_NODE = 'changed';
const UNCHANGED_NODE = 'unchanged';
const INTERNAL_NODE = 'internal';

/**
 * @param mixed $firstData
 * @param mixed $secondData
 * @return array
 */
function build(mixed $firstData, mixed $secondData): array
{
    $keys = getKeys($firstData, $secondData);

    $buildTree = function ($key) use ($firstData, $secondData) {
        if (!property_exists($firstData, $key)) {
            return buildNode(
                $key,
                ADDED_NODE,
                null,
                $secondData->$key
            );
        }

        if (!property_exists($secondData, $key)) {
            return buildNode(
                $key,
                REMOVED_NODE,
                $firstData->$key,
                null
            );
        }

        if (is_object($firstData->$key) && is_object($secondData->$key)) {
            return buildNode(
                $key,
                INTERNAL_NODE,
                null,
                null,
                build($firstData->$key, $secondData->$key)
            );
        }

        if ($firstData->$key !== $secondData->$key) {
            return buildNode(
                $key,
                CHANGED_NODE,
                $firstData->$key,
                $secondData->$key
            );
        }

        return buildNode(
            $key,
            UNCHANGED_NODE,
            $firstData->$key,
            null
        );
    };

    return array_map($buildTree, $keys);
}

/**
 * @param mixed $firstData
 * @param mixed $secondData
 * @return array
 */
function getKeys(mixed $firstData, mixed $secondData): array
{
    $firstDataKeys = array_keys(get_object_vars($firstData));
    $secondDataKeys = array_keys(get_object_vars($secondData));

    $keys = array_unique(array_merge($firstDataKeys, $secondDataKeys));

    return sort($keys, fn($left, $right) => strcmp($left, $right));
}

/**
 * @param string $key
 * @param string $status
 * @param mixed $oldValue
 * @param mixed $newValue
 * @param mixed|null $child
 * @return array
 */
function buildNode(string $key, string $status, mixed $oldValue, mixed $newValue, mixed $child = null): array
{
    return [
      'key' => $key,
      'status' => $status,
      'oldValue' => $oldValue,
      'newValue' => $newValue,
      'child' => $child
    ];
}
