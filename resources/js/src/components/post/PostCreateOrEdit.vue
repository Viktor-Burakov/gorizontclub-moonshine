<template>
    <Toast/>
    <div class="loader" v-if="isLoading">
        <ProgressSpinner/>
    </div>

    <image-edit
        :image="images[editImageId]"
        :isEditImage="isEditImage"
        @edit-image-close="editImageClose"
    />

    <div class="p-buttonset my-5">
        <Button label="Сохранить пост" @click="update" class="w-11/12"/>
        <Button @click="deletePost" class="w-1/12"
                icon="pi pi-times" severity="danger" aria-label="Cancel"/>
    </div>


    <Panel header="SEO">
        <div class="flex flex-wrap gap-5 mt-3">
            <div class="flex flex-col gap-3">
                <preview-upload
                    :preview="post.preview"
                    @upload-preview="post.preview = $event"
                />
            </div>
            <div class="grow">
                <span class="p-float-label input-item">
            <Textarea v-model="post.title" autoResize rows="1" class="w-full"/>
            <label>Title</label>
        </span>

                <span class="p-float-label input-item flex flex-wrap gap-5 mt-3">
            <Textarea @click="generateSlug" autoResize rows="1" v-model="post.slug" class="grow"/>
            <label>Url</label>
        </span>

                <span class="p-float-label input-item">
            <Textarea v-model="post.description" autoResize rows="3" class="w-full"/>
            <label>Description</label>
        </span>

                <div class="flex flex-wrap gap-1 input-item">
                    <div class="basis-10/12 grow">
<span class="p-float-label">
                <Textarea v-model="post.h1" autoResize rows="1" class="w-full"/>
            <label>Заголовок H1</label>
            </span>
                    </div>
                    <div>
                        <Button @click="this.post.h1 = this.post.title"
                                v-tooltip.top="'Копировать Title в H1'"
                                icon="pi pi-clone" outlined aria-label="Копировать"/>
                    </div>
                </div>
            </div>
        </div>


    </Panel>

    <Panel header="Основное">
        <div class="input-item flex items-center gap-3">
            <InputSwitch v-model="post.active" class="p-invalid"/>
            <span>Опубликовано</span>
        </div>


        <div class="input-item flex flex-wrap gap-1">
            <div>

            </div>
            <div>

            </div>


        </div>


        <span class="p-float-label input-item">
            <Textarea v-model="post.preview_text" autoResize rows="3" class="w-full"/>
            <label>Анонс</label>
        </span>


        <div class="flex flex-wrap gap-5 mt-3">
            <div>
        <span class="p-float-label input-item">
            <Calendar v-model="post.date_start" showTime hourFormat="24" dateFormat="dd.mm.yy" showIcon/>
            <label>Дата начала</label>
        </span>
            </div>
            <div>
        <span class="p-float-label input-item">
            <Calendar v-model="post.date_end" showTime hourFormat="24" dateFormat="dd.mm.yy" showIcon/>
            <label>Дата окончания</label>
        </span>
            </div>
        </div>
        <span class="p-float-label input-item">
            <MultiSelect v-model="post.categories" :options="categories" optionLabel="title"
                         display="chip" class="w-full"/>
            <label>Разделы</label>
        </span>
    </Panel>


    <div class="flex justify-center">
        <Button label="Новый блок" outlined @click="addContentBlock()" class="w-10/12"/>
    </div>

    <draggable
        :list="post.content_blocks"
        class="list-group flip-list"
        :component-data="{
              type: 'transition-group',
            }"
        v-bind="dragOptions"
        ghostClass="ghost"
        animation="400"
        group="CB"
        handle=".handle"
        item-key="id"
    >
        <template #item="{ element, index, contentBlockIndex = index }">
            <div class="list-group-item">

                <Panel>
                    <template #header>
                        <div class="flex items-center gap-5 handle cursor-move">
                            <i class="pi pi-align-justify text-5xl" style="color: var(--primary-color)"></i>
                            <div>
                                <div>
                                    <Badge :value="index" class="mb-2"></Badge>
                                </div>
                                <div v-if="element.id">#{{ element.id }}</div>
                                <Badge v-else value="NEW" severity="success"></Badge>
                            </div>
                            <div>{{ element.name }}</div>
                        </div>
                    </template>
                    <template #icons>
                        <span class="p-buttonset">
                           <Button v-if="element.id" @click="deleteIdContentBlock(index)"
                                   v-tooltip.top="'Будет создан новый блок на основании существующего'"
                                   label="Отвязать от базы" severity="warning" outlined/>
                            <Button @click="removeContentBlock(index)"
                                    icon="pi pi-times" severity="danger" outlined/>
                        </span>

                    </template>
                    <content-block-create-or-edit
                        :content_block="element"
                        :contentBlocks="contentBlocks"
                    />

                    <template #footer>
                        <image-upload
                            :imagesSelectedList="imagesSelectedList"
                            :contentBlockIndex="index"
                            :parentName="element.name"
                            @add-images-from-db="addImagesFromDB"
                            @add-temp-images="addTempImages"
                        />
                        <draggable
                            :list="element.images"
                            class="list-group flip-list image-gallery mb-5"
                            v-bind="dragOptions"
                            group="CBImages"
                            handle=".handle"
                            item-key="id"
                        >
                            <template #item="{ element, index }">
                                <div class="list-group-item">
                                    <image-preview
                                        :image="images[element.id]"
                                        :editImageId="editImageId"
                                        @edit-image="changeEditImageId"
                                        @delete-image="deleteImage(index, contentBlockIndex)"
                                    />
                                </div>
                            </template>
                        </draggable>
                    </template>
                </Panel>


                <div class="flex justify-center">
                    <Button label="Новый блок" outlined @click="addContentBlock(index)" class="w-10/12"/>
                </div>
            </div>
        </template>
    </draggable>


    <div class="p-buttonset my-5">
        <Button label="Сохранить пост" @click="update" class="w-11/12"/>
        <Button @click="deletePost" class="w-1/12"
                icon="pi pi-times" severity="danger" aria-label="Cancel"/>
    </div>

    <image-upload
        :imagesSelectedList="imagesSelectedList"
        :parentName="post.h1"
        @add-images-from-db="addImagesFromDB"
        @add-temp-images="addTempImages"
    />
    <draggable
        tag="div"
        :list="post.images"
        class="list-group image-gallery mb-5"
        group="Image"
        handle=".handle"
        item-key="id"
    >
        <template #item="{ element, index }">
            <div class="list-group-item">
                <image-preview
                    :image="images[element.id]"
                    :editImageId="editImageId"
                    @edit-image="changeEditImageId"
                    @delete-image="deleteImage(index)"
                />
            </div>
        </template>
    </draggable>


