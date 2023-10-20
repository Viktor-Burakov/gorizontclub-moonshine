<?php

use MoonShine\Exceptions\MoonShineNotFoundException;
use MoonShine\Models\MoonshineUser;

return [
    'dir' => 'app/MoonShine',
    'namespace' => 'App\MoonShine',
    'disk' => env('MOONSHINE_DISK', 'public'),

    'title' => env('MOONSHINE_TITLE', 'MoonShine'),
    'logo' => env('MOONSHINE_LOGO'),
    'logo_small' => env('MOONSHINE_LOGO_SMALL'),

    'route' => [
        'prefix' => env('MOONSHINE_ROUTE_PREFIX', 'admin'),
        'index_route' => env('MOONSHINE_INDEX_ROUTE', 'moonshine.index'),
        'middleware' => ['moonshine'],
        'custom_page_slug' => 'custom_page',
        'notFoundHandler' => MoonShineNotFoundException::class,
    ],
    'use_migrations' => true,
    'use_notifications' => true,
    'auth' => [
        'enable' => true,
        'fields' => [
            'username' => 'email',
            'password' => 'password',
            'name' => 'name',
            'avatar' => 'avatar',
        ],
        'guard' => 'moonshine',
        'guards' => [
            'moonshine' => [
                'driver' => 'session',
                'provider' => 'moonshine',
            ],
        ],
        'providers' => [
            'moonshine' => [
                'driver' => 'eloquent',
                'model' => MoonshineUser::class,
            ],
        ],
        'footer' => '',
    ],
    'locales' => [
        'ru',
        'en',
    ],
    'middlewares' => [],
    'tinymce' => [
        'file_manager' => false, // or 'laravel-filemanager' prefix for lfm
        'token' => env('MOONSHINE_TINYMCE_TOKEN', '0g0wc5j79i5bp5d3j7fq7k0w249dqi642d8rx3x7tsgta2i0'),
        'version' => env('MOONSHINE_TINYMCE_VERSION', '6'),
    ],
    'socialite' => [
        // 'driver' => 'path_to_image_for_button'
    ],
    'header' => null, // blade path
    'footer' => [
        'copyright' => 'Made with ❤️ by <a href="https://cutcode.dev" class="font-semibold text-purple hover:text-pink" target="_blank">CutCode</a>',
        'nav' => [
            'https://github.com/moonshine-software/moonshine/blob/1.5.x/LICENSE.md' => 'License',
            'https://moonshine.cutcode.dev' => 'Documentation',
            'https://github.com/moonshine-software/moonshine' => 'GitHub',
        ],
    ],
];
