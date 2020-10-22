/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import { BootstrapVueIcons, BootstrapVue } from 'bootstrap-vue' //Importing
window.Vue = require('vue');
Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('comment-list-component', require('./components/CommentListComponent.vue').default);
Vue.component('post-component', require('./components/PostComponent.vue').default);
Vue.component('reply-component', require('./components/ReplyComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.prototype.$eventHub = new Vue();

const app = new Vue({
    el: '#app',
});

