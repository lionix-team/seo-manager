<template>
    <div id="wrapper">
        <!--<app-side-bar></app-side-bar>-->
        <div class="main-content">
            <app-header></app-header>
            <app-routes></app-routes>
        </div>
    </div>
</template>

<script>
    import Header from './components/Header';
    import SideBar from './components/SideBar';
    import Routes from './components/routes/Routes';

    export default {
        name: "App",
        components: {
            'app-header':Header,
            'app-side-bar':SideBar,
            'app-routes':Routes
        },
        data(){
            return {
                editing: false
            }
        }
    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style>

</style>
