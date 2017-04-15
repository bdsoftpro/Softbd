<?php

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        return SBD\Softbd\Facades\Softbd::setting($key, $default);
    }
}

if (!function_exists('menu')) {
    function menu($menuName, $type = null, array $options = [])
    {
        return SBD\Softbd\Models\Menu::display($menuName, $type, $options);
    }
}

if (!function_exists('softbd_asset')) {
    function softbd_asset($path, $secure = null)
    {
        return asset(config('softbd.assets_path').'/'.$path, $secure);
    }
}
