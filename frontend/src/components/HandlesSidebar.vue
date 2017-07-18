<template>
  <div id="root-element">
    <editEntity v-bind:entity="entity"></editEntity>
    <handlesList v-bind:entity="entity"></handlesList>
    <addHandle v-bind:entity="entity"></addHandle>
  </div>
</template>


<script>
import EditEntity from './EditEntity.vue'
import HandlesList from './HandlesList.vue'
import AddHandle from './AddHandle.vue'
import { bus } from '../main'

export default {
  props: 'entities':{
    type: Array,
    required: false
  },
  'entity': {
    type: Array
  },
  components: {
    'editEntity': EditEntity,
    'handlesList': HandlesList,
    'addHandle': AddHandle
  },
  data () {
    return {

    }
  },
  methods: {

  }
}
</script>


<style lang="scss">

</style>
