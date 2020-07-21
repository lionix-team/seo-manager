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
const CSRF_TOKEN = window.CSRF_TOKEN;

Vue.filter('uppercase', function (value) {
    return value.toUpperCase()
});
Vue.directive('click-outside', ClickOutside);
Vue.component('multi-select', MultiSelect);

// if(CSRF_TOKEN){
//     console.log('whut')
//     Vue.http.interceptors.push(function (request, next) {
//         request.headers['X-CSRF-TOKEN'] = CSRF_TOKEN;
//         console.log(CSRF_TOKEN);
//         next();
//     });
// }

new Vue({
    el: '#lionix-seo-manager-app',
    store,
    components: {
        App
    }
});
