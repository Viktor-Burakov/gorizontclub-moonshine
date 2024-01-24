<template>

            <div
                @dragenter.prevent="toggleActive"
                @dragleave.prevent="toggleActive"
                @dragover.prevent
                @drop.prevent="droppedImages"
                :class="{ 'dropzone_active': dropzoneActive }"
                class="dropzone"
            >
                <label :for="'dropzoneFile_'+contentBlockIndex" class="p-button p-button-outlined z-10">Перетащить
                    изображения сюда или выбрать
                    файлы</label>
                <input @change.prevent="choosedImages" type="file" multiple accept="image/*"
                       :id="'dropzoneFile_'+contentBlockIndex"
                       class="hidden dropzoneFile"/>

                <div class="flex flex-col items-end gap-7">
                <span class="p-buttonset" v-if="selectedImages">
    <Button label="Добавить из базы" @click="addImagesFromDB"/>
    <Button label="Сбросить выбор" @click="resetSelect" severity="danger" outlined/>
    </span>
                    <span class="p-float-label">
                <MultiSelect v-model="selectedImages" :options="imagesSelectedList"
                             display="chip" filter optionLabel="name" class="w-full min-w-48"/>
                <label>Выбрать из базы</label>
            </span>
                </div>

            </div>





</template>

<script>
import ImagePreview from "@/src/components/image/ImagePreview.vue";
import draggable from "vuedraggable";
import {strSlug} from "@/src/helpers/stringHelper.js";

export default {
    name: "ImageUpload",
    components: {draggable, ImagePreview},
    data() {
        return {
            selectedImages: null,
            dropzoneActive: false,
        };
    },
    props: {
        imagesSelectedList: {},
        contentBlockIndex: null,
        parentName: '',
    },
    methods: {
        addImagesFromDB() {
            this.$emit(
                'add-images-from-db',
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
                this.addTempImages(image)
            })

        },
        droppedImages(e) {
            this.toggleActive()
            e.dataTransfer.files.forEach((image) => {
                this.addTempImages(image)
            })
        },
        addTempImages(image) {
            this.$emit(
                'add-temp-images',
                image,
                this.contentBlockIndex !== null ? this.contentBlockIndex : null
            )
        },
    },
    watch: {},

    emits: ['add-images-from-db', 'add-temp-images'],
    mounted() {
    }
}
</script>

<style scoped lang="scss">
.dropzone {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 1rem;
    align-items: center;
    border: 2px dashed var(--primary-color);
    border-radius: 6px;
    padding: 1rem;
    margin-top: 0.5rem;
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
