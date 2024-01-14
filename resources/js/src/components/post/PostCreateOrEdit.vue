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
            <template #item="{ element, index }">
                <div class="list-group-item">

                    <Panel>
                        <template #header>
                            <div class="flex items-center gap-5 handle cursor-move">
                                <i class="pi pi-align-justify text-5xl" style="color: var(--primary-color)"></i>
                                <div>
                                    <div>
                                        <Badge :value="index"  class="mb-2"></Badge>
                                    </div>
                                    <div v-if="element.id">#{{ element.id }}</div>
                                    <Badge v-else value="NEW" severity="success"></Badge>
                                </div>
                                <div>{{ element.name }}</div>
                            </div>
                        </template>
                        <template #icons>
                            <Button @click="removeContentBlock(index)"
                                    icon="pi pi-times" severity="danger" outlined aria-label="Cancel"/>
                        </template>

                        <content-block-create-or-edit
                            :content_block="element"
                            :contentBlocks="contentBlocks"
                        />

                        <template #footer>
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

    <div style="height: 50px" class="border-2 border-dashed surface-border"></div>

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

export default {
    name: "PostCreateOrEdit",
    components: {
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

            dragging: false,
            isLoading: false,
            editImageId: null,
            isEditImage: false,
            drag: false
        };
    },
    mounted() {
        this.isLoading = true

        getPost(6)
            .then((res) => {
                this.categories = res.data.categories
                this.contentBlocks = Object.values(res.data.contentBlocks)
                this.images = res.data.images
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
        addContentBlock: function (index) {
            this.post.content_blocks.splice(index + 1, 0, {name: ''});
        },
        update() {
            this.isLoading = true
            updatePost(this.post)
                .then((res) => {
                    console.log(res.data)
                    this.$toast.add({
                        severity: 'success',
                        summary: 'Пост сохранён!',
                        detail: this.post.title,
                        life: 3000
                    });
                })
                .catch((err) => {
                    this.$toast.add({severity: 'error', summary: 'Ошибка', detail: err.message, life: 5000});
                })
                .finally(() => {
                    this.isLoading = false
                })
        },
        deletePost() {
            const id = 154
            const a = this.post.findIndex(x => x.id === id)
            const pos = this.post.images.map(e => e.id).indexOf(id);
            console.log(a)
            console.log(pos)
            this.$toast.add({severity: 'success', summary: 'Пост удален', detail: 'Успешно', life: 3000});
        },
        changeEditImageId(id) {
            this.editImageId = id
            this.isEditImage = true
        },
        editImageClose() {
            this.isEditImage = false
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
