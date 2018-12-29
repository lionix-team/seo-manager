<template>
    <td>
        <button v-if="editing" class="btn btn-info" @click="openModal">Set Author</button>
        <p v-else class="data">
            <span v-if="author">{{ author }}</span>
            <span v-else>-</span>
        </p>
    </td>
</template>

<script>
    import {EventBus} from "../../../event_bus";

    export default {
        name: "Author",
        props: {
            author:{
                type: String
            },
            editing:{
                type: Boolean
            }
        },
        methods:{
            openModal(){
                EventBus.$emit('open-modal', 'author')
            }
        }
    }
</script>

<style scoped>

</style>
