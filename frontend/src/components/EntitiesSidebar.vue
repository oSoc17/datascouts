<template>
  <div id="root-element">
    <entitiesList entities="entities, currentEntity"></entitiesList>
    <addEntity></addEntity>
    <handlesSidebar></handlesSidebar>
  </div>
</template>


<script>
import EntitiesList from './EntitiesList.vue'
import AddEntity from './AddEntity.vue'
import HandlesSidebar from './HandlesSidebar.vue'
import { bus } from '../main'

export default {
  name: 'entities',
  components: {
    'entitiesList': EntitiesList,
    'addEntity': AddEntity,
    'handlesSidebar': HandlesSidebar
  },
  data () {
    return {
      entities: [],
      currentEntity
    }
  }
  created () {
    bus.$on('loadHandles', (entity) => {
      this.loadHandles(entity)
    }),
    bus.$on('loadEntities', this.loadEntities())
  },
  mounted: function() {
    this.loadEntities()
  },
  methods: {
    findIndex: function(object, array, objectType, objectIdentifier) {
      var index = -1
      for(var i=0;i<array.length;i++){
        if(object.objectIdentifier == array[i].objectType.objectIdentifier){index = i; break;}
      }
      return index
    },
    loadEntities: function() {
      this.$http.get(this.url + '/entities').then(function (response) {
        var newEntities = []
        var index
        if (this.entities.length !== 0) {
          response.data.forEach(function(entity){
            index = this.findIndex(entity, this.entities, 'entity', 'id')
            newEntities.push({"entity" : entity, "active": (index == -1 ? true : this.entities[index].active) })
          })
        }
        else{
          response.data.forEach(function(entity) {
            newEntities.push({"entity" : entity, "active": true})
          })
        }
        this.entities = newEntities.slice()

        //load handles for each entity
        this.entities.forEach(entity => this.loadHandles(entity))

        }, function (response) {
          console.log("Error Failed to get data")
          console.log(response)
      })
    },
    loadHandles: function(entity) {
      var index
      var newHandles = []
      this.$http.get(this.url + '/entities/' + entity.entity.id + '/handles').then(function (response) {
        if(typeof(entity.handles) !== "undefined"){
          response.data.forEach(function(handle){
            index = findIndex(handle, entity.handles, 'handle', 'id')
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
