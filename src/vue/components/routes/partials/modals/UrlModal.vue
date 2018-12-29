<template>
    <div>
        <div class="modal fade big-modal" :class="{show: showModal}" id="manager-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">URL</h5>
                        <button type="button" @click="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="data-form">
                            <div class="form-row">
                                <div class="col-12 col-md-12 mb-12">
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Leave this field empty to set URL to current route URL" v-model="route.url">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-2 col-md-2 mb-2">
                                    <div class="form-group">
                                        <button type="button" @click="storeUrl"
                                                class="btn btn-primary submit_button" :class="{'is-loading': saving}">
                                            Save URL
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal-backdrop fade" :class="{show: showModal}"></div>
    </div>
</template>

<script>
    import {EventBus} from "../../../../event_bus";

    export default {
        name: "UrlModal",
        props: {
            route: {
                type: Object
            },
            showModal: {
                type: Boolean
            }
        },
        data() {
            return {
                saving: false
            }
        },
        methods: {
            closeModal() {
                EventBus.$emit('close-modal', 'url');
            },
            storeUrl() {
                this.saving = true;
                this.$http.post(API_URL + '/store-data', {
                    id: this.route.id,
                    type: 'url',
                    url: this.route.url
                }).then(response => {
                    this.saving = false;
                    this.closeModal();
                })
            }
        }
    }
</script>

<style scoped>
    .modal-backdrop {
        z-index: -1;
        opacity: 0;
    }

    .modal-backdrop.show {
        z-index: 1040;
        opacity: .5;
    }

    .modal.show {
        opacity: 1 !important;
        display: block !important;
    }
</style>
