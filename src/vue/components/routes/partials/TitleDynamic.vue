<template>
    <td>
        <button v-if="editing && route.mapping" class="btn btn-info" @click="openModal">Set Dynamic Title</button>
        <button v-else-if="editing && route.params.length" class="btn btn-danger" @click="openMappingModal">Set
            Mapping
        </button>
        <p v-else class="data">
            <span v-if="example_title">{{ example_title }}</span>
            <span v-else>-</span>
        </p>
    </td>
</template>

<script>
    import {EventBus} from "../../../event_bus";

    export default {
        name: "TitleFormat",
        props: {
            editing: {
                type: Boolean
            },
            route: {
                type: Object
            },
            locale: {
                type: String
            }
        },
        data() {
            return {
                example_title: ''
            }
        },
        created() {
            let that = this;
            this.getExampleTitle(this.locale);
            EventBus.$on('title-changed', function () {
                that.getExampleTitle();
            });
            EventBus.$on('change-locale', function (locale) {
                that.getExampleTitle(locale);
            });
        },
        methods: {
            openModal() {
                EventBus.$emit('open-modal', 'title_dynamic')
            },
            openMappingModal() {
                EventBus.$emit('open-modal', 'mapping')
            },
            getExampleTitle(locale) {
                if (this.route.title_dynamic !== null && this.route.title_dynamic.length > 0) {
                    this.$http.post(API_URL + '/get-example-title?locale=' + locale, this.route).then(response => {
                        this.example_title = response.data.example_title;
                    })
                }
            }
        }
    }
</script>

<style scoped>

</style>
