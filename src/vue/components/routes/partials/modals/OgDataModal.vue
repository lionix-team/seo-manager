<template>
    <div>
        <div class="modal fade big-modal" :class="{show: showModal}" id="manager-modal" tabindex="-1" role="dialog">
            <div v-if="!mapping" class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="row align-items-center open-header">
                            <div class="col">
                                <h5 class="modal-title">Open Graph</h5>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-success preview" @click="preview">Preview</button>
                            </div>
                            <div class="col-auto">
                                <button type="button" @click="closeModal" class="close" data-dismiss="modal"
                                        aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div id="data-form">
                            <div class="form-row">
                                <div class="col-12 col-md-12">
                                    <table class="table text-left">
                                        <thead>
                                        <tr>
                                            <td>Property</td>
                                            <td>Content</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-if="ogData[key].visibility" v-for="(item, key, index) in ogData">
                                            <td>{{ key }}</td>
                                            <td>
                                                <div class="form-group" v-if="key === 'type'">
                                                    <multi-select @input="change()"
                                                                  v-model="ogData[key].data.value"
                                                                  :options="types"
                                                                  placeholder="Select OG Type"
                                                                  :show-labels="false">
                                                    </multi-select>
                                                </div>
                                                <div class="form-group"
                                                     v-else-if="hiddenParams.indexOf(key) !== -1 || key === 'image'">
                                                    <label class="input-label"
                                                           v-for="(property, dataKey, dataIndex) in item.data">
                                                        <div class="input-group mb-3">
                                                            <input class="form-control" type="text"
                                                                   v-model="ogData[key].data[dataKey].value"
                                                                   :readonly="ogData[key].data[dataKey].mapped"
                                                                   :placeholder="dataKey">
                                                            <div v-if="ogData[key].data[dataKey].mapped"
                                                                 class="input-group-append">
                                                                <button @click="removeMapping(key,dataKey)"
                                                                        class="btn btn-danger"
                                                                        type="button">
                                                                    <i class="fe fe-x"></i>
                                                                </button>
                                                            </div>
                                                            <div v-else class="input-group-append">
                                                                <button @click="setMapping(key,dataKey)"
                                                                        class="btn btn-primary"
                                                                        type="button">
                                                                    <i class="fe fe-link-2"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                                <div class="form-group" v-else>
                                                    <div class="input-group mb-12">
                                                        <input class="form-control"
                                                               type="text"
                                                               :placeholder="key"
                                                               :readonly="ogData[key].data.mapped"
                                                               v-model="ogData[key].data.value"/>
                                                        <div v-if="ogData[key].data.mapped" class="input-group-append">
                                                            <button @click="removeMapping(key)"
                                                                    class="btn btn-danger"
                                                                    type="button">
                                                                <i class="fe fe-x"></i>
                                                            </button>
                                                        </div>
                                                        <div v-else class="input-group-append">
                                                            <button @click="setMapping(key)"
                                                                    class="btn btn-primary"
                                                                    type="button">
                                                                <i class="fe fe-link-2"></i>
                                                            </button>
                                                        </div>

                                                    </div>
                                                    <p v-if="key === 'url'" class="url-feedback">Leave this field empty
                                                        to map to route url</p>
                                                </div>

                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-3 col-md-3">
                                    <div class="form-group">
                                        <button type="button"
                                                @click="save"
                                                class="btn btn-primary submit_button" :class="{'is-loading': saving}">
                                            Save Open Graph Data
                                        </button>
                                        <span class="text-success" v-if="saved">Saved</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Mappings-->
            <app-title-mapping v-if="showTitleMapping" @finish-mapping="finishMapping" :ogData="ogData"
                               :current="current" :route="route" :locale="locale"></app-title-mapping>
            <app-params-mapping v-if="showParamsPapping" @finish-mapping="finishMapping" :ogData="ogData"
                                :current="current" :subParam="subParam" :route="route"></app-params-mapping>
            <app-preview-modal v-if="showPreviewModal" @close-preview="closePreview" :route="route" :locale="locale"></app-preview-modal>
        </div>
        <div class="modal-backdrop fade" :class="{show: showModal}"></div>
    </div>
</template>

