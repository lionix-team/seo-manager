<template>
    <div>
        <div class="modal fade big-modal" :class="{show: showModal}" id="manager-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Title Dynamic</h5>
                        <button type="button" @click="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="data-form">
                            <div class="form-row" v-drag-and-drop:options="options">
                                <div class="col-6 col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <!-- Title -->
                                                    <h4 class="card-header-title">
                                                        Mapped Params
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div v-if="route.mapping" v-for="(param, index) in route.mapping">
                                                <span data-type="param" v-for="column in param.selectedColumns"
                                                      class="multiselect__tag draggable">
                                                    {{ index | uppercase }}-{{ column | uppercase}}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <!-- Title -->
                                                    <h4 class="card-header-title">
                                                        Title
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <span v-if="route.title" data-type="title" class="multiselect__tag draggable">{{ route.title }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12">
                                    <div class="form-group">
                                        <multi-select v-model="route.title_dynamic"
                                                      :options="route.title_dynamic"
                                                      :close-on-select="true"
                                                      :show-labels="false"
                                                      placeholder="Drop here for making dynamic title"
                                                      tagPlaceholder="Press Enter to add Custom Text"
                                                      :taggable="true"
                                                      @tag="setTitleDynamic"
                                                      @input="getExampleTitle"
                                                      :multiple="true">
                                        </multi-select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row" v-if="example_title">
                                <div class="col-12 col-md-12">
                                    <p><b>Example Title:</b> {{ example_title }}</p>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-3 col-md-3">
                                    <div class="form-group">
                                        <button type="button" @click="storeTitleDynamic"
                                                class="btn btn-primary submit_button" :class="{'is-loading': saving}">
                                            Save Title Dynamic
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
        name: "TitleDynamicModal",
        props: {
            route: {
                type: Object
            },
            showModal: {
                type: Boolean
            },
            locale: {
                type: String
            }
        },
        data() {
            return {
                example_title: '',
                saving: false,
                options: {}
            }
        },
        created() {
            let that = this;
            this.$data.options = {
                dropzoneSelector: '.dropzone',
                draggableSelector: '.draggable',
                multipleDropzonesItemsDraggingEnabled: false,
                onDragend(event) {
                    that.setTitleDynamic(event.items[0]);
                    event.stop();
                }
            };
            this.getExampleTitle();
        },
        methods: {
            closeModal() {
                EventBus.$emit('close-modal', 'title_dynamic');
            },
            setTitleDynamic(item) {
                let text = item;
                if (item.dataset !== undefined) {
                    if (item.dataset.type === 'title') {
                        text = '~TITLE~';
                    } else if (item.dataset.type === 'param') {
                        text = '{' + item.innerText + '}';
                    }
                }
                this.route.title_dynamic.push(text);
                this.getExampleTitle();
            },
            getExampleTitle() {
                this.$http.post(API_URL + '/get-example-title?locale=' + this.locale, this.route).then(response => {
                    this.example_title = response.data.example_title;
                })
            },
            storeTitleDynamic() {
                this.saving = true;
                this.$http.post(API_URL + '/store-data?locale='+this.locale, {
                    id: this.route.id,
                    type: 'title_dynamic',
                    title_dynamic: this.route.title_dynamic
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

    .dropzone {
        min-height: 50px;
    }
</style>