</template>

<script>

import draggable from "vuedraggable";
import {getPost, updatePost, getCategories, getContentBlocks, getImages} from "@/src/api/api";
import ContentBlockCreateOrEdit from "@/src/components/contentBlock/ContentBlockCreateOrEdit.vue";
import ImagePreview from "@/src/components/image/ImagePreview.vue";
import ImageEdit from "@/src/components/image/ImageEdit.vue";
import ImageUpload from "@/src/components/image/ImageUpload.vue";
import {strSlug} from "@/src/helpers/stringHelper.js";
import PreviewUpload from "@/src/components/post/PreviewUpload.vue";
import {uploadImages} from "@/src/api/api.js";

export default {
    name: "PostCreateOrEdit",
    components: {
        PreviewUpload,
        ImageUpload,
        ImageEdit,
        ContentBlockCreateOrEdit,
        ImagePreview,
        draggable
    },
    data() {
        return {
            post: {
                id: null,
                content_blocks: null,
            },

            categories: [],
            contentBlocks: null,
            images: [],
            imagesSelectedList: [],

            dragging: false,
            isLoading: false,
            editImageId: null,
            isEditImage: false,
            drag: false,
        };
    },
    mounted() {
        this.isLoading = true
        getPost(6)
            .then((res) => {
                this.categories = Object.values(res.data.categories)
                this.contentBlocks = Object.values(res.data.contentBlocks)
                this.images = res.data.images
                this.imagesSelectedList = Object.values(res.data.images)
                this.post = res.data.post
            }).catch((err) => {
            this.$toast.add({severity: 'error', summary: 'Ошибка getPost', detail: err.message, life: 5000});
        }).finally(() => {
            this.isLoading = false
        });

    },
    computed: {
        draggingInfo() {
            return this.dragging ? "under drag" : "";
        },
        dragOptions() {
            return {
                animation: 0,
                group: "description",
                disabled: false,
                ghostClass: "ghost"
            };
        }
    },
    methods: {
        removeContentBlock(index) {
            this.post.content_blocks.splice(index, 1);
        },
        deleteIdContentBlock(index) {
            console.log(this.post.content_blocks[index])
            console.log(this.post.content_blocks[index].id)
            this.post.content_blocks[index].id = null
            console.log(this.post.content_blocks[index].id)

        },
        addContentBlock(index) {
            this.post.content_blocks.splice(index + 1, 0, {name: '', images: []});
        },
        addImagesFromDB(images, contentBlockIndex) {
            if (images) {
                images.forEach((image) => {
                    this.attachImages(image, contentBlockIndex)
                })
            }
        },
        attachImages(image, contentBlockIndex = null) {
            if (contentBlockIndex !== null) {
                this.pushImage(this.post.content_blocks[contentBlockIndex].images, image.id)
            } else {
                this.pushImage(this.post.images, image.id)
            }
        },
        pushImage(images, id) {
            if (!images.some(im => im.id === id)) {
                images.push({id: id})
            }
        },
        addTempImages(file, contentBlockIndex) {
            let duplicate = false
            for (const [key, item] of Object.entries(this.images)) {
                if (item.file) {
                    if (item.file.name === file.name &&
                        item.file.size === file.size) {
                        duplicate = true
                    }
                }
            }

            if (duplicate) {
                this.attachImages({id: file.name}, contentBlockIndex)
            } else {
                let name = ''
                if (contentBlockIndex !== null && contentBlockIndex !== undefined) {
                    name = this.post.content_blocks[contentBlockIndex].name
                } else {
                    name = this.post.h1
                }
                const tempImage = {
                    id: file.name,
                    name: name,
                    alt: name,
                    slug: strSlug(name),
                    file: file
                }

                this.images[tempImage.id] = tempImage
                this.attachImages({id: tempImage.id}, contentBlockIndex)
            }
        },
        changeEditImageId(id) {
            this.editImageId = id
            this.isEditImage = true
        },
        deleteImage(index, contentBlockIndex = null) {


            if (contentBlockIndex === null) {
                this.post.images.splice(index, 1)
            } else {
                this.post.content_blocks[contentBlockIndex].images.splice(index, 1)
            }
        },
        editImageClose() {
            this.isEditImage = false
        },
        generateSlug() {
            if (this.post.slug === '' && this.post.name !== '') {
                this.post.slug = strSlug(this.post.title)
            }
        },
        update() {
            this.isLoading = true



            console.log(this.post)
            updatePost(this.post)
                .then((res) => {
                    this.$toast.add({
                        severity: 'success',
                        summary: 'Пост сохранён!',
                        detail: this.post.title,
                        life: 3000
                    });

                    this.updateImages()

                })
                .catch((err) => {
                    this.$toast.add({severity: 'error', summary: 'Ошибка updatePost', detail: err.message, life: 5000});
                })
                .finally(() => {
                    this.isLoading = false
                })
        },
        updateImages() {
            const attachImages = []

            Object.entries(this.post.content_blocks).forEach(([key, contentBlocks]) =>
                Object.entries(contentBlocks['images']).forEach(([key, image]) => {
                    if (!attachImages.includes(this.images[image['id']])) {
                        attachImages.push(this.images[image['id']])
                    }
                }))
            Object.entries(this.post.images).forEach(([key, image]) => {
                if (!attachImages.includes(this.images[image['id']])) {
                    attachImages.push(this.images[image['id']])
                }
            })

            if (typeof(this.post.preview) === 'object') {
                attachImages.push(this.post.preview)
            }
            uploadImages(attachImages)
                .then((res) => {
                    this.$toast.add({
                        severity: 'success',
                        summary: 'Изображения загружаются',
                        detail: '',
                        life: 3000
                    });
                })
                .catch((err) => {
                    this.$toast.add({severity: 'error', summary: 'Ошибка uploadImages', detail: err.message, life: 5000});
                })
        },
        deletePost() {

            this.$toast.add({severity: 'success', summary: 'Пост удален', detail: 'Успешно', life: 3000});
        },


    }


};
</script>
<style scoped>
.flip-list-move {
    transition: transform 1.5s;
}

.no-move {
    transition: transform 0s;
}

.flip-list-enter-active,
.flip-list-leave-active {
    transition: all 1s ease;
}

.flip-list-enter-from,
.flip-list-leave-to {
    opacity: 0;
    transform: translateX(130px);
}

.ghost {
    opacity: 0.5;
    background: #c8ebfb;
}


</style>
