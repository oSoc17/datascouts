<template>
    <modal :show.sync="show" :on-close="close">
        <template slot="header">Add new Handle for {{service.name}}</template>

        <div slot="body">
          <label class="form-label">
              Handle name : <input v-model.trim="name" class="form-control" autofocus>
          </label>
          
          <label class="form-label">
              Service name : 
              <select name="service" v-model='selectedService.id'>
                <option v-for="serv in services" :value="serv.id">{{serv.name}}</option>
              </select>
          </label>
          
        </div>

        <div slot="footer" class="text-right">
            <button class="modal-default-button" @click="addHandle()">
                Save
            </button>
        </div>
    </modal>
</template>


<script>
  import { bus } from '../../main'
  import Modal from '../Modal.vue'

  export default {
    props: ['show', 'service', 'services'],
    components: { 
      Modal
    },
    data () {
      return {
        name : '',
        selectedService : {},
      }
    },
    watch : {
      service : function (){
        this.selectedService = this.service
      }
    },
    methods: {
      close: function () {
        bus.$emit('CLOSE_ADDHANDLE_MODAL')
      },
      addHandle: function () {
        if(this.name){
          bus.$emit('INSERT_NEW_HANDLE', { // Send to AddHandle Component
            'name':this.name, 
            'service' : this.selectedService.id
          })
        }
        this.close()
      }
    }
}
</script>


<style lang="scss">

</style>
