<template>
  <ul class="entities">
    <template v-for="item in entities">
      <li class="entity" v-if=" (item.entity.name.indexOf(searchEntity) !== -1 || searchEntity == '')">
        <div class="image_entity">
          <img v-bind:src="item.entity.image" alt="">
        </div>
        <p v-on:click="selectEntity(item,$event)">
          {{item.entity.name}}
        </p>
        <input type="checkbox" class="checkbox" name="checkbox" value="" v-on:click="toggleEntity($event)">
        <i class="fa fa-angle-right"></i>
      </li>
      <!--<button type="button" v-on:click="selectEntity(item,$event)"
      v-if=" (item.entity.name.indexOf(searchEntity) !== -1 || searchEntity == '')">
        {{item.entity.name}}
      </button>
      <input type="checkbox" class="checkbox" name="checkbox" value=""
      v-if=" (item.entity.name.indexOf(searchEntity) !== -1 || searchEntity == '')"
      v-on:click="toggleEntity($event)">-->
    </template>
    <button type="button" v-on:click="addEntity(searchEntity, $event)" v-if="searchEntity != ''">create {{searchEntity}}</button>
  </ul>
</template>

<script>
import { bus } from '../main'

export default {
  props:['entities','entity', 'searchEntity'],
  components:{

  },
  data () {
    return {
      currentEntity: [],
      isEntitySelected: false,
    }
  },
  created () {
    bus.$on('selectEntity', (entity, e) => {
      this.selectEntity(entity, e)
    }),
    bus.$on('closeSideBars', () => {
      this.closeSideBars()
    })
  },
  watch: {
    entities: function(updatingEntities){
      this.updateSelectedEntities()
    }
  },
  methods: {
    selectEntity: function (entity, e) {
      e.preventDefault()
      if(!this.isEntitySelected || this.entity.entity.id==entity.entity.id){
        this.isEntitySelected = !this.isEntitySelected
      }
      bus.$emit('changeCurrentEntity', entity)
      if(this.isEntitySelected){
        document.getElementById("sidebar_handles").style.marginLeft = "0px"
        document.getElementById("sidebar_handles").style.transition = "all .25s ease"
        document.getElementById("sidebar_handles").style.zIndex = 2
        //document.querySelector('.entity').classList.add("active")
      }
      else{
        this.closeSideBars()
      }
      bus.$emit('loadHandles', entity)
    },
    closeSideBars:function(){
      bus.$emit('handleNotSelected')
      bus.$emit('discardHandle')
      document.getElementById("sidebar_handles").style.marginLeft = "-301px"
      document.getElementById("sidebar_handles").style.transition = "all .25s ease"
      document.getElementById("sidebar_handles").style.zIndex = -1
      //document.querySelector('.entity').classList.remove("active")
    },
    updateSelectedEntities: _.debounce( function() {
      //set all checkboxes to the appropriate state
      var entitiesHTML = document.getElementsByClassName("entity")
      for(var i=0;i<this.entities.length;i++){
        entitiesHTML[i].getElementsByClassName("checkbox")[0].checked = this.entities[i].active
      }
    }, 1),
    toggleEntity: function (e){
      var entitiesHTML = document.getElementsByClassName("entity")
      for(var i=0;i<this.entities.length;i++){
        this.entities[i].active = entitiesHTML[i].getElementsByClassName("checkbox")[0].checked
      }
      this.fetchData()
    },
    addEntity: function(name, e){
      console.log('adding entity')
      e.preventDefault()
      bus.$emit('addEntity', name, e)
      this.searchEntity = ""
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
