<template>
  <div id="sidebar_actions">
    <h1>Edit/delete {{handle.handle.name}}</h1>
    <form >
      <div class="form-group">
        <label for="">Name</label>
        <input type="text" v-model="handle.handle.name"/>
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
        <button class="btn_crud disabled" v-on:click="editHandle(handle, $event)">
          <i class="fa fa-wrench"></i>
          Update
        </button>
        <button class="btn_crud" v-on:click="discardHandle($event)">
          <i class="fa fa-ban"></i>
          Discard
        </button>
        <button class="btn_crud delete" v-on:click="confirmDeleteHandle(handle, $event)">
          <i class="fa fa-trash"></i>
          Delete
        </button>
      </div>
    </form>
  </div>
</template>


<script>
import { bus } from '../main'

export default {
  props: ['entity', 'url', 'handle'],
  components: {
  },
  data () {
    return {

    }
  },
  created () {
    bus.$on('discardHandle', ()=>{
      this.discardHandle()
    })
  },
  methods: {
    editHandle: function(handle, e) {
      e.preventDefault()
      var self = this
      Vue.http.put(self.url + '/handles/' + handle.handle.id, {"name" : handle.handle.name, "url" : handle.handle.url}).then(function (response) {
          console.log("Handle updated")
          bus.$emit('loadHandles', self.entity)
          //console.log(response)
        }, function (response) {
          console.log("Error Failed to update handle")
      })
    },
    confirmDeleteHandle: function(handle, e) {
      if(confirm("Are you sure you want to delete this handle?") == true){
        this.deleteHandle(handle, e)
      }
    },
    deleteHandle: function(handle, e) {
      var self = this
      e.preventDefault()
      console.log(handle)
      Vue.http.delete(self.url + '/services/' + handle.handle.id).then(function (response) {
          console.log("Handle deleted")
          bus.$emit('loadEntities')
          //console.log(response)
        }, function (response) {
          console.log("Error Failed to delete handle")
      })

    },
    discardHandle: function(e) {
      bus.$emit('handleSelected')
      this.handle.id = ""
    }
  }
}
</script>


<style lang="scss">

</style>
