<template>
  <div id="app">
    <entitiesSidebar></entitiesSidebar>
  </div>
</template>

<script>
import EntitiesSidebar from './EntitiesSidebar.vue'
import { bus } from './main.js'

export default {
  name: 'app',
  components: {
    'entitiesSidebar': EntitiesSidebar
  },
  data () {
    return {
      isLoading: false,
      entities: []
    }
  },
  methods: {
  fetchData: function(entities) {
    var self = this
    //display load templates & adjust them to the screen, hide loading elements
    this.isLoading = true
    document.getElementById("wf-container").style.visibility = "hidden"
    var boxes = document.getElementsByClassName("template_box")
    this.$nextTick(function(){
      for(var i=0;i<boxes.length;i++){
        boxes[i].style.width = this.loadingTemplatesWidth
      }
    })

    //creating body of the post request
    var handlesIds = []
    var socialMedia
    if(self.entities.length != 0 ){
      for(var i=0;i<self.entities.length;i++){
        if(self.entities[i].active){
          for(var j=0;j<self.entities[i].handles.length;j++){
            if(self.entities[i].handles[j].active){
              handlesIds.push(self.entities[i].handles[j].handle.id)
            }
          }
        }

      }
      for(item in self.socialMediaFilters){
        if(item.active){
          socialMedia.push(item.name)
        }
      }

      this.$http.post(this.url + '/providers/fetch', {entitiesIds, socialMedia}).then(function (response) {
          self.items = response.data
          //console.log(response)
        }, function (response) {
          console.log("Error Fail to get data from server. Loading mockdata instead.")
          this.$http.get(this.mockDataTwitter).then(function (response) {
              self.items = response.data
              //console.log(response)
            }, function (response) {
              console.log("Error Fail to load mockdata")
          });
      });
    }
    else{
      this.$http.get(this.mockDataTwitter).then(function (response) {
          self.items = response.data
          //console.log(response)
        }, function (response) {
          console.log("Error Fail to load mockdata")
      });
    }
  }
}
}
</script>
