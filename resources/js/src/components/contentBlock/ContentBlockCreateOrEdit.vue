<template>
    <div class="flex flex-wrap gap-5 mt-3">
        <div class="grow">
            <span class="p-float-label input-item">
                <Dropdown v-model="selectedBlock" @change="changeBlock" :options="contentBlocks"
                          filter editable optionLabel="name" class="w-full"/>
                <label>Имя в базе (не отображается)</label>
            </span>
        </div>
        <div class="grow">


            <div class="flex flex-wrap gap-1 ">
                <div class="basis-10/12 grow">
                    <span class="p-float-label input-item">
                        <InputText v-model="content_block.title" class="w-full min-w-max"/>
                        <label>Заголовок H2</label>
                    </span>
                </div>
                <div class="input-item">
                    <Button @click="content_block.title = content_block.name"
                            v-tooltip.top="'Копировать Title в H1'"
                            icon="pi pi-clone" outlined aria-label="Копировать"/>
                </div>
            </div>


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
        if (this.content_block.id) {
            this.selectedBlock = this.contentBlocks.find(cb => cb.id === this.content_block.id);
        } else {
            this.selectedBlock = this.content_block.name
        }
    },

    watch: {},

    methods: {
        async changeBlock(e) {
            const block = e.value
            if (typeof block === 'object' && block !== null) {
                try {
                    const res = await getContentBlock(block.id)

                    this.content_block.id = res.data.id
                    this.content_block.name = res.data.name
                    this.content_block.title = res.data.title
                    this.content_block.description = res.data.description
                    this.content_block.images = res.data.images
                } catch (err) {
                    this.$toast.add({
                        severity: 'error',
                        summary: 'Ошибка getContentBlock',
                        detail: err.message,
                        life: 5000
                    })
                }
            } else {
                this.content_block.name = block
            }
        },
    }
}
</script>
