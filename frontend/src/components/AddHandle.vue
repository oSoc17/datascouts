<template>
  <form action="" class="slide-up" id="handle_form">
    <div class="form-group hidden">
      <button class="btn_primary social_media" v-on:click="promptAddHandle('twitter', $event)">
        Twitter
      </button>
      <button class="btn_primary social_media" v-on:click="promptAddHandle('facebook', $event)">
        Facebook
      </button>
      <button class="btn_primary social_media" v-on:click="promptAddHandle('youtube', $event)">
        YouTube
      </button>
    </div>
    <div class="form-group">
      <button class="btn_primary action" id="handle_add" v-on:click="addHandle($event)">
        <i class="plus">+</i>
        Add a handle
      </button>
    </div>
  </form>
</template>

<script>
import { bus } from '../main'

export default {
  props:['url','entity', 'socialMedia'],
  components:{
  },
  data () {
    return {

    }
  },
  methods: {
    /*promptAddHandle: function(entity, e){
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
    }*/
    addHandle: function (e) {
      e.preventDefault()
      document.querySelector('form.slide-up#handle_form .form-group').classList.toggle('hidden');
    },
    promptAddHandle: function(socialMedia, e){
      e.preventDefault()
      if(socialMedia == "twitter"){
        var name = prompt("Enter a name for your handle", "");
        if(name != null){
          for(var i=0;i<this.socialMedia.length;i++){
            if(this.socialMedia[i].name == "Twitter"){
              var handle = {"name" : name, "socialMedia": this.socialMedia[i].id}
              break
            }
          }
          var self = this
          Vue.http.post(self.url + '/handles/'+ self.entity.entity.id, handle).then(function (response) {
            bus.$emit('loadHandles', self.entity)
            console.log("Handle added")
            }, function (response) {
              console.log("Error Failed to add handle")
          })

        }
      }
      else{
        alert("This social media is not supported yet")
      }
      document.querySelector('form.slide-up#handle_form .form-group').classList.toggle('hidden')
    }
  }
}
</script>

<style lang="scss">

</style>
