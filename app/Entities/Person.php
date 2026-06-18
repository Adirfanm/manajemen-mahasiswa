<?php

namespace App\Entities;

abstract class Person implements Displayable
{
    protected string $nama;
    protected string $email;

    public function __construct(string $nama, string $email)
    {
        $this->nama = $nama;
        $this->email = $email;
    }

    public function getNama(): string
    {
        return $this->nama;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setNama(string $nama): void
    {
        $this->nama = $nama;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}
