<?php

namespace Apidae;

use Apidae\interfaces\TemplateEngine;
use Apidae\resources\JS;
use Apidae\resources\Style;

class App
{
    private array $_menus = [];

    private array $_admin_styles = [];

    private array $_admin_scripts = [];

    private ?TemplateEngine $template;

    public function __construct(
        private ?string $resources = null
    ) {}

    public function resource(string $file = '')
    {
        return $this->resources.$file;
    }

    public function addMenu(MenuItem $menu)
    {
        $this->_menus[] = $menu;
    }

    public function addManyMenus(...$menus)
    {
        foreach ($menus as $menu) {
            if ($menu instanceof MenuItem) {
                $this->addMenu($menu);
            }
        }
    }

    public function allMenu()
    {
        return $this->_menus;
    }

    public function addStyleToAdmin(Style $style_file)
    {
        $this->_admin_styles[] = $style_file;
    }

    public function addScriptToAdmin(JS $script_file)
    {
        $this->_admin_scripts[] = $script_file;
    }

    public function adminStyles()
    {
        return $this->_admin_styles;
    }

    public function adminScripts()
    {
        return $this->_admin_scripts;
    }

    public function setTemplateEngine(TemplateEngine &$template)
    {
        $this->template = $template;
    }

    public function createApp()
    {
        if (function_exists('add_action')) {
            $setup = &$this;

            // Registering Menus
            add_action('admin_menu', function () use ($setup) {
                foreach ($setup->allMenu() as $menu) {

                    $menu->page->setTemplate($setup->template);

                    add_menu_page(
                        page_title: ucfirst($menu->title()),
                        menu_title: ucfirst($menu->title()),
                        capability: 'read',
                        menu_slug: $menu->path(),
                        callback: function () use ($menu) {
                            if ($menu->page->is_post()) {
                                echo $menu->page->post();
                            } else {
                                echo $menu->page->get();
                            }
                        },
                        icon_url: 'dashicons-admin-settings',
                    );

                    foreach($menu->children() as $item){
                        $item->page->setTemplate($setup->template);
                        
                        add_submenu_page(
                            parent_slug: $menu->id(),
                            page_title: ucfirst($item->title()),
                            menu_title: ucfirst($item->title()),
                            capability: 'read',
                            menu_slug: $item->path(),
                            callback: function () use ($item) {
                                if ($item->page->is_post()) {
                                    echo $item->page->post();
                                } else {
                                    echo $item->page->get();
                                }
                            }
                        );
                    }
                }

            });

            // Load admin style and scripts
            add_action('admin_enqueue_scripts', function () use ($setup) {
                foreach ($setup->adminStyles() as $item) {
                    wp_enqueue_style(
                        $item->alias(),
                        $setup->resource($item->file()),
                        $item->deps(),
                        $item->version()
                    );
                }

                foreach ($setup->adminScripts() as $item) {
                    wp_enqueue_script(
                        $item->alias(),
                        $setup->resource($item->file()),
                        $item->deps(),
                        $item->version()
                    );
                }
            });
        }
    }
}
