<template>
  <div id="root-element">
    <entitiesList entities="entities"></entitiesList>
    <addEntity></addEntity>
  </div>
</template>

<script>
import EntitiesList from './EntitiesList.vue'
import AddEntity from './AddEntity.vue'

export default {
  name: 'entities',
  components: {
    'entitiesList': EntitiesList,
    'addEntity': AddEntity
  },
  data () {
    return {
      entities: [],
    }
  },
  mounted: function() {
    this.loadEntities()
  },
  methods: {
    findIndexArray: function(object, array, objectType, objectIdentifier) {
      var index = -1
      for(var i=0;i<array.length;i++){
        if(object.objectIdentifier == array[i].objectType.objectIdentifier){index = i; break;}
      }
      return index
    },
    loadEntities: function() {
      var self = this
      this.$http.get(this.url + '/entities').then(function (response) {
        var newEntities = []
        var index
        if (self.entities.length !== 0) {
          response.data.forEach(function(entity){
            index = self.findIndexArray(entity, self.entities, 'entity', 'id')
            newEntities.push({"entity" : entity, "active": (index == -1 ? true : self.entities[index].active) })
          })
        }
        else{
          response.data.forEach(function(entity) {
            newEntities.push({"entity" : entity, "active": true})
          })
        }
        self.entities = newEntities.slice()

        //load handles for each entity
        self.entities.forEach(entity => self.loadHandles(entity))

        }, function (response) {
          console.log("Error Failed to get data")
          console.log(response)
      })
    },
    loadHandles: function(entity) {
      var self = this
      var index
      var newHandles = []
      this.$http.get(this.url + '/entities/' + entity.entity.id + '/handles').then(function (response) {
        if(typeof(entity.handles) !== "undefined"){
          response.data.forEach(function(handle){
            index = findIndexArray(handle, entity.handles, 'handle', 'id')
            newHandles.push({"handle" : handle, "active": (index == -1 ? true : entity.handles[index].active) })
          })
          entity.handles = newHandles.slice()
          this.currentHandles = entity.handles.slice()
        }
        else{
          entity.handles = []
          response.data.forEach(handle => entity.handles.push({"handle" : handle, "active" : true}))
          this.currentHandles = entity.handles.slice()
        }
        }, function (response) {
          console.log("Error Failed to get data")
          console.log(response)
      })
    }
  }
}
</script>

<style lang="scss">

</style>
