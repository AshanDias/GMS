/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router'
Vue.use(VueRouter)
 

const routes = [
    { path: '/', component: require('./components/Dashboard.vue').default }, 
    { path: '/employee', component: require('./components/master_files/employee/employee_index.vue').default }, 
    { path: '/employee/type', component: require('./components/master_files/employee/employee_type.vue').default }, 
    { path: '/vehicle', component: require('./components/master_files/vehicle/vehicle_index.vue').default },     
  ]
    
  const router = new VueRouter({
    routes 
  })
    

//public components
Vue.component('header-vue',require('./components/public_component/header.vue').default);
Vue.component('aside-vue',require('./components/public_component/aside.vue').default);
Vue.component('footer-vue',require('./components/public_component/footer.vue').default);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('dashboard-component', require('./components/Dashboard.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});
