<template>
  <ul class="handles">
    <template v-for="item in entity.handles">
      <li class="handle">
        <div class="icon-handle">
          <i class="icon-handle fa fa-twitter"></i>
        </div>
        <p v-on:click="selectHandle(item,$event)">
          {{item.handle.name}}
        </p>
        <input type="checkbox" class="checkbox" name="checkbox" value=""
        v-on:click="toggleHandle($event)">
      </li>
    </template>
  </ul>
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
    }),
    bus.$on('handleNotSelected', () => {
      this.handleNotSelected()
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
      var handle = document.querySelector('.handle');
      var sidebar_action = document.getElementById('sidebar_actions')
      if(this.isHandleSelected){
        sidebar_actions.style.marginLeft = "-1px";
        sidebar_actions.style.transition = "all .25s ease";
        sidebar_actions.style.zIndex = 3;
        handle.classList.add("active");
      }
      else{
        sidebar_actions.style.marginLeft = "-201px";
        sidebar_actions.style.transition = "all .25s ease";
        sidebar_actions.style.zIndex = -2;
        handle.classList.remove("active");
      }
    },
    handleNotSelected: function(){
      this.isHandleSelected = true
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
