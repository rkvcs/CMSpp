<?php

namespace Apidae\interfaces;

interface AdminPage
{
    public function get(): string;

    public function post(): string;

    public function input(string $key);

    public function setTemplate(TemplateEngine &$template): void;
}
