<template>
  <div id="root-element">
    <editEntity></editEntity>
    <handlesList entity="entity"></handlesList>
    <addHandle></addHandle>
  </div>
</template>


<script>
import EditEntity from './EditEntity.vue'
import HandlesList from './HandlesList.vue'
import AddHandle from './AddHandle.vue'
import { bus } from '../main'

export default {
  props: {
    'entity': entity
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
