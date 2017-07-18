<template>
  <div id="root-element">
    <button type="button" v-on:click="promptAddHandle(entity, $event)">Add handle</button>
  </div>
</template>

<script>
import { bus } from '../main'

export default {
  props:{
    'entity': {
      type: Array
    }
  },
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
      e.preventDefault()
      this.$http.post(this.url + '/handles/'+ entity.entity.id, {"name" : handle.name, "url" : handle.url}).then(function (response) {
        this.loadHandles(entity)
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
