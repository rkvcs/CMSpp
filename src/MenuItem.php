<?php

namespace rkvcs\cmspp;

use Cocur\Slugify\Slugify;
use rkvcs\cmspp\interfaces\AdminPage;

class MenuItem
{
    private ?string $id = null;

    private ?string $title = null;

    private array $children = [];

    public ?AdminPage $page = null;

    public function __construct(string $title, string $path)
    {
        $slu = new Slugify;
        $this->id = $slu->slugify($path);
        $this->title = $title;
    }

    public function id()
    {
        return $this->id;
    }

    public function path()
    {
        return $this->id;
    }

    public function title()
    {
        return $this->title;
    }

    public function appendChild(MenuItem $menu)
    {
        $this->children[] = $menu;
    }

    public function removeChild(string|int $key)
    {
        if (isset($this->children[$key])) {
            unset($this->children[$key]);
        }
    }

    public function children()
    {
        return $this->children;
    }

    public function setPage(AdminPage $page)
    {
        $this->page = $page;
    }

    public function __toString()
    {
        return "[{$this->id}]: {$this->title}";
    }
}
