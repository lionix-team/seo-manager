<template>
    <td>
        <button v-if="editing" class="btn btn-info" @click="openModal">Set URL</button>
        <p v-else class="data">
            <span v-if="url">{{ url }}</span>
            <span v-else>-</span>
        </p>
    </td>
</template>

<script>
    import {EventBus} from "../../../event_bus";

    export default {
        name: "Url",
        props:{
            url:{
                type: String
            },
            editing:{
                type: Boolean
            }
        },
        methods:{
            openModal(){
                EventBus.$emit('open-modal', 'url')
            }
        }
    }
</script>

<style scoped>

</style>
