/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import VueMask from 'v-mask';

window.Vue = require('vue').default;
Vue.use(VueMask);
Vue.use(require('vue-resource'));
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
Vue.component('randevuform-component', require('./components/RandevuFormComponent.vue').default);
Vue.component('admin-component', require('./components/AdminComponent.vue').default);
Vue.component('adminworking-component', require('./components/AdminWorkingComponent.vue').default);
Vue.component('adminworkingitem-component', require('./components/AdminWorkingItemComponent.vue').default);
Vue.component('adminappointmentmodal-component', require('./components/AdminAppointmentModal.vue').default);

Vue.component('adminappointment-component', require('./components/AdminAppointmentComponent.vue').default);
Vue.component('adminwaitingappointment-component', require('./components/AdminWaitingAppointmentComponent.vue').default);
Vue.component('admincancelappointment-component', require('./components/AdminCancelAppointmentComponent.vue').default);
Vue.component('admintodayappointment-component', require('./components/AdminTodayAppointmentComponent.vue').default);
Vue.component('adminlastappointment-component', require('./components/AdminLastAppointmentComponent.vue').default);
Vue.component('adminlistappointment-component', require('./components/AdminListAppointment.vue').default);

Vue.component('pagination',require('laravel-vue-pagination'));
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
