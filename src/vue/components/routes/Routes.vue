<template>
    <div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div v-if="loaded" class="card-body text-center">
                            <table v-show="routes.length > 0" class="routes-table table text-left">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">URI</th>
                                    <th scope="col">Params</th>
                                    <th scope="col">Mapping</th>
                                    <th scope="col">Keywords</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">URL</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Title (dynamic)</th>
                                    <th scope="col">Open Graph Data</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <app-route v-for="(route, index) in routes" :key="route.id" :route="route" :locale="locale">
                                    <template slot="index">
                                        {{ index }}
                                    </template>
                                </app-route>
                                </tbody>
                            </table>
                            <div v-show="routes.length === 0" class="no-routes">
                                <!-- Image -->
                                <img src="vendor/lionix/img/scale.svg" alt="..." class="img-fluid"
                                     style="max-width: 182px;">
                                <!-- Title -->
                                <h1>
                                    No routes yet.
                                </h1>
                                <!-- Subtitle -->
                                <p class="text-muted">
                                    Import your all routes by clicking button below
                                </p>
                                <!-- Button -->
                                <button @click="importRoutes" :clas="{'is-loading': importing}"
                                        class="import-routes btn btn-primary">
                                    Import Routes
                                </button>
                            </div>
                        </div>
                        <div v-if="!loaded" class="card-body is-loading is-loading-lg"></div>
                    </div>
                </div>
            </div>
        </div>
        <app-mapping-modal v-if="showMappingModal" :route="selectedRoute"
                           :showModal="showMappingModal" :locale="locale"></app-mapping-modal>

        <app-keywords-modal v-if="showKeywordsModal" :route="selectedRoute"
                            :showModal="showKeywordsModal" :locale="locale"></app-keywords-modal>

        <app-description-modal v-if="showDescriptionModal" :route="selectedRoute"
                               :showModal="showDescriptionModal" :locale="locale"></app-description-modal>

        <app-title-modal v-if="showTitleModal" :route="selectedRoute" :showModal="showTitleModal"
                         :locale="locale"></app-title-modal>

        <app-author-modal v-if="showAuthorModal" :route="selectedRoute" :showModal="showAuthorModal"
                          :locale="locale"></app-author-modal>

        <app-title-dynamic-modal v-if="showTitleDynamicModal" :route="selectedRoute"
                                 :showModal="showTitleDynamicModal" :locale="locale"></app-title-dynamic-modal>

        <app-og-data-modal v-if="showOgDataModal" :route="selectedRoute"
                           :showModal="showOgDataModal" :locale="locale"></app-og-data-modal>

        <app-url-modal v-if="showUrlModal" :route="selectedRoute" :showModal="showUrlModal"
                       :locale="locale"></app-url-modal>
    </div>
</template>

<script>
    import Route from './partials/Route'
    import MappingModal from './partials/modals/MappingModal'
    import KeywordsModal from './partials/modals/KeywordsModal'
    import DescriptionModal from './partials/modals/DescriptionModal'
    import TitleModal from './partials/modals/TitleModal'
    import AuthorModal from './partials/modals/AuthorModal'
    import TitleDynamicModal from './partials/modals/TitleDynamicModal'
    import OgDataModal from './partials/modals/OgDataModal'
    import UrlModal from './partials/modals/UrlModal'

    import {EventBus} from "../../event_bus";

    export default {
        name: "Routes",
        components: {
            'app-route': Route,
            'app-mapping-modal': MappingModal,
            'app-keywords-modal': KeywordsModal,
            'app-description-modal': DescriptionModal,
            'app-title-modal': TitleModal,
            'app-author-modal': AuthorModal,
            'app-title-dynamic-modal': TitleDynamicModal,
            'app-og-data-modal': OgDataModal,
            'app-url-modal': UrlModal,
        },
        data() {
            return {
                routes: [],
                selectedRoute: {},
                showMappingModal: false,
                showKeywordsModal: false,
                showDescriptionModal: false,
                showTitleModal: false,
                showAuthorModal: false,
                showTitleDynamicModal: false,
                showOgDataModal: false,
                showUrlModal: false,
                importing: false,
                loaded: false,
                locale: ''
            }
        },
        created() {
            let that = this;
            EventBus.$on('change-locale', function (locale) {
                that.getRoutes(locale);
                that.locale = locale;
            });
            this.syncRoutes();
            this.startEditing();
            this.endEditing();
            this.openModal();
            this.closeModal();
            this.deleteRoute();
        },
        methods: {
            importRoutes() {
                this.importing = true;
                this.loaded = false;
                this.$http.get(API_URL + '/import-routes').then(response => {
                    this.routes = response.data.routes;
                    this.importing = false;
                    this.loaded = true;
                });
            },
            syncRoutes() {
                let that = this;
                EventBus.$on('sync-routes', function () {
                    that.importRoutes();
                })
            },
            getRoutes(locale) {
                this.$http.get(API_URL + '/get-routes?locale=' + locale).then(response => {
                    this.routes = response.data.routes;
                    this.loaded = true;
                });
            },
            startEditing() {
                let that = this;
                EventBus.$on('start-editing', function (route) {
                    that.selectedRoute = route;
                });
            },
            endEditing() {
                let that = this;
                EventBus.$on('end-editing', function () {
                    that.selectedRoute = {};
                });
            },
            openModal() {
                let that = this;
                EventBus.$on('open-modal', function (modal) {
                    switch (modal) {
                        case 'mapping':
                            that.showMappingModal = true;
                            break;
                        case 'keywords':
                            that.showKeywordsModal = true;
                            break;
                        case 'description':
                            that.showDescriptionModal = true;
                            break;
                        case 'title':
                            that.showTitleModal = true;
                            break;
                        case 'author':
                            that.showAuthorModal = true;
                            break;
                        case 'title_dynamic':
                            that.showTitleDynamicModal = true;
                            break;
                        case 'og_data':
                            that.showOgDataModal = true;
                            break;
                        case 'url':
                            that.showUrlModal = true;
                            break;
                    }
                })
            },
            closeModal() {
                let that = this;
                EventBus.$on('close-modal', function (modal) {
                    switch (modal) {
                        case 'mapping':
                            that.showMappingModal = false;
                            break;
                        case 'keywords':
                            that.showKeywordsModal = false;
                            break;
                        case 'description':
                            that.showDescriptionModal = false;
                            break;
                        case 'title':
                            that.showTitleModal = false;
                            break;
                        case 'author':
                            that.showAuthorModal = false;
                            break;
                        case 'title_dynamic':
                            that.showTitleDynamicModal = false;
                            break;
                        case 'og_data':
                            that.showOgDataModal = false;
                            break;
                        case 'url':
                            that.showUrlModal = false;
                            break;
                    }
                })
            },
            deleteRoute() {
                let that = this;
                EventBus.$on('delete-route', function (route) {
                    that.$http.post(API_URL + '/delete-route', route).then(response => {
                        if (response.data.deleted) {
                            that.routes.splice(that.routes.indexOf(route), 1);
                            that.$swal(
                                'Deleted!',
                                'Your route has been deleted.',
                                'success'
                            )
                        }
                    })
                })

            }
        }
    }
</script>

<style scoped>

</style>
