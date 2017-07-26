<template>
    <modal :show.sync="show" :on-close="close">
        <template slot="header">Delete account</template>

        <article slot="body">
          <p>This action will <b>DELETE</b> the selected handle. Are you sure ?</p>
          <button @click="close">Cancel</button> 
          <button @click="deleteHandle">OK</button>
        </article>

    </modal>
</template>


<script>
  import { bus } from '../../main'
  import Modal from '../Modal.vue'

  export default {
    props: ['show'],
    components: { 
      Modal
    },
    data () {
      return {
        
      }
    },
    methods: {
      close: function () {
        bus.$emit('closeDeleteHandleModal')
      },
      deleteEntity: function () {
        bus.$emit('deleteHandle')
        this.close()
      }
    }
}
</script>


<style lang="scss">

</style>
