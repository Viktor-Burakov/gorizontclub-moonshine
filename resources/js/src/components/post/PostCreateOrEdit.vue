<template>
    <div class="row">
        <div class="col-1">
            <button class="btn btn-secondary button" @click="add">Add</button>
        </div>

        <div class="col-7">
            <h3>Draggable {{ draggingInfo }}</h3>

            <draggable
                tag="div"
                :list="list"
                class="list-group"
                handle=".handle"
                item-key="id"
            >
                <template #item="{ element, index }">
                    <div class="list-group-item m-2 p-2 flex gap-4">
                        <span class="handle">OOO</span>

                        <span class="text w-1/6">#{{ index }} - {{ element.name }} </span>
                        <span class="text w-1/6"><template v-if="element.id">ID:{{ element.id }}</template></span>

                        <input type="text" class="form-control" v-model="element.name"/>

                        <div class="close text-center align-center" @click="removeAt(index)">X</div>
                    </div>
                </template>
            </draggable>
        </div>

    </div>
</template>

<script>

import draggable from "vuedraggable";

export default {
    name: "handle",
    components: {
        draggable
    },
    data() {
        return {
            list: [
                {name: "00000", text: "231321", id: 3},
                {name: "XXXXXXXXXX", text: "312312", id: 1},
                {name: "Jean", text: "1231", id: 2}
            ],
            dragging: false
        };
    },
    computed: {
        draggingInfo() {
            return this.dragging ? "under drag" : "";
        }
    },
    methods: {
        removeAt(idx) {
            this.list.splice(idx, 1);
        },
        add: function () {
            this.list.push({name: '', text: null});
        }
    }
};
</script>
<style scoped>
.button {
    margin-top: 35px;
}

.handle {
    cursor: pointer;
    padding-top: 8px;
    padding-bottom: 8px;
    background: green;
}

.close {
    cursor: pointer;
}

input {
    display: inline-block;
    width: 50%;
}

.text {
    margin: 20px;
}


</style>
