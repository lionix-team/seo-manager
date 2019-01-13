import Vue from 'vue'
import VueResource from 'vue-resource'
import App from './App'
import MultiSelect from 'vue-multiselect'
import VueDraggable from 'vue-draggable'
import ClickOutside from 'vue-click-outside'
import VueSweetalert2 from 'vue-sweetalert2'
import {store} from './store/store'
Vue.use(VueDraggable);
Vue.use(VueResource);
Vue.use(VueSweetalert2);

const API_URL = window.API_URL;

Vue.filter('uppercase', function (value) {
    return value.toUpperCase()
});
Vue.directive('click-outside', ClickOutside);
Vue.component('multi-select', MultiSelect);

new Vue({
    el: '#lionix-seo-manager-app',
    store,
    components: {
        App
    }
});
