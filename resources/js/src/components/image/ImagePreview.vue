<template>
    <div class="image-gallery__item">
        <Image :src="url"
               :alt="image.alt" height="350"
               @click="$emit('edit-image', image.id)"/>
        <div class="overlay image-gallery__info image-gallery__info_top">
            <div>
                <Badge v-if="image.file" value="NEW" size="xlarge" severity="warning"></Badge>
            </div>
            <div>
                <Button @click="$emit('delete-image')" icon="pi pi-times" severity="danger" rounded
                        aria-label="Delete"/>
            </div>
        </div>
        <div class="overlay image-gallery__info image-gallery__info_bottom handle cursor-move">
            <div>{{ image.id }}</div>
            <div v-if="image.file">{{ bytesToSize(image.file.size) }}</div>
            <div>{{ image.name }}</div>
            <div v-if="image.alt !== image.name"><b>Alt:</b> {{ image.alt }}</div>
            <div>{{ image.slug }}</div>
        </div>
    </div>
</template>

<script>
import {bytesToSize} from "../../helpers/stringHelper.js";

export default {
    name: "ImagePreview",
    data() {
        return {
            url: '',
        }
    },
    props: {
        image: {}
    },
    emits: ['edit-image', 'delete-image'],
    methods: {bytesToSize},
    mounted() {
        if (this.image.file) {
            this.url = URL.createObjectURL(this.image.file)
        } else {
            this.url = 'storage/images_test/container/' + this.image.slug
        }
    },
}
</script>
