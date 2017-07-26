// The following line loads the standalone build of Vue instead of the runtime-only build,
// so you don't have to do: import Vue from 'vue/dist/vue'
// This is done with the browser options. For the config, see package.json
import Vue from 'vue'
import VueResource from 'vue-resource'

import App from './App.vue'


export const bus = new Vue();


Vue.use(VueResource);
Vue.http.options.root = 'https://osoc-2017-datascouts-akad1070.c9users.io/v1/';

new Vue({ // eslint-disable-line no-new
  el: '#app',
  render: (h) => h(App),

})
