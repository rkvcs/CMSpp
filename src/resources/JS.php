<?php

namespace Apidae\resources;

class JS
{
    public function __construct(
        private string $alias,
        private string $version,
        private string $file,
        private array $deps,
    ) {}

    public function alias()
    {
        return $this->alias;
    }

    public function version()
    {
        return $this->version;
    }

    public function file()
    {
        return $this->file;
    }

    public function deps()
    {
        return $this->deps;
    }
}
