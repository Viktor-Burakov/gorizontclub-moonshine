<template>
    <Image v-if="url" :src="url"
           height="350" preview
    />
    <label
        @dragenter.prevent="toggleActive"
        @dragleave.prevent="toggleActive"
        @dragover.prevent
        @drop.prevent="uploadPreview"
        :class="!dropImageActive ? 'p-button-outlined' : ''"
        class="p-button z-10 w-full justify-center"
        for="previewFile"
    ><i class="pi pi-upload mr-2"></i>Выбрать или перетащить сюда</label>
    <input @change.prevent="uploadPreview" type="file" accept="image/*"
           id="previewFile"
           class="hidden"/>
    <Button v-if="preview !== oldPreview" label="Сбросить" @click="resetPreview" severity="danger" outlined />
</template>

<script>
export default {
    name: "PreviewUpload",
    data() {
        return {
            url: '',
            dropImageActive: false,
            previewFile: {},
        }
    },
    props: {
        preview: {},
        oldPreview: '',
    },
    methods: {
        toggleActive() {
            this.dropImageActive = !this.dropImageActive;
        },
        uploadPreview(e) {
            if (e.target.files) {
                this.previewFile = e.target.files[0]
            }
            if (e.dataTransfer) {
                this.toggleActive()
                this.previewFile = e.dataTransfer.files[0]
            }
            this.$emit('upload-preview',  this.previewFile)
        },
        resetPreview() {
            this.$emit('upload-preview',  this.oldPreview)
        },
    },
    watch: {
        preview() {
            if (typeof(this.preview) === 'object') {
                this.url = URL.createObjectURL(this.preview)
            } else {
                this.url = '/storage/images_test/post_preview/' + this.preview
            }
        },
    },

    emits: ['upload-preview'],
    mounted() {
    }
}
</script>
