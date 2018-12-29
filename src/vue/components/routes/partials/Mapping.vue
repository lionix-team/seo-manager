<template>
    <td>
        <button v-if="editing && params.length" class="btn btn-info" @click="openModal">Set Mapping</button>
        <p class="data" v-else>
            <span v-if="mapping" class="badge badge-info">Mapped</span>
            <span v-else>-</span>
        </p>
    </td>
</template>

<script>
    import {EventBus} from "../../../event_bus";

    export default {
        name: "Mapping",
        props: {
            mapping: {
                type: Object
            },
            params:{
                type: Array
            },
            editing:{
                type:Boolean
            }
        },

        methods: {
            openModal() {
                EventBus.$emit('open-modal', 'mapping')
            },
        },
        data() {
            return {

            }
        },
    }
</script>

<style scoped>

</style>
