<div x-id="['belongs-to-many']" :id="$id('belongs-to-many')" data-field-block="{{ $element->column() }}">


    <div x-data="pivot" x-init="autoCheck">
        <x-moonshine::action-group
            class="mb-4"
            :actions="$element->getButtons()"
        />

        {{ $element->value(withOld: false)->render() }}
    </div>

</div>
