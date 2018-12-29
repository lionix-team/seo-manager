<template>
    <td>
        <button v-if="!editing" @click="startEditing" class="btn btn-rounded-circle btn-success start-editing">
            <span class="fe fe-edit"></span>
        </button>
        <button v-else @click="endEditing" class="btn btn-rounded-circle btn-danger start-editing">
            <span class="fe fe-x"></span>
        </button>
        <button @click="deleteRoute" class="btn btn-rounded-circle btn-primary">
            <span class="fe fe-trash"></span>
        </button>
    </td>
</template>

<script>
    import {EventBus} from "../../../event_bus";

    export default {
        name: "Actions",
        props:{
            route:{
                type: Object
            },
            editing: {
                type: Boolean
            }
        },
        data(){
            return {

            }
        },
        methods: {
            startEditing(){
                EventBus.$emit('start-editing', this.route);
                this.$emit('start-editing')
            },
            endEditing(){
                this.$emit('end-editing')
            },
            deleteRoute(){
                this.$swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        EventBus.$emit('delete-route', this.route);
                    }
                 }).then(() => {

                })
            }
        }
    }
</script>

<style scoped>

</style>
