@extends('layouts.app')

@section('content')

    <x-moonshine::form name="post">

        
        <x-moonshine::form.label name="title" required>
            Title
        </x-moonshine::form.label>
        <x-moonshine::form.input
            name="title"
            value="{{ old('title', $post->title) }}"
        />
        <x-moonshine::form.label name="slug" for="slug" required>
            Slug
        </x-moonshine::form.label>
        <x-moonshine::form.input
            name="slug"
            id="slug"
            value="{{ old('slug', $post->slug)}}"
        />


        <x-slot:buttons>
            <x-moonshine::form.button type="reset">Cancel</x-moonshine::form.button>
            <x-moonshine::form.button class="btn-primary">Submit</x-moonshine::form.button>
        </x-slot:buttons>
    </x-moonshine::form>










    {{$form->render()}}
    <x-moonshine::divider/>

    @foreach ($contentBlocks as $contentBlock)
        <x-moonshine::box :dark="true">
            {{$contentBlock['form']->render()}}
            @if(isset($contentBlock['images']))
                <x-moonshine::grid class="my-5">


                    @foreach ($contentBlock['images'] as $image)
                        <x-moonshine::column adaptiveColSpan="12" colSpan="3"
                                             class="flex flex-col justify-center items-center">
                            <img src="{{$image['preview']}}" alt="" class="max-h-64 mx-auto">
                            <span>{{$image['name']}}</span>
                        </x-moonshine::column>
                    @endforeach
                </x-moonshine::grid>

                <x-moonshine::collapse title="Редактировать изображения">

                    @foreach ($contentBlock['images'] as $image)
                        {{$image['form']->render()}}
                        <hr>
                    @endforeach
                </x-moonshine::collapse>
            @endif
        </x-moonshine::box>
        <x-moonshine::divider/>
    @endforeach


    <hr>
    <hr>
    {{$formContentBlock->render()}}
    <hr>

    <x-moonshine::badge color="primary">
        <x-moonshine::title>Галерея</x-moonshine::title>
    </x-moonshine::badge>


    @foreach ($images as $image)
        {{$image->render()}}
        <hr>
    @endforeach

@endsection

