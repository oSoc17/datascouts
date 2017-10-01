// The following line loads the standalone build of Vue instead of the runtime-only build,
// so you don't have to do: import Vue from 'vue/dist/vue'
// This is done with the browser options. For the config, see package.json
import Vue from 'vue'
import VueResource from 'vue-resource'
import Vue2Filters from 'vue2-filters'
import VueYouTubeEmbed from 'vue-youtube-embed'

import Config from './config/'
import App from './App.vue'


// Used as Global Event for PubSub
export const bus = new Vue();


// Insert vue Ressource for the XHR REquest
Vue.use(VueResource);
Vue.http.options.root = Config.API_URL

// Insert Basic filters 
Vue.use(Vue2Filters)

// Insert Youtube Component
Vue.use(VueYouTubeEmbed)


// Init a new Vue App to render
const app = new Vue({
  el: '#app',
  render: (h) => h(App),
})    
