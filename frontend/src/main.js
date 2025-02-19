import Vue from 'vue';
import App from './App.vue';
import router from './router';
import axios from 'axios';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';

Vue.use(Vuetify);

const vuetify = new Vuetify();

Vue.prototype.$http = axios;

new Vue({
  router,
  vuetify,
  render: h => h(App)
}).$mount('#app');
