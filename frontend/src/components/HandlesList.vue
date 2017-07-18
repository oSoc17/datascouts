<template>
  <div id="root-element">
    <template v-for="handle in entity.handles">
      <div class="handle">
        <button type="button" v-on:click="selectHandle(handle,$event)">
          {{item.handle.name}}
        </button>
        <input type="checkbox" class="checkbox" name="checkbox" value=""
        v-on:click="toggleHandle($event)">
      </div>
    </template>
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
      isHandleSelected: false
    }
  },
  created () {
    bus.$on('selectHandle', (handle, e) => {
      this.selectHandle(handle, e)
    })
  },
  watch: {
    entities: function(updatingEntities){
      this.updateSelectedEntities()
    }
    entity: function(updatingHandles){
      this.updateSelectedHandles()
    }
  },
  methods: {
    selectHandle: function(handle, e) {
      e.preventDefault()
      //console.log(entity)
      this.isHandleSelected = !this.isHandleSelected
      bus.$emit('changeCurrentHandle', handle)
      if(this.isHandleSelected){
        document.getElementById("sidenav_action").style.marginLeft = "500px"
      }
      else{
        document.getElementById("sidenav_action").style.marginLeft = "0px"
      }
    },
    updateSelectedHandles: _.debounce( function() {
      //set all checkboxes to the appropriate state
      var handlesHTML = document.getElementsByClassName("handle")
      var index = this.getIndexCurrentEntity()
      for(var i=0;i<this.entity.handles.length;i++){
        handlesHTML[i].getElementsByClassName("checkbox")[0].checked = this.entity.handles[i].active
      }
    }, 1),
    toggleHandle: _.debounce( function (e){
      var handlesHTML = document.getElementsByClassName("handle")
      var index = this.getIndexCurrentEntity()
      for(var i=0;i<this.entity.handles.length;i++){
        this.entity.handles[i].active = handlesHTML[i].getElementsByClassName("checkbox")[0].checked
      }
      this.fetchData()
    }, 1000)
  }
</script>

<style lang="scss">

</style>
