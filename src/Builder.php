<?php

namespace Differ\Builder;

const ADDED_NODE = 'added';
const REMOVED_NODE = 'removed';
const CHANGED_NODE = 'changed';
const UNCHANGED_NODE = 'unchanged';
const INTERNAL_NODE = 'internal';

/**
 * @param $firstData
 * @param $secondData
 * @return array|array[]
 */
function build($firstData, $secondData): array
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
 * @param $firstData
 * @param $secondData
 * @return array
 */
function getKeys($firstData, $secondData): array
{
    $firstDataKeys = array_keys(get_object_vars($firstData));
    $secondDataKeys = array_keys(get_object_vars($secondData));

    $keys = array_unique(array_merge($firstDataKeys, $secondDataKeys));
    sort($keys, SORT_STRING | SORT_FLAG_CASE);

    return $keys;
}

/**
 * @param $key
 * @param $status
 * @param $oldValue
 * @param $newValue
 * @param $child
 * @return array
 */
function buildNode($key, $status, $oldValue, $newValue, $child = null): array
{
    return [
      'key' => $key,
      'status' => $status,
      'oldValue' => $oldValue,
      'newValue' => $newValue,
      'child' => $child
    ];
}
