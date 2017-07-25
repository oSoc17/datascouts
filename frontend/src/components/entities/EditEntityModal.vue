<template>
    <modal :show.sync="show" :on-close="close">
        <template slot="header">Edit Entity</template>

        <div slot="body">
          <label class="form-label">
              New Name : <input v-model="newName" class="form-control" autofocus>
          </label>
        </div>

        <div slot="footer" class="text-right">
            <button class="modal-default-button" @click="updateEntity">
                Save
            </button>
        </div>
    </modal>
</template>


<script>
  import { bus } from '../../main'
  import Modal from '../Modal.vue'

  export default {
    props: ['show', 'name'],
    components: { 
      Modal
    },
    data () {
      return {
        newName : this.name
      }
    },
    watch : {
      name : function (original){
        this.newName = original;
      },
    },
    methods: {
      close: function () {
        bus.$emit('CLOSE_EDIT_MODAL')
      },
      updateEntity: function () {
        if(this.newName && this.newName !== this.name){
          bus.$emit('UPDATE_ENTITY', this.newName)
        }
        this.close()
      }
    }
}
</script>


<style lang="scss">

</style>
