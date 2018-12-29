<template>
    <td>
        <button v-if="editing" class="btn btn-info" @click="openModal">Set OG Data</button>
        <p v-else class="data">
            <span v-if="route.og_data" class="badge badge-info">Og Data Stored</span>
            <span v-else>-</span>
        </p>
    </td>
</template>

<script>
    import {EventBus} from "../../../event_bus";

    export default {
        name: "OgData",
        props: {
            route:{
                type: Object
            },
            editing:{
                type: Boolean
            }
        },
        data(){
            return {}
        },
        methods:{
            openModal(){
                EventBus.$emit('open-modal', 'og_data')
            },
        }
    }
</script>

<style scoped>

</style>
