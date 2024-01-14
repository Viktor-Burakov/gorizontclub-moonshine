<template>
    <div class="flex flex-wrap gap-5">
        <div class="grow">
            <span class="p-float-label input-item">
                <Dropdown v-model="selectedBlock" editable :options="contentBlocks" filter
                optionLabel="name" class="w-full"/>
                <label>Имя в базе (не отображается)</label>
            </span>
        </div>
        <div class="grow">
            <span class="p-float-label input-item">
                <InputText v-model="content_block.title" class="w-full min-w-max"/>
                <label>Заголовок H2</label>
            </span>
            </div>
    </div>

    <span class="p-float-label input-item">
        <Textarea v-model="content_block.description" autoResize rows="3" class="w-full"/>
        <label>Контент</label>
    </span>

</template>

<script>

import {getContentBlock} from "@/src/api/api.js";

export default {
    name: "ContentBlockCreateOrEdit",
    components: {},

    props: {
        content_block: {},
        contentBlocks: {},
        index: {},
    },
    data() {
        return {
            selectedBlock: null,
        };
    },

    mounted() {
        this.selectedBlock = this.contentBlocks.find(cb => cb.id === this.content_block.id)
    },

    watch: {
        selectedBlock(block) {
            if (typeof block === 'object' && block !== null) {
                this.isLoading = true;
                getContentBlock(block.id)
                    .then((res) => {
                        this.content_block.id = res.data.id
                        this.content_block.name = res.data.name
                        this.content_block.title = res.data.title
                        this.content_block.description = res.data.description
                        this.content_block.images = res.data.images
                    }).catch((err) => {
                    this.$toast.add({
                        severity: 'error',
                        summary: 'Ошибка getContentBlock',
                        detail: err.message,
                        life: 5000
                    });
                }).finally(() => {
                    this.isLoading = false
                });
            } else {
                this.content_block.name = block
            }

        },
    },

    methods: {}
}
</script>
