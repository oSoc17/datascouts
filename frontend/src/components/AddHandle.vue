<template>
  <form action="" class="slide-up" id="handle_form">
    <div class="form-group hidden">
      <button class="btn_primary social_media">Twitter</button>
      <button class="btn_primary social_media">Facebook</button>
      <button class="btn_primary social_media">YouTube</button>
    </div>
    <div class="form-group">
      <button class="btn_primary action" id="handle_add">
        <i class="plus">+</i>
        Add a handle
      </button>
    </div>
  </form>
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
