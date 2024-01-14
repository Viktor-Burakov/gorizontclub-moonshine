<template>
    <div class="flex flex-wrap gap-5">
        <div class="grow">
                            <span class="p-float-label input-item">
                                <InputText v-model="content_block.name" class="w-full min-w-max"/>
                                <label>Имя в базе (не отображается)</label>
                             </span>
        </div>
        <div class="grow">
            <Dropdown v-model="selectedCountry" :options="countries" filter optionLabel="name" placeholder="Select a Country" class="w-full input-item">
                <template #value="slotProps">
                    <div v-if="slotProps.value" class="flex align-items-center">
                        <img :alt="slotProps.value.label" src="https://primefaces.org/cdn/primevue/images/flag/flag_placeholder.png" :class="`mr-2 flag flag-${slotProps.value.code.toLowerCase()}`" style="width: 18px" />
                        <div>{{ slotProps.value.name }}</div>
                    </div>
                    <span v-else>
            {{ slotProps.placeholder }}
        </span>
                </template>
                <template #option="slotProps">
                    <div class="flex align-items-center">
                        <img :alt="slotProps.option.label" src="https://primefaces.org/cdn/primevue/images/flag/flag_placeholder.png" :class="`mr-2 flag flag-${slotProps.option.code.toLowerCase()}`" style="width: 18px" />
                        <div>{{ slotProps.option.name }}</div>
                    </div>
                </template>
            </Dropdown>
        </div>
    </div>

    <span class="p-float-label input-item">
                                <InputText v-model="content_block.title" class="w-full min-w-max"/>
                                <label>Заголовок H2</label>
                             </span>

    <span class="p-float-label input-item">
                        <Textarea v-model="content_block.description" autoResize rows="3" class="w-full"/>
                        <label>Контент</label>
                    </span>

</template>

<script>

export default {
    name: "ContentBlockCreateOrEdit",
    components: {},

    props: {
        content_block: {},
        index: {},
    },
    // data() {
    //     return {
    //         data: {
    //             id: this.content_block.id,
    //             name: this.content_block.name,
    //             title: this.content_block.title,
    //             description: this.content_block.description,
    //             images: this.content_block.images,
    //         }
    //     };
    // },

    mounted() {
    },

    methods: {}
}
</script>
