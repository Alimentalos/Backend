require('./bootstrap');
import 'es6-promise/auto'
import Vue from 'vue';
import Vuex from 'vuex'

Vue.use(Vuex)

Vue.component('navbar',require('./components/Navbar.vue').default);

const app = new Vue({
    el: '#app'
});