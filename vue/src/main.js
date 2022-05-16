import Vue from 'vue'
import App from './App.vue'

import VueRouter from 'vue-router'
import routes from './routes'
Vue.use(VueRouter)

import axios from 'axios'
import VueAxios from 'vue-axios'
Vue.use(VueAxios, axios)

import Vuetify from 'vuetify'
Vue.use(Vuetify)

import VuePageTransition from 'vue-page-transition'
Vue.use(VuePageTransition)

Vue.config.productionTip = false

new Vue({
  render: h => h(App),
}).$mount('#app')

// Agregamos la URL base de nuestra API
axios.defaults.baseURL = 'http://localhost/wp-vue/vue';