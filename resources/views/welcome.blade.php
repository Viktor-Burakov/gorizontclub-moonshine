@extends('layouts.app')

@section('content')
    <x-moonshine::grid>

        @foreach($posts as $post)
            <x-moonshine::column colSpan="4">
                <x-moonshine::card
                    :url="$post->slug"
                    :thumbnail="asset('/storage/images_test/' . $post->preview)"
                    :title="$post->title"
                    :values="[
                            'ID' => $post->id,
                        'Начало' => $post->date_start,
                        'Окончание' => $post->date_end,
                        ]"
                >
                    <x-slot:header>
                        <x-moonshine::badge color="green">new</x-moonshine::badge>
                    </x-slot:header>

                    {{ $post->description }}

                    <x-slot:actions>
                        <x-moonshine::link-button :href="$post->slug">Подробнее</x-moonshine::link-button>
                    </x-slot:actions>
                </x-moonshine::card>
            </x-moonshine::column>
        @endforeach
    </x-moonshine::grid>
@endsection

