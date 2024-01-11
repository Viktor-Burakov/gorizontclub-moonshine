<template>
    <Panel header="Header">
        <DataTable :value="posts"
                   tableStyle="min-width: 50rem"
                   paginator :rows="10" :rowsPerPageOptions="[10, 25, 100]"
                   stripedRows
        >
            <template #header>
                <div class="flex flex-wrap align-items-center justify-content-between gap-2">
                    <span class="text-xl text-900 font-bold">Посты</span>
                </div>
            </template>

            <Column field="id" header="Id" sortable></Column>
            <Column field="active" header="Опубл." dataType="boolean" style="min-width: 6rem" sortable>
                <template #body="{ data }">
                    <i class="pi"
                       :class="{ 'pi-check-circle text-green-500': data.active, 'pi-times-circle text-red-400': !data.active }"></i>
                </template>
            </Column>
            <Column field="title" header="Title" sortable></Column>
            <Column field="preview" header="Preview">
                <template #body="{ data }">
                    <div class="flex align-items-center gap-2">
                        <img alt="" :src="`storage/images_test/post_preview/${data.preview}`"
                             style="width: 100px"/>
                    </div>
                </template>
            </Column>
            <Column field="h1" header="Заголовок (H1)" sortable></Column>
            <Column field="date_start" header="Даты" sortable>
                <template #body="{ data }">
                    {{ data.date_start }}<br>
                    {{ data.date_end }}


                </template>
            </Column>
            <Column field="categories" header="Разделы">
                <template #body="{ data }">
                    <Tag v-for="category in data.categories">
                        {{ category.title }}
                    </Tag>
                </template>
            </Column>


        </DataTable>
    </Panel>
</template>

<script>
import {getPosts} from '@/src/api/posts'

export default {
    name: "PostIndex",

    data() {
        return {
            posts: null,
        };
    },

    mounted() {
        getPosts()

            .then((res) => (this.posts = res.data))
    }


}
</script>

<style scoped>

</style>
