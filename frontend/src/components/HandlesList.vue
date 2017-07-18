<template>
  <div id="handles-list">
    <template v-for="item in entity.handles">
      <div class="handle">
        <button type="button" v-on:click="selectHandle(item,$event)">
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
  props:['entity'],
  components:{

  },
  data () {
    return {
      isHandleSelected: false,
    }
  },
  created () {
    bus.$on('selectHandle', (handle, e) => {
      this.selectHandle(handle, e)
    }),
    bus.$on('handleSelected', () => {
      this.handleSelected()
    })
  },
    watch: {
    entities: function(updatingEntities){
      this.updateSelectedEntities()
    },
    entity: function(updatingHandles){
      this.updateSelectedHandles()
    }
  },
  methods: {
    selectHandle: function(handle, e) {
      e.preventDefault()
      bus.$emit('changeCurrentHandle', handle)
      this.handleSelected()
    },
    updateSelectedHandles: _.debounce( function() {
      //set all checkboxes to the appropriate state
      var handlesHTML = document.getElementsByClassName("handle")
      for(var i=0;i<this.entity.handles.length;i++){
        handlesHTML[i].getElementsByClassName("checkbox")[0].checked = this.entity.handles[i].active
      }
    }, 1),
    toggleHandle: function (e){
      var handlesHTML = document.getElementsByClassName("handle")
      for(var i=0;i<this.entity.handles.length;i++){
        this.entity.handles[i].active = handlesHTML[i].getElementsByClassName("checkbox")[0].checked
      }
      bus.$emit('updateHandles', this.entity)
      this.fetchData()
    },
    handleSelected: function (){
      this.isHandleSelected = !this.isHandleSelected
      if(this.isHandleSelected){
        document.getElementById("sidenav_action").style.marginLeft = "500px"
      }
      else{
        document.getElementById("sidenav_action").style.marginLeft = "0px"
      }
    },
    fetchData: _.debounce( function(){
      console.log("fetching data")
      bus.$emit('fetchData')
    }, 750)
  }
}
</script>

<style lang="scss">

</style>
