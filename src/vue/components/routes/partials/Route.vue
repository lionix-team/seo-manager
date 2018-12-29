<template>
    <tr v-click-outside="endEditing">
        <th scope="row">
            <slot name="index"></slot>
        </th>
        <td>{{ route.uri }}</td>
        <app-params :params="route.params"></app-params>
        <app-mapping :mapping="route.mapping" :params="route.params" :editing="editing"></app-mapping>
        <app-keywords :keywords="route.keywords" :editing="editing"></app-keywords>
        <app-description :description="route.description" :editing="editing"></app-description>
        <app-title :title="route.title" :editing="editing"></app-title>
        <app-url :url="route.url" :editing="editing"></app-url>
        <app-author :author="route.author" :editing="editing"></app-author>
        <app-title-dynamic :route="route" :editing="editing"></app-title-dynamic>
        <app-og-data :route="route" :editing="editing"></app-og-data>
        <app-actions :route="route" @end-editing="endEditing" @start-editing="startEditing"
                     :editing="editing"></app-actions>
    </tr>
</template>

<script>
    import Params from './Params'
    import Keywords from './Keywords'
    import Mapping from './Mapping'
    import Description from './Description'
    import Actions from './Actions'
    import Title from './Title'
    import Author from './Author'
    import TitleDynamic from './TitleDynamic'
    import OgData from './OgData'
    import Url from './Url'

    export default {
        name: "Route",
        props: {
            route: {
                type: Object,
                required: true
            }
        },
        components: {
            'app-params': Params,
            'app-keywords': Keywords,
            'app-mapping': Mapping,
            'app-description': Description,
            'app-actions': Actions,
            'app-title': Title,
            'app-author': Author,
            'app-title-dynamic': TitleDynamic,
            'app-og-data': OgData,
            'app-url': Url
        },
        data() {
            return {
                editing: false
            }
        },
        methods: {
            startEditing() {
                this.editing = true;
            },
            endEditing() {
                this.editing = false;
            }
        }
    }
</script>

<style scoped>

</style>
