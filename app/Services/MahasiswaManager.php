<?php

namespace App\Services;

use App\Entities\Mahasiswa;
use Exception;

class MahasiswaManager
{
    private string $filePath;
    private array $mahasiswa = [];

    public function __construct()
    {
        $this->filePath = storage_path('app/mahasiswa.json');
        $this->initializeFile();
        $this->loadData();
    }

    private function initializeFile(): void
    {
        $directory = dirname($this->filePath);

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        if (!file_exists($this->filePath)) {
            file_put_contents($this->filePath, json_encode([], JSON_PRETTY_PRINT));
        }
    }

    private function loadData(): void
    {
        try {
            $content = file_get_contents($this->filePath);

            if ($content === false) {
                throw new Exception('Gagal membaca file data mahasiswa.');
            }

            $data = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Format JSON pada file mahasiswa tidak valid.');
            }

            $this->mahasiswa = $data ?? [];
        } catch (Exception $e) {
            throw new Exception('Error File I/O: ' . $e->getMessage());
        }
    }

    private function saveData(): void
    {
        try {
            $encodedData = json_encode($this->mahasiswa, JSON_PRETTY_PRINT);

            if ($encodedData === false) {
                throw new Exception('Gagal mengubah data mahasiswa ke JSON.');
            }

            $result = file_put_contents($this->filePath, $encodedData);

            if ($result === false) {
                throw new Exception('Gagal menyimpan data mahasiswa ke file.');
            }
        } catch (Exception $e) {
            throw new Exception('Error penyimpanan data: ' . $e->getMessage());
        }
    }

    public function getAll(): array
    {
        return $this->mahasiswa;
    }

    public function findByNim(string $nim): ?array
    {
        foreach ($this->mahasiswa as $row) {
            if ($row['nim'] === $nim) {
                return $row;
            }
        }

        return null;
    }

    public function add(Mahasiswa $mahasiswa): void
    {
        if ($this->findByNim($mahasiswa->getNim()) !== null) {
            throw new Exception('NIM sudah terdaftar.');
        }

        $this->mahasiswa[] = $mahasiswa->toArray();
        $this->saveData();
    }

    public function update(string $oldNim, Mahasiswa $newMahasiswa): void
    {
        $newNim = $newMahasiswa->getNim();

        if ($newNim !== $oldNim && $this->findByNim($newNim) !== null) {
            throw new Exception('NIM baru sudah digunakan oleh mahasiswa lain.');
        }

        $isFound = false;

        foreach ($this->mahasiswa as &$row) {
            if ($row['nim'] === $oldNim) {
                $row = $newMahasiswa->toArray();
                $isFound = true;
                break;
            }
        }

        unset($row);

        if (!$isFound) {
            throw new Exception('Data mahasiswa tidak ditemukan.');
        }

        $this->saveData();
    }

    public function delete(string $nim): void
    {
        $oldCount = count($this->mahasiswa);

        $this->mahasiswa = array_values(array_filter($this->mahasiswa, function ($row) use ($nim) {
            return $row['nim'] !== $nim;
        }));

        if (count($this->mahasiswa) === $oldCount) {
            throw new Exception('Data mahasiswa tidak ditemukan.');
        }

        $this->saveData();
    }

    public function getByIndexUsingPointer(int $targetIndex): ?array
    {
        reset($this->mahasiswa);

        for ($i = 0; $i < $targetIndex; $i++) {
            next($this->mahasiswa);
        }

        $currentData = current($this->mahasiswa);

        return $currentData === false ? null : $currentData;
    }
}
