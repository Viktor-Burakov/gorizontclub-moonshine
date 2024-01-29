<template>
    <div v-if="image"
         :class="{ hidden: !isEditImage}"
         class="p-dialog-mask p-component-overlay p-component-overlay-enter flex items-center justify-center z-50">
        <div class="p-dialog p-component flex flex-col w-11/12">
            <div class="p-dialog-header flex items-center justify-between">
                <span class="p-dialog-title">{{ image.name }}</span>
                <Button @click="$emit('edit-image-close')"
                        icon="pi pi-times" severity="danger" rounded outlined aria-label="Cancel"/>
            </div>
            <div class="p-dialog-content">
                <div class="basis-full w-full">
                    <div class="input-item">
                        <Image :src="url"
                               preview
                               class="image-gallery__full"
                        />
                    </div>
                    <div class="flex flex-wrap gap-1">
                        <div class="basis-5/12 grow">
                        <span class="p-float-label input-item">
                    <Textarea
                        v-model="image.name"
                        class="w-full min-w-max"
                        autoResize rows="1"
                    />
                    <label>Имя в базе (не отображается)</label>
                         </span>
                        </div>
                        <div>
                            <Button @click="insertNameInAlt" class="mt-2"
                                    v-tooltip.top="'Копировать имя в Alt'"
                                    icon="pi pi-clone" outlined aria-label="Копировать"/>
                        </div>
                        <div class="basis-5/12 grow">
                        <span class="p-float-label input-item">
                    <Textarea v-model="image.alt" class="w-full min-w-max" autoResize rows="1"/>
                    <label>Alt</label>
                </span>
                        </div>
                    </div>
                    <span class="p-float-label input-item">
                <InputText @click="generateSlug" v-model="image.slug" class="w-full"/>
                <label>Имя файла</label>
                </span>
                </div>
            </div>
        </div>
    </div>


</template>

<script>
import {strSlug} from "@/src/helpers/stringHelper.js";

export default {
    name: "ImageEdit",
    data() {
        return {
            url: '',
        }
    },
    props: {
        image: {
            id: null,
            name: '',
            slug: '',
        },
        isEditImage: false
    },
    methods: {
        generateSlug() {
            if (this.image.slug === '' && this.image.name !== '') {
                this.image.slug = strSlug(this.image.name)
            }
        },
        insertNameInAlt() {
            if (this.image.name !== '') {
                this.image.alt = this.image.name
            }
        },
    },
    watch: {
        image(newImage) {
            this.url = newImage.slug
            if (newImage.file) {
                this.url = URL.createObjectURL(newImage.file)
            } else {
                this.url = 'storage/images_test/container/' + newImage.slug
            }
        },
    }
}
</script>
