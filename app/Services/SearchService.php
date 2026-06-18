<?php

namespace App\Services;

class SearchService
{
    public static function linearSearch(array $data, string $keyword): array
    {
        $result = [];

        foreach ($data as $row) {
            if (
                stripos($row['nim'], $keyword) !== false ||
                stripos($row['nama'], $keyword) !== false ||
                stripos($row['email'], $keyword) !== false ||
                stripos($row['jurusan'], $keyword) !== false
            ) {
                $result[] = $row;
            }
        }

        return $result;
    }

    public static function sequentialSearch(array $data, string $keyword): array
    {
        $result = [];

        for ($i = 0; $i < count($data); $i++) {
            if (
                stripos($data[$i]['nim'], $keyword) !== false ||
                stripos($data[$i]['nama'], $keyword) !== false ||
                stripos($data[$i]['jurusan'], $keyword) !== false
            ) {
                $result[] = $data[$i];
            }
        }

        return $result;
    }

    public static function binarySearchByNim(array $data, string $nim): ?array
    {
        $sortedData = SortService::selectionSortByNim($data);

        $left = 0;
        $right = count($sortedData) - 1;

        while ($left <= $right) {
            $middle = intdiv($left + $right, 2);

            if ($sortedData[$middle]['nim'] === $nim) {
                return $sortedData[$middle];
            }

            if ($sortedData[$middle]['nim'] < $nim) {
                $left = $middle + 1;
            } else {
                $right = $middle - 1;
            }
        }

        return null;
    }
}
