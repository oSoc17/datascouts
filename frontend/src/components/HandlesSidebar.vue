<template>
  <div id="sidebar_handles">
    <editEntity v-bind:entity="entity" v-bind:url="url"></editEntity>
    <h1>Social media handles for {{entity.entity.name}}</h1>
    <handlesList v-bind:entity="entity"></handlesList>
    <addHandle v-bind:entity="entity" v-bind:url="url"></addHandle>
  </div>
</template>


<script>
import EditEntity from './EditEntity.vue'
import HandlesList from './HandlesList.vue'
import AddHandle from './AddHandle.vue'

import { bus } from '../main'

export default {
  props: ['entity', 'url'],
  components: {
    'editEntity': EditEntity,
    'handlesList': HandlesList,
    'addHandle': AddHandle
  },
  data () {
    return {
      
    }
  }
}
</script>


<style lang="scss">

</style>
