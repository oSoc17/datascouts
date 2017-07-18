<template>
  <div id="sidenav_action" class="sidenav_action">
    <div class="content">
      <p> EDIT/DELETE {{handle.handle.name}} </p>
      <form >
          <input type="text" v-model="handle.handle.name"/>
          <input type="text" v-model="handle.handle.url"/>
          <button type="button" v-on:click="editHandle(handle, $event)">update</button>
          <button type="button" v-on:click="discardHandle($event)">discard</button>
          <br />
          <br />
          <br />
          <button type="button" v-on:click="confirmDeleteHandle(handle, $event)">delete</button>
      </form>
    </div>
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
    bus.$on('discardHandle')
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
