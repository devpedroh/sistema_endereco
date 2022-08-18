import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import vuetify from './plugins/vuetify'
import 'roboto-fontface/css/roboto/roboto-fontface.css'
import '@mdi/font/css/materialdesignicons.css'

import axios from 'axios'
import Snotify, { SnotifyPosition } from 'vue-snotify';
import { VueMaskDirective } from 'v-mask'

Vue.config.productionTip = false

Vue.directive('mask', VueMaskDirective);

const options = {
  toast: {
    position: SnotifyPosition.rightTop
  }
}

Vue.use(Snotify, options)

Vue.prototype.$http = axios
Vue.prototype.$urlAPI = 'http://localhost:8000/api/'

if (localStorage.getItem('userData') != 'undefined') {
  Vue.prototype.$user = JSON.parse(localStorage.getItem('userData'))
} else {
  Vue.prototype.$user = ''
}

new Vue({
  router,
  store,
  vuetify,
  render: h => h(App)
}).$mount('#app')
