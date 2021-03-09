import Vue from "vue";
import Axios from "axios";
import {store} from "./store";
import {router} from "./router";

require('./bootstrap');

window.Vue = require('vue');

Vue.prototype.$http = Axios;
const token = localStorage.getItem('token');
if (token) {
  Vue.prototype.$http.defaults.headers.common['Authorization'] = token;
}

const app = new Vue({
  el: '#app',
  router,
  store
});
