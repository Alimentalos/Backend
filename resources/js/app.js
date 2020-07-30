require('./bootstrap');
import 'es6-promise/auto'
import Vue from 'vue';
import Vuex from 'vuex'

Vue.use(Vuex)

const app = new Vue({
    el: '#app'
});