<template>
    <td>
        <button v-if="editing" class="btn btn-info" @click="openModal">Set Keywords</button>
        <p v-else>
            <span v-if="keywords" v-for="keyword in keywords" class="badge badge-soft-info">{{ keyword }}</span>
            <span v-else>-</span>
        </p>
    </td>
</template>

<script>
    import {EventBus} from "../../../event_bus";

    export default {
        name: "Keywords",
        props: {
            keywords: {
                type: Array
            },
            editing: {
                type: Boolean
            }
        },
        methods:{
            openModal(){
               EventBus.$emit('open-modal', 'keywords')
            }
        }

    }
</script>

<style scoped>
    .badge{
        margin-right: 3px;
    }
</style>
