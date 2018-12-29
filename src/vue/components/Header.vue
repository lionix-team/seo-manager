<template>
    <div class="header">
        <div class="container-fluid">

            <!-- Body -->
            <div class="header-body">
                <div class="row align-items-center">
                    <div class="col ml--3 ml-md--2">

                        <!-- Pretitle -->
                        <h6 class="header-pretitle">
                            Seo Manager
                        </h6>

                        <!-- Title -->
                        <h1 class="header-title">
                            Routes
                        </h1>

                    </div>
                    <div class="col">
                        <button @click="syncRoutes" :clas="{'is-loading': importing}" class="import-routes btn btn-primary">
                            Sync Routes
                        </button>
                    </div>
                </div> <!-- / .row -->
            </div>

        </div>
    </div>
</template>

<script>
    import {EventBus} from "../event_bus";

    export default {
        name: "AppHeader",
        data(){
            return {
                importing: false
            }
        },
        methods:{
            syncRoutes(){
                EventBus.$emit('sync-routes')
            }
        }
    }
</script>

<style scoped>
    .import-routes{
        float: right;
    }
</style>
