// The following line loads the standalone build of Vue instead of the runtime-only build,
// so you don't have to do: import Vue from 'vue/dist/vue'
// This is done with the browser options. For the config, see package.json
import Vue from 'vue'
import VueResource from 'vue-resource'
import EntitiesSidebar from './EntitiesSidebar.vue'

export const bus = new Vue();

new Vue({ // eslint-disable-line no-new
  el: '#EntitiesSidebar',
  render: (h) => h(EntitiesSidebar)
})