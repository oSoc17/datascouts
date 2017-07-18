<template>
  <div id="root-element">
    <template v-for="item in entities">
      <div class="entity">
        <button type="button" v-on:click="selectEntity(item,$event)"
        v-if=" (item.entity.name.indexOf(searchEntity) !== -1 || searchEntity == '')">
          {{item.entity.name}}
        </button>
        <input type="checkbox" class="checkbox" name="checkbox" value=""
        v-if=" (item.entity.name.indexOf(searchEntity) !== -1 || searchEntity == '')"
        v-on:click="toggleEntity($event)">
      </div>
    </template>
  </div>
</template>

<script>
import { bus } from '../main'

export default {
  props:{
    'entities':{
      type: Array,
      required: false
    },
    'entity': {
      type: Array
    }
  },
  components:{

  },
  data () {
    return {
      currentEntity: [],
      isEntitySelected: false
      searchEntity: '',
    }
  },
  created () {
    bus.$on('selectEntity', (entity, e) => {
      this.selectEntity(entity, e)
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
      //console.log(entity)
      if(!this.isEntitySelected || this.currentEntity.id==entity.entity.id){
        this.isEntitySelected = !this.isEntitySelected
      }
      bus.$emit('changeCurrentEntity', entity)
      if(this.isEntitySelected){
        document.getElementById("sidenav_handles").style.marginLeft = "250px"
      }
      else{
        document.getElementById("sidenav_handles").style.marginLeft = "0px"
        bus.$emit('discardHandle')
      }
      bus.$emit('loadHandles', entity)
    },
    updateSelectedEntities: _.debounce( function() {
      //set all checkboxes to the appropriate state
      var entitiesHTML = document.getElementsByClassName("entity")
      for(var i=0;i<this.entities.length;i++){
        entitiesHTML[i].getElementsByClassName("checkbox")[0].checked = this.entities[i].active
      }
    }, 1),
    toggleEntity: _.debounce( function (e){
      var entitiesHTML = document.getElementsByClassName("entity")
      for(var i=0;i<this.entities.length;i++){
        this.entities[i].active = entitiesHTML[i].getElementsByClassName("checkbox")[0].checked
      }
    }, 1000)
  }
</script>

<style lang="scss">

</style>
