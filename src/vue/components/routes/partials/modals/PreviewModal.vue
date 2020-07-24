<template>
    <div>
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Preview for social media</h5>
                    <button type="button" @click="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs nav-tabs-sm">
                        <li class="nav-item" @click="changeTab('fb')">
                            <a href="#!" class="btn btn-rounded-circle btn-facebook"
                               :class="{active:activeTab === 'fb'}">
                                <span class="fe fe-facebook"></span>
                            </a>
                        </li>
                        <!--<li class="nav-item" @click="changeTab('twitter')">-->
                            <!--<a href="#!" class="btn btn-rounded-circle btn-twitter"-->
                               <!--:class="{active:activeTab === 'twitter'}">-->
                                <!--<span class="fe fe-twitter"></span>-->
                            <!--</a>-->
                        <!--</li>-->
                    </ul>
                    <div class="cards">
                        <div class="card fb" v-if="activeTab === 'fb' && loaded">
                            <div class="image" :class="{'no-image': !ogData['og:image:url']}">
                                <img v-if="ogData['og:image:url']" :src="ogData['og:image:url']" alt="">
                                <img class="default-image" v-else src="vendor/lionix/img/nophoto.png" alt="">
                            </div>
                            <div class="info" :class="{'no-image': !ogData['og:image:url']}">
                                <p class="site_name" v-if="ogData['og:site_name']">{{ ogData['og:site_name'] }}</p>
                                <p class="site_name" v-else>{{ ogData['og:url'] }}</p>
                                <p class="title">{{ ogData['og:title'] }}</p>
                                <p class="description">{{ ogData['og:description'] }}</p>
                            </div>
                        </div>
                        <div v-if="!loaded" class="card-body is-loading is-loading-lg"></div>

                        <!--<div class="card" v-if="activeTab === 'twitter'">twitter</div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PreviewModal",
        props: {
            route: {
                type: Object
            },
            locale: {
                type: String
            }
        },
        data() {
            return {
                activeTab: 'fb',
                loaded:false,
                ogData: {}
            }
        },
        created() {
            this.getSharingPreview();
        },
        methods: {
            getSharingPreview() {
                this.$http.post(API_URL + '/sharing-preview?locale=' + this.locale, {
                    id: this.route.id,
                    _token: CSRF_TOKEN
                }).then(response => {
                    this.ogData = response.data.og_data;
                    this.loaded = true;
                })
            },

            closeModal() {
                this.$emit('close-preview')
            },
            changeTab(tab) {
                this.activeTab = tab;
            }
        },

    }
</script>

<style scoped lang="scss">
    .nav-tabs {
        border-bottom: 0;
        width: 100px;
        margin: 0 auto;
    }

    .cards {
        margin-top: 30px;
        .card {
            width: 527px;
            margin: 0 auto;
            &.fb{
                .image {
                    img {
                        max-width: 100%;
                    }
                    .default-image{
                        height: 300px;
                    }
                    &.no-image{
                        height: 300px;
                        overflow: hidden;
                        img{
                            max-height: 100%;
                        }
                    }
                }

                .info {
                    padding: 10px 12px;
                    color: #4b4f56;
                    background-color: #F2F3F5;
                    max-height:80px;
                    overflow: hidden;
                    font-family: helvetica, arial, sans-serif;
                    border:1px solid #dddfe2;
                    &.no-image{
                        max-height: 150px;
                    }
                    p{
                        margin-bottom: 0;
                    }
                    .site_name{
                        color: #606770;
                        flex-shrink: 0;
                        font-size: 12px;
                        line-height: 16px;
                        overflow: hidden;
                        padding: 0;
                        text-overflow: ellipsis;
                        text-transform: uppercase;
                        white-space: nowrap;
                    }
                    .title{
                        color:#1d2129;
                        font-weight: 600;
                        font-size: 16px;
                        line-height: 20px;
                        margin: 5px 0 0;
                        max-height: 40px;
                        overflow: hidden;
                    }
                    .description{
                        color: #606770;
                        font-size: 14px;
                        line-height: 20px;
                        word-break: break-word;
                        text-overflow: ellipsis;
                        white-space: nowrap;
                        overflow: hidden;
                        margin-top: 3px;
                    }
                }
            }

        }
    }

    .btn-facebook {
        color: rgb(59, 89, 152);
        &.active {
            -webkit-box-shadow: 0 0 0 0.15rem rgba(44, 123, 229, .25);
            -moz-box-shadow: 0 0 0 0.15rem rgba(44, 123, 229, .25);
            box-shadow: 0 0 0 0.15rem rgba(44, 123, 229, .25);
        }
    }

    .btn-twitter {
        color: rgb(16, 223, 253);
        &.active {
            -webkit-box-shadow: 0 0 0 0.15rem rgba(44, 123, 229, .25);
            -moz-box-shadow: 0 0 0 0.15rem rgba(44, 123, 229, .25);
            box-shadow: 0 0 0 0.15rem rgba(44, 123, 229, .25);
        }
    }
</style>
