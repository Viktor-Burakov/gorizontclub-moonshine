<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data
      :class="$ctore.darkMode.on && 'dark'"
      xmlns:x-moonshine="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>
    @moonShineAssets


</head>
<x-moonshine::layout>
    <x-moonshine::layout.flash/>

    <x-moonshine::layout.top-bar :home_route="route('home')">
        <x-moonshine::layout.menu/>
    </x-moonshine::layout.top-bar>

    <main class="layout-page">
        <x-moonshine::grid>
            <x-moonshine::column>
                <x-moonshine::layout.header
                    :notification="false"
                    :locales="false"/>

                <x-moonshine::layout.content/>
            </x-moonshine::column>
        </x-moonshine::grid>
    </main>

</x-moonshine::layout>
</html>
