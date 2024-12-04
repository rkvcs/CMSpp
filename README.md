# Apidae

Plugin to help create admin pages on WordPress.

Install:
```sh
composer require rkvcs/apidae
```

Using:

```php
// CustomPage.php
use Apidae\Page;

// Page example
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

```

How to register:

```php

use Apidae\App;
use Apidae\MenuItem;
use Apidae\Page;
use Apidae\resources\JS;
use Apidae\resources\Style;
use Apidae\TwigEngine;

// Creating css and js files
$styleApp = new Style(
    alias: 'cmspp_app_mystyle',
    version: false,
    file: '/style.css',
    deps: [] // dependencies
);

$scriptApp = new JS(
    alias: 'cmspp_app_myscript',
    version: false,
    file: '/myapp.js',
    deps: [] // dependencies
);

// Pointing the folder where css and js files are in
$app = new App(resources: plugins_url('/assets', __FILE__));

// Registering files to the plugin
$app->addStyleToAdmin($styleApp);
$app->addScriptToAdmin($scriptApp);

// Creating the template engine that will be used
$twigEngine = new TwigEngine;
$twigEngine->setFolder(__DIR__.'/templates');

// Custom Page created before
$page = new CustomPage();

// Menu
$mainMenu = new MenuItem(title: 'Hello', path: 'hello');
$mainMenu->setPage($page);

// WordPress registers the pages through the menu
$app->addMenu($mainMenu);

// Setting default template engine
$app->setTemplateEngine($twigEngine);

// Registering the pages and assets on WordPress
$app->createApp();

```