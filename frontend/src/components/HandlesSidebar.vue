<template>
  <div id="sidebar_handles">
    <editEntity v-bind:entity="entity" v-bind:url="url"></editEntity>
    <handlesList v-bind:entity="entity"></handlesList>
    <addHandle v-bind:entity="entity" v-bind:url="url"></addHandle>
    <editHandle v-bind:entity="entity" v-bind:url="url" v-bind:handle="currentHandle"></editHandle>
  </div>
</template>


<script>
import EditEntity from './EditEntity.vue'
import HandlesList from './HandlesList.vue'
import AddHandle from './AddHandle.vue'
import EditHandle from './EditHandle.vue'
import { bus } from '../main'

export default {
  props: ['entity', 'url'],
  components: {
    'editEntity': EditEntity,
    'handlesList': HandlesList,
    'addHandle': AddHandle,
    'editHandle': EditHandle
  },
  data () {
    return {
      currentHandle: {
        handle: '',
        active: false
      }
    }
  },
  created () {
    bus.$on('changeCurrentHandle', (handle) => {
      this.changeCurrentHandle(handle)
    })
  },
  methods: {
    changeCurrentHandle: function(handle){
      this.currentHandle = handle
    }
  }
}
</script>


<style lang="scss">

</style>
