// The following line loads the standalone build of Vue instead of the runtime-only build,
// so you don't have to do: import Vue from 'vue/dist/vue'
// This is done with the browser options. For the config, see package.json
import Vue from 'vue'
import VueResource from 'vue-resource'

import Config from './config/'
import filters from './utils/filters'
import App from './App.vue'



export const bus = new Vue();


Vue.use(VueResource);
Vue.http.options.root = Config.API_URL;

new Vue({
  el: '#app',
  filters,
  render: (h) => h(App),
})