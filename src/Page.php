<?php

namespace rkvcs\cmspp;

use rkvcs\cmspp\interfaces\AdminPage;
use rkvcs\cmspp\interfaces\TemplateEngine;

class Page implements AdminPage
{
    public function __construct() {}

    public TemplateEngine $template;

    public function input(string $key)
    {
        $value = $_POST[$key] ?? $_GET[$key] ?? null;

        return $value;
    }

    public function is_post()
    {
        return ! empty($_POST);
    }

    public function get(): string
    {
        return '';
    }

    public function post(): string
    {
        return '';
    }

    public function setTemplate(TemplateEngine &$template): void
    {
        $this->template = $template;
    }
}
