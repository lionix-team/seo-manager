<template>
    <div>
        <div class="modal fade big-modal" :class="{show: showModal}" id="manager-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Title</h5>
                        <button type="button" @click="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="data-form">
                            <div class="form-row">
                                <div class="col-12 col-md-12 mb-12">
                                    <div class="form-group">
                                        <input class="form-control" v-model="route.title">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-2 col-md-2 mb-2">
                                    <div class="form-group">
                                        <button type="button" @click="storeTitle"
                                                class="btn btn-primary submit_button" :class="{'is-loading': saving}">
                                            Save Title
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
        name: "TitleModal",
        props: {
            route: {
                type: Object
            },
            showModal: {
                type: Boolean
            },
            locale:{
                type: String
            }
        },
        data() {
            return {
                saving: false
            }
        },
        methods: {
            closeModal() {
                EventBus.$emit('close-modal', 'title');
            },
            storeTitle() {
                console.log('storetitle');
                console.log(CSRF_TOKEN);
                let local_csrf_token = CSRF_TOKEN;
                console.log(local_csrf_token);
                this.saving = true;
                this.$http.post(API_URL + '/store-data?locale='+this.locale,
                    {
                    id: this.route.id,
                    type: 'title',
                    title: this.route.title,
                    _token: CSRF_TOKEN
                    }).then(response => {
                    this.saving = false;
                    EventBus.$emit('title-changed');
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
