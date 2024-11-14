<?php

namespace rkvcs\cmspp;

use Cocur\Slugify\Slugify;
use rkvcs\cmspp\interfaces\AdminPage;

class MenuItem
{
    private ?string $id = null;

    private ?string $title = null;

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

    public function setPage(AdminPage $page)
    {
        $this->page = $page;
    }

    public function __toString()
    {
        return "[{$this->id}]: {$this->title}";
    }
}
