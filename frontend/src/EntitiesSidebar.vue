<template>
  <div id="sidebar_entities">
    <button class="collapse">
      <i class="fa fa-angle-left"></i>
    </button>

    <entitiesList v-bind:entities="entities" v-bind:entity="currentEntity"></entitiesList>
    <addEntity v-bind:url="url"></addEntity>
    <handlesSidebar v-bind:entity="currentEntity" v-bind:url="url"></handlesSidebar>
  </div>
</template>


<script>
import EntitiesList from './components/EntitiesList.vue'
import AddEntity from './components/AddEntity.vue'
import HandlesSidebar from './components/HandlesSidebar.vue'
import { bus } from './main.js'

export default {
  props: ['url'],
  components: {
    'entitiesList': EntitiesList,
    'addEntity': AddEntity,
    'handlesSidebar': HandlesSidebar
  },
  data () {
    return {
      entities: [],
      currentEntity: {
        entity: '',
        active: false,
        handles: []
      },
      currentHandles: [],
      mockDataTwitter: 'http://www.json-generator.com/api/json/get/ckwxgssyXm?indent=2',
    }
  },
  created () {
    bus.$on('loadHandles', (entity) => {
      this.loadHandles(entity)
    }),
    bus.$on('loadEntities', () => {this.loadEntities()}),
    bus.$on('changeCurrentEntity', (entity) => {
      this.changeCurrentEntity(entity)
    }),
    bus.$on('updateHandles', (entity) => {
      this.currentEntity.handles = entity.handles
      console.log("updatingHandles")
    })
  },
  mounted: function() {
    this.loadEntities()
  },
  methods: {
    changeCurrentEntity: function(entity){
      this.currentEntity = entity
    },
    findIndex: function(object, array, objectType) {
      var index = -1
      for(var i=0;i<array.length;i++){
        if(object.id == array[i][objectType].id){index = i; break;}
      }
      return index
    },
    loadEntities: function() {
      var self = this
      Vue.http.get(self.url + '/entities').then(function (response) {
        var newEntities = []
        var index
        var newEntity
        if (self.entities.length !== 0) {
          response.data.forEach((entity)=>{
            index = self.findIndex(entity, self.entities, 'entity')
            if(index == -1){
              newHandlesEntity = {"entity" : entity, "active": true }
              self.loadHandles(entity)
            }
            else{
              newEntity = {"entity" : entity, "handles": self.entities[index].handles, "active": self.entities[index].active}
            }
            newEntities.push(newEntity)
          })
          console.log("entities loaded")
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
      var index
      var newHandles = []
      var self = this
      Vue.http.get(self.url + '/entities/' + entity.entity.id + '/handles').then(function (response) {
        if(typeof(entity.handles) !== "undefined"){
          response.data.forEach(function(handle){
            index = self.findIndex(handle, entity.handles, 'handle')
            newHandles.push({"handle" : handle, "active": (index == -1 ? true : entity.handles[index].active) })
          })
          entity.handles = newHandles.slice()
          self.currentHandles = entity.handles.slice()
        }
        else{
          entity.handles = []
          response.data.forEach(handle => entity.handles.push({"handle" : handle, "active" : true}))
          self.currentHandles = entity.handles.slice()
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
