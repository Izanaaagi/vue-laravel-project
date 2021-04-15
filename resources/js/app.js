import Vue from "vue";
import Axios from "axios";
import {store} from "./store";
import {router} from "./router";
import VueSpinners from 'vue-spinners';
import TailablePagination from 'tailable-pagination';


require('./bootstrap');

window.Vue = require('vue')
Vue.use(VueSpinners)
Vue.use(TailablePagination);

Vue.prototype.$http = Axios
const token = localStorage.getItem('token')
if (token) {
  Vue.prototype.$http.defaults.headers.common['Authorization'] = token
}

const app = new Vue({
  el: '#app',
  router,
  store
});
