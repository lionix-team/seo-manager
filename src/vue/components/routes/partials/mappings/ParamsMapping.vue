<template>
    <div>
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Map Og Data {{ current }} {{ subParam }}</h5>
                    <button type="button" @click="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="data-form">
                        <div class="form-row">
                            <div class="col-10 col-md-10 mb-10">
                                <div class="form-group">
                                    <multi-select v-model="param.value"
                                                  :options="mappedParams"
                                                  :close-on-select="true"
                                                  :show-labels="false"
                                                  placeholder="Params">
                                    </multi-select>
                                </div>
                            </div>
                            <div class="col-2 col-md-2 mb-2">
                                <div class="form-group">
                                    <button type="button" @click="storeParam" :class="{'is-loading':saving}"
                                            class="btn btn-primary submit_button">Map {{ current }} {{ subParam }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ParamsMapping",
        props: {
            ogData: {
                type: Object
            },
            current: {
                type: String
            },
            subParam: {
                type: String
            },
            route: {
                type: Object
            }
        },
        data() {
            return {
                saving: false,
                mappedParams: []
            }
        },
        computed:{
            param(){
                return (this.subParam !== undefined) ? this.ogData[this.current].data[this.subParam] : this.ogData[this.current].data;
            }
        },
        mounted() {
            for (let param in this.route.mapping) {
                for (let column in this.route.mapping[param].selectedColumns) {
                    let col = this.route.mapping[param].selectedColumns[column];
                    let item = param.toUpperCase() + '-' + col.toUpperCase();
                    this.mappedParams.push(item);
                }
            }
        },
        methods: {
            closeModal() {
                this.$emit('finish-mapping');
            },
            storeParam() {
                this.saving = true;
                this.param.mapped = true;
                this.closeModal();
            }
        }
    }
</script>

<style scoped lang="scss">
    .modal-lg {
        max-width: 1200px;
    }
</style>
