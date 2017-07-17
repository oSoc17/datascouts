<template>
  <div id="root-element">
    <entitiesList></entitiesList>

  </div>
</template>

<script>
import EntitiesList from './EntitiesList.vue'

export default {
  name: 'entities',
  components: {
    'entitiesList': EntitiesList
  },
  data () {
    return {
      entities: [],
    }
  },
  methods: {
    loadEntities: function() {
      var self = this
      this.$http.get(this.url + '/entities').then(function (response) {
        var newEntities = []
        var bool
        var index
        // response.data.forEach(e => this.selectedEntities.push(e));
        response.data.forEach(function(entity) {
          bool = false
          if(self.entities.length != 0 ){
            for(var i=0;i<self.entities.length;i++){
              if(entity.id == self.entities[i].entity.id){bool = true; index = i; break;}
            }
            if(!bool){
              newEntities.push({"entity" : entity, "active": true})
            }
            else{
              newEntities.push({"entity" : entity, "active": self.entities[index].active})
            }
          }
          else{
            newEntities.push({"entity" : entity, "active": true})
          }
        });
          self.entities = newEntities.slice()
          //load handles for each entity
          for(var i=0;i<self.entities.length;i++){
            self.loadHandles(self.entities[i])
            console.log(self.entities[i])
          }
          //console.log(response)
        }, function (response) {
          console.log("Error Failed to get data")
          console.log(response)
      })
    },
    loadHandles: function(item) {
      var self = this
      var bool
      var index
      var newHandles = []
      this.$http.get(this.url + '/entities/' + item.entity.id + '/handles').then(function (response) {
        if(typeof(item.handles) == "undefined"){
          item.handles = []
          for(var i=0; i<response.data.length; i++){
            item.handles.push({"handle" : response.data[i], "active" : true})
          }
          this.currentHandles = item.handles.slice()
          console.log("Handles loaded")
        }
        else{
          console.log("updating handles")
          for(var i=0; i<response.data.length; i++){
            bool = false
            for(var j=0;j<item.handles.length;j++){
              if(item.handles[j].handle.id == response.data[i].id){bool = true; index = j; break;}
            }
            if(!bool){
              newHandles.push({"handle" : response.data[i], "active": true})
            }
            else{
              newHandles.push({"handle" : response.data[i], "active": item.handles[index].active})
            }
          }
          item.handles = newHandles.slice()
          this.currentHandles = item.handles.slice()
        }
        }, function (response) {
          console.log("Error Fail to get data")
          console.log(response)
      })
    }
  }
}
</script>

<style lang="scss">

</style>
