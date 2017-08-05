// The following line loads the standalone build of Vue instead of the runtime-only build,
// so you don't have to do: import Vue from 'vue/dist/vue'
// This is done with the browser options. For the config, see package.json
import Vue from 'vue'
import VueResource from 'vue-resource'
import Vue2Filters from 'vue2-filters'

import Config from './config/'
import App from './App.vue'



export const bus = new Vue();


Vue.use(VueResource);
Vue.http.options.root = Config.API_URL

Vue.use(Vue2Filters)

new Vue({
  el: '#app',
  render: (h) => h(App),
})    
