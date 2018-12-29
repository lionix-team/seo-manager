<template>
    <td>
        <button v-if="editing" class="btn btn-info" @click="openModal">Set Title</button>
        <p v-else class="data">
            <span v-if="title">{{ title }}</span>
            <span v-else>-</span>
        </p>
    </td>
</template>

<script>
    import {EventBus} from "../../../event_bus";

    export default {
        name: "Title",
        props: {
            title:{
                type: String
            },
            editing:{
                type: Boolean
            }
        },
        methods:{
            openModal(){
                EventBus.$emit('open-modal', 'title')
            }
        }
    }
</script>

<style scoped>

</style>
