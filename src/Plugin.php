<?php

namespace MyPlugin;

class Plugin
{
    public static function config($filename)
    {
        return include plugin_dir_path(__FILE__) . 'config/' . $filename . '.php';
    }
}
