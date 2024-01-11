<template>
    <Panel>
        <template #header>
            <div class="flex align-items-center gap-3">
                <Badge :value="index"></Badge>
                {{ data.title }}
            </div>

        </template>
        <div class="flex flex-wrap  gap-3">
            <div class="grow">
                        <span class="p-float-label input-item">
                    <InputText id="name" v-model="data.name" class="w-full min-w-max"/>
                    <label for="name">Имя в базе (не отображается)</label>
                </span>
            </div>
            <div class="grow">
                        <span class="p-float-label input-item">
                    <InputText id="title" v-model="data.title" class="w-full min-w-max"/>
                    <label for="title">Title</label>
                </span>
            </div>
        </div>

        <span class="p-float-label">
                    <Textarea v-model="data.description" rows="5" class="w-full" autoResize/>
                    <label>Текст</label>
                </span>
        <image-index :images="data.images"></image-index>
    </Panel>


</template>

<script>
import ImageIndex from "@/src/components/image/ImageIndex.vue";

export default {
    name: "ContentBlockCreateOrEdit",
    components: {ImageIndex},

    props: {
        content_block: {
            default() {
                return {title: null}
            }
        },
        index: {},
    },
    data() {
        return {
            data: {
                id: this.content_block.id,
                name: this.content_block.name,
                title: this.content_block.title,
                description: this.content_block.description,
                images: this.content_block.images,
            }
        };
    },

    mounted() {
        console.log(this.data)
        console.log(this.content_block)

    },

    methods: {}
}
</script>
