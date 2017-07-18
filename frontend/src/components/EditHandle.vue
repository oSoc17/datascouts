<template>
  <div id="root-element">

  </div>
</template>


<script>
import { bus } from '../main'

export default {
  props: ['entity', 'handle'],
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
      this.$http.put(this.url + '/handles/' + handle.id, {"name" : handle.name, "url" : handle.url}).then(function (response) {
          console.log("Handle updated")
          this.loadHandles(this.entity)
          //console.log(response)
        }, function (response) {
          console.log("Error Failed to update handle")
      })
    },
    confirmDeleteHandle: function(handle, e) {
      if(confirm("Are you sure you want to delete this handle?") == true){
        this.deleteEntity(handle, e)
      }
    },
    deleteHandle: function(handle, e) {
      e.preventDefault()
      console.log(handle)
      this.$http.delete(this.url + '/services/' + handle.id).then(function (response) {
          console.log("Handle deleted")
          this.loadEntities()
          //console.log(response)
        }, function (response) {
          console.log("Error Failed to delete handle")
      })

    },
    discardHandle: function(e) {
      this.handleSelected = !this.handleSelected
      document.getElementById("sidenav_action").style.marginLeft = "0px"
      this.handle.id = ""
    }
  }
}
</script>


<style lang="scss">

</style>
