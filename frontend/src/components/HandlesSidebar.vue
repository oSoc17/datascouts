<template>
  <div id="root-element">
    <!--<editEntity v-bind:entity="entity"></editEntity>-->
    <handlesList v-bind:entity="entity"></handlesList>
    <!--<addHandle v-bind:entity="entity"></addHandle>-->
    <!--<editHandle v-bind:entity="entity" v-bind:"handle"></editHandle>-->
  </div>
</template>


<script>
//import EditEntity from './EditEntity.vue'
import HandlesList from './HandlesList.vue'
//import AddHandle from './AddHandle.vue'
//import EditHandle from './EditHandle.vue'
import { bus } from '../main'

export default {
  props: {
    'entities':{
      type: Array,
      required: false
    },
    'entity': {
      type: Array
    },
    'handle': {
      type: Array
    }
  },
  components: {
    //'editEntity': EditEntity,
    'handlesList': HandlesList,
    //'addHandle': AddHandle,
    //'editHandle': EditHandle
  },
  data () {
    return {

    }
  },
  created () {
    bus.$on('changeCurrentEntity', (entity) => {
      this.changeCurrentEntity(entity)
    })
  },
  methods: {
    changeCurrentHandle: function(handle){
      this.handle = handle
    }
  }
}
</script>


<style lang="scss">

</style>
