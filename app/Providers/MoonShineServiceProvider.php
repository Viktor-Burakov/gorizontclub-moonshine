<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\ContentBlock;
use App\Models\Image;
use App\Models\Post;
use App\MoonShine\Pages\FormTable;
use App\MoonShine\Resources\CategoryResource;
use App\MoonShine\Resources\ContentBlockResource;
use App\MoonShine\Resources\ImageResource;
use App\MoonShine\Resources\PostResource;
use Closure;
use MoonShine\Menu\MenuGroup;
use MoonShine\Menu\MenuItem;
use MoonShine\Providers\MoonShineApplicationServiceProvider;
use MoonShine\Resources\MoonShineUserResource;
use MoonShine\Resources\MoonShineUserRoleResource;

class MoonShineServiceProvider extends MoonShineApplicationServiceProvider
{
    protected function menu(): Closure|array
    {
        return [
            MenuItem::make('Все посты', new PostResource())
                ->badge(fn() => Post::query()->count()),

            MenuItem::make('Категории', new CategoryResource())
                ->badge(fn() => Category::query()->count())->icon('heroicons.bars-2'),
            MenuItem::make('Блоки', new ContentBlockResource())
                ->badge(fn() => ContentBlock::query()->count()),
            MenuItem::make('Изображения', new ImageResource())
                ->badge(fn() => Image::query()->count()),
            MenuGroup::make('Контент', [

            ])->icon('heroicons.queue-list'),

            MenuGroup::make('Пользователи', [
                MenuItem::make('moonshine::ui.resource.admins_title', new MoonShineUserResource())
                    ->translatable()
                    ->icon('heroicons.user-group'),
                MenuItem::make('moonshine::ui.resource.role_title', new MoonShineUserRoleResource())
                    ->translatable()
                    ->icon('heroicons.bookmark'),
            ])->translatable(),
            MenuItem::make('FormTable', new FormTable()),
            MenuItem::make('Add post', fn() => route('post.create')),
        ];
    }
}
