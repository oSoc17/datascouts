<template>
  <div id="root-element">
    <handlesList entity="entity"></handlesList>
    <addHandle></addHandle>
  </div>
</template>


<script>
import HandlesList from './HandlesList.vue'
import AddHandle from './AddHandle.vue'
import { bus } from '../main'

export default {
  props: {
    'entity': entity
  },
  components: {
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
