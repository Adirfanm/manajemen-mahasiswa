<?php

namespace App\Services;

class SortService
{
    public static function bubbleSortByNama(array $data): array
    {
        $n = count($data);

        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = 0; $j < $n - $i - 1; $j++) {
                if (strtolower($data[$j]['nama']) > strtolower($data[$j + 1]['nama'])) {
                    $temp = $data[$j];
                    $data[$j] = $data[$j + 1];
                    $data[$j + 1] = $temp;
                }
            }
        }

        return $data;
    }

    public static function selectionSortByNim(array $data): array
    {
        $n = count($data);

        for ($i = 0; $i < $n - 1; $i++) {
            $minIndex = $i;

            for ($j = $i + 1; $j < $n; $j++) {
                if ($data[$j]['nim'] < $data[$minIndex]['nim']) {
                    $minIndex = $j;
                }
            }

            $temp = $data[$i];
            $data[$i] = $data[$minIndex];
            $data[$minIndex] = $temp;
        }

        return $data;
    }

    public static function mergeSortBySemester(array $data): array
    {
        if (count($data) <= 1) {
            return $data;
        }

        $middle = intdiv(count($data), 2);
        $left = array_slice($data, 0, $middle);
        $right = array_slice($data, $middle);

        return self::merge(
            self::mergeSortBySemester($left),
            self::mergeSortBySemester($right)
        );
    }

    private static function merge(array $left, array $right): array
    {
        $result = [];

        while (count($left) > 0 && count($right) > 0) {
            if ($left[0]['semester'] <= $right[0]['semester']) {
                $result[] = array_shift($left);
            } else {
                $result[] = array_shift($right);
            }
        }

        return array_merge($result, $left, $right);
    }
}