<script>
    import {EventBus} from "../../../../event_bus";
    import TitleMapping from '../mappings/TitleMapping'
    import ParamsMapping from '../mappings/ParamsMapping'
    import PreviewModal from './PreviewModal'

    export default {
        name: "OgDataModal",
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
        components: {
            'app-title-mapping': TitleMapping,
            'app-params-mapping': ParamsMapping,
            'app-preview-modal': PreviewModal
        },
        data() {
            return {
                showTitleMapping: false,
                showParamsPapping: false,
                showPreviewModal: false,
                types: [
                    'website',
                    'article',
                    'profile',
                    'audio',
                    'video',
                    'book',
                ],
                current: '',
                subParam: '',
                saving: false,
                saved:false,
                mapping: false,
                hiddenParams: [
                    'article',
                    'profile',
                    'audio',
                    'video',
                    'book',
                ],
                ogData: {
                    title: {
                        visibility: true,
                        data: {
                            value: '',
                            mapped: false
                        },
                    },
                    type: {
                        visibility: true,
                        data: {
                            value: 'website',
                            mapped: false
                        }
                    },
                    url: {
                        visibility: true,
                        data: {
                            value: '',
                            mapped: false
                        },
                    },
                    image: {
                        visibility: true,
                        data: {
                            url: {
                                value: '',
                                mapped: false
                            },
                            secure_url: {
                                value: '',
                                mapped: false
                            },
                            type: {
                                value: '',
                                mapped: false
                            },
                            width: {
                                value: '',
                                mapped: false
                            },
                            height: {
                                value: '',
                                mapped: false
                            },
                            alt: {
                                value: '',
                                mapped: false
                            },
                        }
                    },
                    video: {
                        visibility: false,
                        data: {
                            url: {
                                value: '',
                                mapped: false
                            },
                            secure_url: {
                                value: '',
                                mapped: false
                            },
                            type: {
                                value: '',
                                mapped: false
                            },
                            width: {
                                value: '',
                                mapped: false
                            },
                            height: {
                                value: '',
                                mapped: false
                            },
                        }
                    },
                    audio: {
                        visibility: false,
                        data: {
                            url: {
                                value: '',
                                mapped: false
                            },
                            secure_url: {
                                value: '',
                                mapped: false
                            },
                            type: {
                                value: '',
                                mapped: false
                            },
                        }
                    },
                    article: {
                        visibility: false,
                        data: {
                            published_time: {
                                value: '',
                                mapped: false
                            },
                            modified_time: {
                                value: '',
                                mapped: false
                            },
                            expiration_time: {
                                value: '',
                                mapped: false
                            },
                            author: {
                                value: '',
                                mapped: false
                            },
                            section: {
                                value: '',
                                mapped: false
                            },
                            tag: {
                                value: '',
                                mapped: false
                            },
                        }
                    },
                    book: {
                        visibility: false,
                        data: {
                            author: {
                                value: '',
                                mapped: false
                            },
                            isbn: {
                                value: '',
                                mapped: false
                            },
                            release_date: {
                                value: '',
                                mapped: false
                            },
                            tag: {
                                value: '',
                                mapped: false
                            },
                        }
                    },
                    profile: {
                        visibility: false,
                        data: {
                            first_name: {
                                value: '',
                                mapped: false
                            },
                            last_name: {
                                value: '',
                                mapped: false
                            },
                            username: {
                                value: '',
                                mapped: false
                            },
                            gender: {
                                value: '',
                                mapped: false
                            },
                        }
                    },
                    description: {
                        visibility: true,
                        data: {
                            value: '',
                            mapped: false
                        },
                    },
                    determiner: {
                        visibility: true,
                        data: {
                            value: '',
                            mapped: false
                        },
                    },
                    locale: {
                        visibility: true,
                        data: {
                            value: '',
                            mapped: false
                        },
                    },
                    site_name: {
                        visibility: true,
                        data: {
                            value: '',
                            mapped: false
                        },
                    },
                }
            }
        },
        mounted() {
            if (this.route.og_data !== null) {
                this.ogData = this.route.og_data;
            }
        },
        methods: {
            closeModal() {
                EventBus.$emit('close-modal', 'og_data');
            },
            change() {
                this.ogData[this.ogData.type.data.value].visibility = true;
            },
            setMapping(param, subParam) {
                this.mapping = true;
                this.current = param;
                this.subParam = subParam;
                switch (param) {
                    case 'title':
                        this.showTitleMapping = true;
                        break;
                    default:
                        this.showParamsPapping = true;
                        break;
                }
            },
            removeMapping(param, subParam) {
                if (subParam) {
                    this.ogData[param].data[subParam].mapped = false;
                    this.ogData[param].data[subParam].value = '';
                } else {
                    this.ogData[param].data.mapped = false;
                    this.ogData[param].data.value = '';
                }
            },
            finishMapping() {
                this.mapping = false;
                this.current = '';
                this.showTitleMapping = false;
                this.showParamsPapping = false;
            },
            preview(){
                this.mapping = true;
                this.showPreviewModal = true;
            },
            closePreview(){
                this.mapping = false;
                this.showPreviewModal = false;
            },
            save() {
                this.saving = true;
                this.$http.post(API_URL + '/store-data?locale=' + this.locale, {
                    id: this.route.id,
                    type: 'og_data',
                    og_data: this.ogData,
                    _token: CSRF_TOKEN
                }).then(response => {
                    this.saving = false;
                    this.route.og_data = response.data.og_data;
                    this.saved = true;
                    let vm = this;
                    setTimeout(function(){
                        vm.saved = false;
                    },2000)
                    // this.closeModal();
                })
            },
        }
    }
</script>

<style scoped lang="scss">
    .modal {
        overflow: scroll;
    }

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

    .modal.fade .modal-dialog {
        width: 70% !important;
        max-width: 1500px;
    }

    .input-label {
        margin-right: 10px;
        width: calc(20% - 8px);
        &:last-child {
            margin-right: 0;
        }
    }

    .form-group {
        margin-bottom: 0;
        &.hasButtons {
            input {
                width: 55%;
                float: left;
            }
            .title-buttons {
                width: 40%;
                float: left;
                margin-left: 5px;
            }
        }
    }

    .form-control:disabled, .form-control[readonly] {
        background: #f3f3f3;
    }

    .input-group-append .btn, .input-group-prepend .btn {
        z-index: 0;
    }

    .url-feedback {
        margin-bottom: 0;
        margin-top: 10px;
        color: #dadada;
    }

    .open-header {
        width: 100%;
    }
</style>
