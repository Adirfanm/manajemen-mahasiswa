<?php

namespace App\Entities;

class Mahasiswa extends Person
{
    private string $nim;
    private string $jurusan;
    private int $semester;

    public function __construct(
        string $nim,
        string $nama,
        string $email,
        string $jurusan,
        int $semester
    ) {
        parent::__construct($nama, $email);

        $this->nim = $nim;
        $this->jurusan = $jurusan;
        $this->semester = $semester;
    }

    public function getNim(): string
    {
        return $this->nim;
    }

    public function getJurusan(): string
    {
        return $this->jurusan;
    }

    public function getSemester(): int
    {
        return $this->semester;
    }

    public function setNim(string $nim): void
    {
        $this->nim = $nim;
    }

    public function setJurusan(string $jurusan): void
    {
        $this->jurusan = $jurusan;
    }

    public function setSemester(int $semester): void
    {
        $this->semester = $semester;
    }

    public function toArray(): array
    {
        return [
            'nim' => $this->nim,
            'nama' => $this->nama,
            'email' => $this->email,
            'jurusan' => $this->jurusan,
            'semester' => $this->semester,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['nim'],
            $data['nama'],
            $data['email'],
            $data['jurusan'],
            (int) $data['semester']
        );
    }
}
