<template>
    <div class="header">
        <div class="container-fluid">

            <!-- Body -->
            <div class="header-body">
                <div class="row align-items-center">
                    <div class="col ml--3 ml-md--2">
                        <!-- Pre-title -->
                        <h6 class="header-pretitle">
                            Seo Manager
                        </h6>

                        <!-- Title -->
                        <h1 class="header-title">
                            Routes
                        </h1>
                    </div>
                    <div class="col-md-1">
                        <button @click="addLocale" class="import-routes btn btn-outline-success">
                            Add Locales
                        </button>
                    </div>
                    <div class="col-md-2">
                        <multi-select v-model="currentLocale"
                                      :options="locales"
                                      placeholder="Select Locale"
                                      :show-labels="false">
                        </multi-select>
                    </div>
                    <div class="col-md-1">
                        <button @click="syncRoutes" :clas="{'is-loading': importing}"
                                class="import-routes btn btn-primary">
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
        data() {
            return {
                importing: false,
                locales: [],
            }
        },
        computed: {
            currentLocale: {
                get: function () {
                    return this.$store.getters.locale;
                },
                set: function (locale) {
                    this.setCurrentLocale(locale);
                }
            }
        },
        mounted() {
            this.getLocales();
            this.getCurrentLocale();
        },
        methods: {
            syncRoutes() {
                EventBus.$emit('sync-routes')
            },
            getCurrentLocale() {
                let locale = (localStorage.getItem('locale')) ? localStorage.getItem('locale') : 'en';
                this.setCurrentLocale(locale);
            },
            setCurrentLocale(locale) {
                localStorage.setItem('locale', locale);
                this.$store.commit('setLocale', locale);
                EventBus.$emit('change-locale', locale)
            },
            getLocales() {
                this.$http.get(API_URL + '/locales/get-locales').then(response => {
                    this.locales = response.data.locales;
                })
            },
            addLocale() {
                let that = this;
                this.$swal({
                    title: 'Add your locale name',
                    input: 'text',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Add',
                    showLoaderOnConfirm: true,
                    preConfirm: (locale) => {
                        that.$http.post(API_URL + '/locales/add-locale', {
                            name: locale,
                            _token: CSRF_TOKEN
                        }).then(response => {
                            that.locales.push(response.data.locale);
                            that.$swal(
                                'Added!',
                                'Your new '+locale+' locale has been added.',
                                'success'
                            )
                        }, error => {
                            that.$swal(
                                'ERROR!',
                                error.data.message,
                                'danger'
                            )
                        })
                    },
                    allowOutsideClick: () => !that.$swal.isLoading()
                });
            }
        }
    }
</script>

<style scoped>
    .import-routes {
        float: right;
    }
</style>
