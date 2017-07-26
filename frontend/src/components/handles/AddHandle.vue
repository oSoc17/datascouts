<template>
  <div>
  <form action="" class="slide-up" id="handle_form">
    <transition-group  class="form-group hidden"
      name='popup' tag="div"
    >

      <!--<button class="btn_primary social_media"
          v-bind:key="service.id"
          v-for="service in services"
          v-on:click.prevent="openAddModal(service)">
                <div class="icon-handle">
          <i v-bind:class="['icon-handle', 'fa', 'fa-'+service.name]"></i> {{service.name}}
        </div>
      </button>-->
    </transition-group>
    <div class="form-group">
      <button class="btn_primary action" id="handle_add" v-on:click.prevent="openAddModal(services[0])">
        <i class="plus">+</i>
        Add account
      </button>
    </div>
  </form>

  <addHandleModal
    :service="selectService"
    :services="services"
    :show.sync="showAddBox" :onClose="closeAddModal"
    ></addHandleModal>

  </div>
</template>

<script>
  import { bus } from '../../main'
  import AddHandleModal from './AddHandleModal.vue'

export default {
  props:['services'],
  components:{
    AddHandleModal
  },
  data () {
    return {
      selectService : {},
      showAddBox : false
    }
  },
  created () {
    // Modal want to be closed
    bus.$on('CLOSE_ADDHANDLE_MODAL', this.closeAddModal)
    //bus.$on('CHANGE_SERVICE', (service) => this.selectService = service)
    // Modal want to add a new handle
    // bus.$on('ADD_HANDLE', this.addHandle)

  },
  methods: {
    showHandlePopup: function (handle) {
      document.querySelector('form.slide-up#handle_form .form-group').classList.toggle('hidden');
    },
    openAddModal : function (service){
      this.selectService = service
      if(!service){
        this.selectService = this.services[2]
      }
      this.showAddBox = true
    },
    closeAddModal : function () {
      this.showAddBox = false
      document.querySelector('form.slide-up#handle_form .form-group').classList.toggle('hidden')
    },

  }
}
</script>

<style >

</style>
