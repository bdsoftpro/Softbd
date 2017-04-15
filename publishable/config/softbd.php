<?php

return [
    /*
    |--------------------------------------------------------------------------
    | User config
    |--------------------------------------------------------------------------
    |
    | Here you can specify softbd user configs
    |
    */

    'user' => [
        'add_default_role_on_register' => true,
        'default_role'                 => 'user',
        'namespace'                    => App\User::class,
        'default_avatar'               => 'users/default.png',
    ],

    /*
    |--------------------------------------------------------------------------
    | Controllers config
    |--------------------------------------------------------------------------
    |
    | Here you can specify softbd controller settings
    |
    */

    'controllers' => [
        'namespace' => 'SBD\\Softbd\\Http\\Controllers',
    ],

    /*
    |--------------------------------------------------------------------------
    | Models config
    |--------------------------------------------------------------------------
    |
    | Here you can specify default model namespace when creating BREAD.
    | Must include trailing backslashes. If not defined the default application
    | namespace will be used.
    |
    */

    'models' => [
        //'namespace' => 'App\\',
    ],

    /*
    |--------------------------------------------------------------------------
    | Path to the Softbd Assets
    |--------------------------------------------------------------------------
    |
    | Here you can specify the location of the softbd assets path
    |
    */

    'assets_path' => '/assets/admin',

    /*
    |--------------------------------------------------------------------------
    | Storage Config
    |--------------------------------------------------------------------------
    |
    | Here you can specify attributes related to your application file system
    |
    */

    'storage' => [
        'disk' => 'public',
    ],

    /*
    |--------------------------------------------------------------------------
    | Media Manager
    |--------------------------------------------------------------------------
    |
    | Here you can specify if media manager can show hidden files like(.gitignore)
    |
    */

    'hidden_files' => false,

    /*
    |--------------------------------------------------------------------------
    | Database Config
    |--------------------------------------------------------------------------
    |
    | Here you can specify softbd database settings
    |
    */

    'database' => [
        'tables' => [
            'hidden' => ['migrations', 'data_rows', 'data_types', 'menu_items', 'password_resets', 'permission_role', 'permissions', 'settings'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Multilingual configuration
    |--------------------------------------------------------------------------
    |
    | Here you can specify if you want Softbd to ship with support for
    | multilingual and what locales are enabled.
    |
    */

    'multilingual' => [
        /*
         * Set whether or not the multilingual is supported by the BREAD input.
         */
        'bread' => false,

        /*
         * Select default language
         */
        'default' => 'en',

        /*
         * Select languages that are supported.
         */
        'locales' => [
            'en',
            //'pt',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Widgets Config
    |--------------------------------------------------------------------------
    |
    | Here you can specify softbd administration settings
    |
    */

    'widgets' => [
        [
            'name'  => 'User',
            'icon'  => 'softbd-group',
            'model' => SBD\Softbd\Models\User::class,
            'url'   => 'admin/users',
            'image' => '/images/widget-backgrounds/02.png',
        ],
        [
            'name'  => 'Post',
            'icon'  => 'softbd-news',
            'model' => SBD\Softbd\Models\Post::class,
            'url'   => 'admin/posts',
            'image' => '/images/widget-backgrounds/03.png',
        ],
        [
            'name'  => 'Page',
            'icon'  => 'softbd-file-text',
            'model' => SBD\Softbd\Models\Page::class,
            'url'   => 'admin/pages',
            'image' => '/images/widget-backgrounds/04.png',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dashboard config
    |--------------------------------------------------------------------------
    |
    | Here you can modify some aspects of your dashboard
    |
    */

    'dashboard' => [
        // Add custom list items to navbar's dropdown
        'navbar_items' => [
            'Profile' => [
                'route'         => 'softbd.profile',
                'classes'       => 'class-full-of-rum',
                'icon_class'    => 'softbd-person',
            ],
            'Home' => [
                'route'         => '/',
                'icon_class'    => 'softbd-home',
                'target_blank'  => true,
            ],
            'Logout' => [
                'route'      => 'softbd.logout',
                'icon_class' => 'softbd-power',
            ],
        ],

        'data_tables' => [
            'responsive' => true, // Use responsive extension for jQuery dataTables that are not server-side paginated
        ],

        'widgets' => [
            'SBD\\Softbd\\Widgets\\UserDimmer',
            'SBD\\Softbd\\Widgets\\PostDimmer',
            'SBD\\Softbd\\Widgets\\PageDimmer',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | UI Generic Config
    |--------------------------------------------------------------------------
    |
    | Here you change some of the Softbd UI settings.
    |
    | TODO: Move style properties to assets/css
    |
    */

    'login' => [
        'gradient_a' => '#ffffff',
        'gradient_b' => '#ffffff',
    ],

    'primary_color' => '#22A7F0',

    'show_dev_tips' => true, // Show development tip "How To Use:" in Menu and Settings

];
