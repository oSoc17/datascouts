<template>
  <div id="edit-entity">
    <button class="btn_secondary action" @click="showEditModal = true">
      <i class="fa fa-pencil"></i>
      Edit
    </button>
    <button class="btn_secondary action" v-on:click.prevent="showDeleteModal = true">
      <i class="fa fa-trash"></i>
      Delete
    </button>
    
    <editEntityModal 
      :name="entity.name"
      :show.sync="showEditModal" :onClose="closeEditModal"
      ></editEntityModal>
    
    
    <deleteEntityModal 
      :show.sync="showDeleteModal" :onClose="closeDeleteModal"
      ></deleteEntityModal>
    
    
  </div>
</template>


<script>
  import { bus } from '../../main'
  import EditEntityModal from './EditEntityModal.vue'
  import DeleteEntityModal from './DeleteEntityModal.vue'

  export default {
    props: ['entity'],
    components: { 
      EditEntityModal,
      DeleteEntityModal,
    },
    data () {
      return {
        showEditModal : false,
        showDeleteModal : false,
      }
    },
    mounted () {
      bus.$on('CLOSE_EDIT_MODAL', this.closeEditModal)
      bus.$on('CLOSE_DELETE_MODAL', this.closeDeleteModal)
    },
    watch: {
      entity: function(entity){
        
      }
    },
    methods: {
      closeEditModal : function(){
        this.showEditModal = false
      },
      
      closeDeleteModal : function (){
        this.showDeleteModal = false
      },

    }
}
</script>


<style lang="scss">

</style>
