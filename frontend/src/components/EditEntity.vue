<template>
  <div id="root-element">

  </div>
</template>


<script>
import { bus } from '../main'

export default {
  components: {
  },
  data () {
    return {

    }
  }
  created () {

  },
  mounted: function() {
    this.loadEntities()
  },
  methods: {
    confirmEditEntity: function(entity, e){
      e.preventDefault()
      var newName = prompt("Enter a new name for your entity", entity.name);
      if(newName != null){
        this.editEntity(entity, newName, e)
      }
    },
    editEntity: function(entity, newName, e) {
      e.preventDefault()
      console.log(entity)
      this.$http.put(this.url + '/entities/'+ entity.id,
      {"name": newName}).then(function (response) {
          this.currentEntity = response.data
          console.log("Entity updated")
          this.loadEntities()
          //console.log(response)
        }, function (response) {
          console.log("Error Failed to edit entity")
      })
    },
    confirmDeleteEntity: function(entity, e) {
      if(confirm("Are you sure you want to delete this entity?") == true){
        this.deleteEntity(entity, e)
      }
    },
    deleteEntity: function(entity, e) {
      e.preventDefault()
      var self = this
      console.log(entity.name)
      this.$http.delete(this.url + '/entities/' + entity.id).then(function (response) {
          var index = self.getIndexCurrentEntity()
          this.selectEntity(self.entities[i], e)
          console.log("Entity deleted")
          this.loadEntities()
          //console.log(response)
        }, function (response) {
          console.log("Error Failed to delete entity")
      })

    }
  }
}
</script>


<style lang="scss">

</style>
