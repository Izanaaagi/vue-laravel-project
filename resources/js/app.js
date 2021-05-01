import Vue from "vue"
import Axios from "axios"
import {store} from "./store"
import {router} from "./router"
import VueSpinners from 'vue-spinners'
import TailablePagination from 'tailable-pagination'
import HelloJs from 'hellojs/dist/hello.all.min.js'
import VueHello from 'vue-hellojs'


require('./bootstrap')

window.Vue = require('vue')
Vue.use(VueSpinners)
Vue.use(TailablePagination)

HelloJs.init({
  google: '576277453024-sa9ioiecggce2f4q10k71qpa55hontua.apps.googleusercontent.com',
}, {
  redirect_uri: 'http://back.com/api/login/google/callback'
});
Vue.use(VueHello, HelloJs);

Vue.prototype.$http = Axios
const token = localStorage.getItem('token')
if (token) {
  Vue.prototype.$http.defaults.headers.common['Authorization'] = token
}

axios.interceptors.response.use(function (response) {
    return response;
  },
  function (error) {

    if (error.response.status === 401) {
      localStorage.removeItem('token')
      router.replace({name: 'login'})
      store.commit('SET_ERRORS', {
        errors: ['Your session is over']
      })
    }
    return Promise.reject(error);
  });

const app = new Vue({
  property: '$auth',
  el: '#app',
  router,
  store
});
