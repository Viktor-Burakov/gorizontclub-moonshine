<template>
    <div v-if="image"
         :class="{ hidden: !isEditImage}"
         class="p-dialog-mask p-component-overlay p-component-overlay-enter flex items-center justify-center">
        <div class="p-dialog p-component flex flex-col w-11/12">
            <div class="p-dialog-header flex items-center justify-between">
                <span class="p-dialog-title">{{ image.name }}</span>
                <Button @click="$emit('edit-image-close')"
                        icon="pi pi-times" severity="danger" rounded outlined aria-label="Cancel"/>
            </div>
            <div class="p-dialog-content">
                <div class="basis-full w-full">
                    <div class="input-item">
                        <Image :src="`storage/images_test/container/${url}`"
                               preview
                               class="image-gallery__full"
                        />
                    </div>
                    <div class="flex flex-row flex-wrap">
                        <div class="basis-1/2 pr-1">
                        <span class="p-float-label input-item">
                    <InputText
                        v-model="image.name"
                        class="w-full min-w-max"
                    />
                    <label>Имя в базе (не отображается)</label>
                         </span>
                        </div>
                        <div class="basis-1/2 pr-1">
                        <span class="p-float-label input-item">
                    <InputText v-model="image.alt" class="w-full min-w-max"/>
                    <label>Alt</label>
                </span>
                        </div>
                    </div>
                    <span class="p-float-label input-item">
                <InputText v-model="image.slug" class="w-full"/>
                <label>Имя файла</label>
                </span>
                </div>
            </div>
        </div>
    </div>


</template>

<script>
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
        },
        isEditImage: false
    },
    methods: {
    },
    watch: {
        image(newValue) {
            this.url = newValue.slug
        },
    }
}
</script>
