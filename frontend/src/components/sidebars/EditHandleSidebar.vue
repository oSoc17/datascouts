<template>
  <div>
    <transition name="sidebar_handle_actions" @enter="openSidebar" @leave="closeSideBar">

      <div id="sidebar_handle_actions">
        <h1>Edit/Delete {{handle.name}}</h1>
        <form >
          <div class="form-group">
            <label for="">Name</label>
            <input type="text" v-model.trim="newName"/>
            <div class="validation-error">
              <div class="error-icon">
                <i class="fa fa-exclamation "></i>
              </div>
              <ul>
                <li>The name should be unique.</li>
              </ul>
            </div>
          </div>

          <div class="form-group">
            <button
              :class="['btn_crud', {'disabled' : newName == handle.name}]"
              v-on:click.prevent="editHandle()">
              <i class="fa fa-wrench"></i> Update
            </button>
            <button class="btn_crud" v-on:click.prevent="$emit('close')">
              <i class="fa fa-ban"></i> Discard
            </button>
            <button class="btn_crud delete" v-on:click.prevent="deleteHandle()">
              <i class="fa fa-trash"></i> Delete
            </button>
          </div>
        </form>
      </div>
    </transition>

     <!--<deleteHandleModal
       :show.sync="showDeleteModal" :onClose="closeDeleteModal"
      ></deleteHandleModal>-->

  </div>
</template>


<script>
  import { bus } from '../../main'
  import DeleteHandleModal from '../handles/DeleteHandleModal.vue'


  export default {
    props: ['handle'],
    components: {
      DeleteHandleModal
    },
    data() {
      return {
        showDeleteModal: false,
        newName: ''
      }
    },
    watch : {
      handle: function(nHandle) {
        this.newName = this.handle.name
      },

    },
    created() {
      bus.$on('CLOSE_DELETEHANDLE_MODAL', this.deleteHandle)
      bus.$on('DELETE_HANDLE', this.deleteHandle)
    },
    methods: {
      openSidebar: function() {
        const $elt = document.getElementById("sidebar_handle_actions")
        $elt.style.marginLeft = "-1px"
        $elt.style.transition = "all .25s ease"
        $elt.style.zIndex = 3
      },

      closeSideBar: function() {
        const $elt = document.getElementById("sidebar_handle_actions")
        $elt.style.marginLeft = "-324px"
        $elt.style.transition = "all .5s ease"
        $elt.style.zIndex = -2
        // document.querySelector('.handle').classList.remove("active")

      },

      closeDeleteModal : function(){
        this.showDeleteModal = false
      },

      editHandle: function() {
        if(this.newName && this.newName !== this.handle.name){
          this.$http.put('handles/' + this.handle.id, {"name": this.newName})
              .then(res => {
                console.log("Handle updated")
                bus.$emit('CLOSE_EDITHANDLE_SIDEBAR');
                bus.$emit('UPDATE_CURRENT_HANDLE', this.newName)
                this.newName = ''
              })
              .catch(err => console.log("[EditHandleSidebar] Failed to update handle",err))
        }
      },

      deleteHandle: function() {
        this.$http.delete('handles/' + this.handle.id)
            .then(res => {
              console.log("Handle deleted")
              bus.$emit('DELETE_CURRENT_HANDLE')
            })
            .catch(err => console.log("[EditHandleSidebar] Failed to delete handle",err))
      },
    }
  }
</script>


<style lang="scss">

</style>
