<template>
  <div id="edit-entity">
    <button type="btn_secondary action" v-on:click="confirmEditEntity(entity, $event)">
      <i class="fa fa-pencil"></i>
      Edit
    </button>
    <button type="btn_secondary action" v-on:click="confirmDeleteEntity(entity, $event)">
      <i class="fa fa-trash"></i>
      Delete
    </button>
  </div>
</template>


<script>
import { bus } from '../main'

export default {
  props: ['entity', 'url'],
  components: {
  },
  data () {
    return {

    }
  },
  methods: {
    confirmEditEntity: function(entity, e){
      e.preventDefault()
      var newName = prompt("Enter a new name for your entity", entity.entity.name);
      if(newName != null){
        this.editEntity(entity, newName, e)
      }
    },
    editEntity: function(entity, newName, e) {
      var self = this
      e.preventDefault()
      console.log(entity)
      Vue.http.put(this.url + '/entities/'+ entity.entity.id,
      {"name": newName}).then(function (response) {
          console.log("Entity updated")
          bus.$emit('loadEntities')
          self.entity.entity.name = newName
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
      console.log(entity.name)
      Vue.http.delete(this.url + '/entities/' + entity.entity.id).then(function (response) {
          console.log("Entity deleted")
          bus.$emit('loadEntities')
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
