<template>
    <div class="image-gallery__item">
        <Image :src="`storage/images_test/container/${url}`"
               :alt="image.alt" height="350"
               @click="$emit('edit-image', image.id)"/>
        <div class="overlay image-gallery__info handle cursor-move">
            <div>{{ image.name }}</div>
            <div v-if="image.alt !== image.name"><b>Alt:</b> {{ image.alt }}</div>
            <div>{{ image.slug }}</div>
        </div>
    </div>

</template>

<script>
export default {
    name: "ImagePreview",
    data() {
        return {
            url: '',
        }
    },
    props: {
        image: {
        },
        editImageId: null
    },
    emits: ['edit-image'],
    methods: {
    },
    mounted() {
        this.url = this.image.slug
    },
}
</script>
