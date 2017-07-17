import Vue from 'vue'

import EntitiesSidebar from './EntitiesSidebar.vue'

const bus = new Vue();

new Vue({
  el: '#Sidebar',
  render: h => h(EntitiesSidebar)
})
