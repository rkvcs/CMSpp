<?php

namespace rkvcs\cmspp\interfaces;

interface TemplateEngine
{
    public function setFolder(string $folder): void;

    public function load(string $file, bool $debug = false): TemplateEngine;

    public function render(array $data = []): string;
}
