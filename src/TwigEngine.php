<?php

namespace rkvcs\cmspp;

use rkvcs\cmspp\interfaces\TemplateEngine;

class TwigEngine implements TemplateEngine
{
    private $compile = null;

    private $folder = './template';

    public function load(string $file, bool $debug = false): TemplateEngine
    {
        if (empty($this->compile)) {
            $loader = new \Twig\Loader\FilesystemLoader($this->folder);

            $twig = new \Twig\Environment($loader, [
                'debug' => $debug,
            ]);

            $twig->addExtension(new \Twig\Extension\DebugExtension);
        }

        $this->compile = $twig->load($file);

        return $this;
    }

    public function render(array $data = []): string
    {
        return $this->compile->render($data);
    }

    public function setFolder(string $folder = './template'): void
    {
        $this->folder = $folder;
    }
}
