<?php

/**
 * Plugin Name: Apidae
 * Version: 1.0
 */

require __DIR__.'/vendor/autoload.php';

use Apidae\App;
use Apidae\MenuItem;
use Apidae\Page;
use Apidae\resources\JS;
use Apidae\resources\Style;
use Apidae\TwigEngine;

class CustomPage extends Page
{
    public function get(): string
    {
        return $this->template
            ->load('index.twig.html')
            ->render(['title' => 'Hello world!']);
    }

    public function post(): string
    {
        $_data = [
            'name' => $this->input('name', 'Caca'),
        ];

        return $this->template
            ->load('index.twig.html')
            ->render($_data);
    }
}

class CustomSubPage extends Page
{
    public function get(): string
    {
        return $this->template
            ->load('index.twig.html')
            ->render(['title' => 'Hi =]']);
    }

    public function post(): string
    {
        $_data = [
            'name' => $this->input('name', 'Caca'),
        ];

        return $this->template
            ->load('index.twig.html')
            ->render($_data);
    }
}

$styleApp = new Style(
    alias: 'cmspp_app_lotus',
    version: false,
    file: '/lotus.css',
    deps: []
);

$scriptApp = new JS(
    alias: 'cmspp_app_alpine',
    version: false,
    file: '/alpine.min.js',
    deps: []
);

$app = new App(resources: plugins_url('/assets', __FILE__));
$app->addStyleToAdmin($styleApp);
$app->addScriptToAdmin($scriptApp);

$twigEngine = new TwigEngine;
$twigEngine->setFolder(__DIR__.'/templates');

$page = new CustomPage();
$page2 = new CustomSubPage();

// Menu
$mainMenu = new MenuItem(title: 'Hello', path: 'hello');
$mainMenu->setPage($page);
// Submenu
$subMenu = new MenuItem(title: 'Hi', path: 'hi');
$subMenu->setPage($page2);
// append SubMenu
$mainMenu->appendChild($subMenu);

$app->addMenu($mainMenu);
$app->setTemplateEngine($twigEngine);
$app->createApp();
