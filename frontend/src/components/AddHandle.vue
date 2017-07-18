<template>
  <div id="add-handle">
    <button type="button" v-on:click="promptAddHandle(entity, $event)">Add handle</button>
  </div>
</template>

<script>
import { bus } from '../main'

export default {
  props:['url','entity'],
  components:{

  },
  data () {
    return {

    }
  },
  methods: {
    promptAddHandle: function(entity, e){
      e.preventDefault()
      var name = prompt("Enter a name for your handle", "");
      if(name != null){
        var url = prompt("Enter a url for your handle", "");
        if(url != null){
          var handle = {"name" : name, "url" : url, "socialMedia": 'twitter'}
          this.addHandle(entity, handle, e)
        }
      }
    },
    addHandle: function (entity, handle, e) {
      var self = this
      e.preventDefault()
      Vue.http.post(this.url + '/handles/'+ entity.entity.id, {"name" : handle.name, "url" : handle.url}).then(function (response) {
        bus.$emit('loadHandles', self.entity)
        console.log("Handle added")
        }, function (response) {
          console.log("Error Failed to add handle")
      })
    }
  }
}
</script>

<style lang="scss">

</style>
