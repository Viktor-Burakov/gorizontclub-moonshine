<template>
    <div class="flex flex-wrap gap-5">
        <div class="grow">
            <span class="p-buttonset">
    <Button label="Сохранить пост и загрузить файлы" @click="addImages"/>
    </span>
            <div
                @dragenter.prevent="toggleActive"
                @dragleave.prevent="toggleActive"
                @dragover.prevent
                @drop.prevent="droppedImages"
                :class="{ 'dropzone_active': dropzoneActive }"
                class="dropzone input-item"
            >
                <span>Перетащить файлы сюда</span>
                <label for="dropzoneFile" class="p-button p-button-outlined z-10">Выбрать файлы</label>
                <input @change.prevent="choosedImages" type="file" multiple accept="image/*" id="dropzoneFile"
                       class="hidden dropzoneFile"/>
            </div>


        </div>
        <div class="grow">
            <div class="flex flex-col items-end">
                <span class="p-buttonset" v-if="selectedImages">
    <Button label="Добавить из базы" @click="addImages"/>
    <Button label="Сбросить выбор" @click="resetSelect" severity="danger" outlined/>
    </span>
            </div>
            <span class="p-float-label input-item">
                <MultiSelect v-model="selectedImages" :options="imagesSelectedList"
                             display="chip" filter optionLabel="name" class="w-full"/>
                <label>Выбрать из базы</label>
            </span>
        </div>
    </div>


</template>

<script>
export default {
    name: "ImageUpload",
    data() {
        return {
            selectedImages: null,
            uploadImages: [],
            dropzoneActive: false,
        };
    },
    props: {
        imagesSelectedList: {},
        contentBlockIndex: null,
    },
    methods: {
        addImages() {
            this.$emit(
                'add-images',
                this.selectedImages,
                this.contentBlockIndex !== null ? this.contentBlockIndex : null
            )
            this.selectedImages = null
        },
        resetSelect() {
            this.selectedImages = null
        },
        toggleActive() {
            this.dropzoneActive = !this.dropzoneActive;
        },
        choosedImages(e) {
            e.target.files.forEach((image) => {
                this.uploadImages.push(image)
            })
            this.addTempImages()
        },
        droppedImages(e) {
            this.toggleActive()
            e.dataTransfer.files.forEach((image) => {
                this.uploadImages.push(image)
            })
            this.addTempImages()
        },
        addTempImages() {
            this.$emit(
                'add-temp-images',
                this.uploadImages,
                this.contentBlockIndex !== null ? this.contentBlockIndex : null
            )
        },
    },
    watch: {},

    emits: ['add-images', 'add-temp-images'],
}
</script>

<style scoped lang="scss">
.dropzone {
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 1rem;
    align-items: center;
    border: 2px dashed var(--primary-color);
    border-radius: 6px;
    padding: 1rem;
    transition: 0.3s ease all;
}

.dropzone_active {
    color: var(--primary-color-text);
    border-color: var(--primary-color-text);
    background-color: var(--primary-color);

    label {
        background-color: var(--highlight-bg);
        color: var(--highlight-text-color);
    }
}

</style>
