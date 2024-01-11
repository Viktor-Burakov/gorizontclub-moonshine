<template>

    <div class="image-gallery__item">
        <Image :src="`storage/images_test/container/${image.slug}`"
               :alt="image.alt" height="350"
               @click="toggle"/>
        <div class="overlay image-gallery__info">
            <div>{{ image.name }}</div>
            <div v-if="image.alt != image.name"><b>Alt:</b> {{ image.alt }}</div>
            <div>{{ image.slug }}</div>
        </div>

    </div>
    <OverlayPanel ref="op" class="w-10/12">
        <div class="input-item">
            <Image :src="`storage/images_test/container/${image.slug}`"
                   :alt="image.alt"
                   @click="toggle"
                   class="image-gallery__full"
            />
        </div>
        <div class="flex flex-row flex-wrap">
            <div class="basis-1/2 pr-1">
                    <span class="p-float-label input-item">
                <InputText id="name" v-model="image.name" class="w-full min-w-max"/>
                <label for="name">Имя в базе (не отображается)</label>
                     </span>
            </div>
            <div class="basis-1/2 pr-1">
                    <span class="p-float-label input-item">
                <InputText id="alt" v-model="image.alt" class="w-full min-w-max"/>
                <label for="alt">Alt</label>
            </span>
            </div>
        </div>
        <span class="p-float-label input-item">
            <InputText id="slug" v-model="image.slug" class="w-full"/>
            <label for="slug">Имя файла</label>
            </span>
    </OverlayPanel>

</template>

<script>
export default {
    name: "ImageCreateOrEdit",

    props: {
        image: {}
    },
    methods: {
        toggle(event) {
            this.$refs.op.toggle(event);
        }
    }
}
</script>
