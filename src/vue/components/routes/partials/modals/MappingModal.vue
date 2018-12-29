<template>
    <div>
        <div class="modal fade" :class="{show: showModal}" id="manager-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Params Mapping</h5>
                        <button type="button" @click="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="data-form">
                            <div class="form-row" v-for="(param, index) in params" :key="index">
                                <div class="col-12 col-md-3 mb-3">
                                    <div class="form-group">
                                        <label>Param</label>
                                        <p class="form-control">{{ index }}</p>
                                    </div>
                                </div>
                                <div class="col-12 col-md-3 mb-3">
                                    <div class="form-group">
                                        <label>Model</label>
                                        <multi-select @input="getModelColumns(param, index)"
                                                      v-model="param.model"
                                                      :options="models"
                                                      track-by="path"
                                                      label="name"
                                                      placeholder="Param Model"
                                                      :show-labels="false">
                                        </multi-select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-3 mb-3">
                                    <div class="form-group">
                                        <label>Find By: </label>
                                        <multi-select v-model="param.find_by"
                                                      :options="param.columns"
                                                      placeholder="Find By Column"
                                                      :show-labels="false">
                                        </multi-select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-3 mb-3">
                                    <div class="form-group">
                                        <label>Use Columns (for Mapping): </label>
                                        <multi-select v-model="param.selectedColumns"
                                                      :options="param.columns"
                                                      :close-on-select="false"
                                                      :show-labels="false"
                                                      placeholder="Columns for use"
                                                      :multiple="true">
                                        </multi-select>
                                    </div>
                                </div>
                            </div>

                            <button @click="storeMapping" type="button" :class="{'is-loading': saving}"
                                    class="btn btn-primary submit_button">Map Data
                            </button>
                        </form>
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
        name: "MappingModal",
        props: {
            route: {
                type: Object
            },
            showModal: {
                type: Boolean
            }
        },
        components: {

        },
        data() {
            return {
                saving: false,
                params: {},
                models: [],
                mapping: {
                    model: null,
                    find_by: null,
                    columns: [],
                    selectedColumns: []
                }
            }
        },
        mounted() {
            this.getModels();
            for (let i = 0; i < this.route.params.length; i++) {
                let param = this.route.params[i];
                let mapping = Object.assign({}, this.mapping);

                if (this.route.mapping !== null && this.route.mapping[param] !== undefined) {
                    mapping = this.route.mapping[param];
                }
                this.$set(this.params, param, mapping);
                // this.params[param] = mapping;
                if (mapping.model) {
                    this.getModelColumns(mapping, param);
                }
            }
        },
        methods: {
            closeModal() {
                EventBus.$emit('close-modal', 'mapping');
            },
            getModels() {
                this.$http.get(API_URL + '/get-models').then(response => {
                    this.models = response.data.models;
                })
            },
            getModelColumns(mapping, param) {
                this.$http.post(API_URL + '/get-model-columns', {model: mapping.model.path}).then(response => {
                    this.params[param].columns = response.data.columns;
                })
            },
            storeMapping() {
                this.saving = true;
                this.$http.post(API_URL + '/store-data', {
                    id: this.route.id,
                    type: 'mapping',
                    mapping: this.params
                }).then(response => {
                    this.saving = false;
                    this.route.mapping = response.data.mapping;
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

    .modal.fade .modal-dialog {
        width: 80% !important;
        max-width: 1500px;
    }
</style>
