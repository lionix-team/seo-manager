<template>
    <td>
        <button v-if="editing" class="btn btn-info" @click="openModal">Set Description</button>
        <p v-else class="data">
            <span v-if="description">{{ description }}</span>
            <span v-else>-</span>
        </p>
    </td>
</template>

<script>
    import {EventBus} from "../../../event_bus";

    export default {
        name: "Description",
        props: {
            description:{
                type: String
            },
            editing:{
                type: Boolean
            }
        },
        methods:{
            openModal(){
                EventBus.$emit('open-modal', 'description')
            }
        }

    }
</script>

<style scoped>

</style>
