<template>
    <div class="image-gallery">
        <image-create-or-edit
            v-for="image in images"
            :image="image">
        </image-create-or-edit>
    </div>
</template>

<script>
import ImageCreateOrEdit from "@/src/components/image/ImageCreateOrEdit.vue";

export default {
    name: "ImageIndex",
    components: {ImageCreateOrEdit},

    props: {
        images: {}
    }
}
</script>

<style>

</style>
