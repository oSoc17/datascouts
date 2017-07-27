<template>
  <ul class="entities">
    <div class="empty-state empty-state-entities" v-show="entitiesIsEmpty">
      <li>You don't have any members yet. You can follow the steps on the right side to add one.</li>
    </div>

    <template v-for="item in computedEntities">

      <li v-bind:class="[{ active: isSelected && currentEntity.id == item.id }, 'entity']">
        <div v-on:click="selectEntity($event,item)">
          <div class="image_entity">
            <!--<img v-bind:src="item.image" alt="Entity avatar">-->
            <i class="fa fa-users"></i>
          </div>
          <p>{{item.name}}</p>
        </div>
        <input class="styled-checkbox checkbox" type="checkbox" :id="['styled-checkbox-entities-' + item.id]"
          :value="item.id" v-model="activeEntities">
          <label :for="['styled-checkbox-entities-' + item.id]"></label>
          <i class="fa fa-angle-right"></i>

      </li>
    </template>
    <transition name="slide-fade">
      <button type="button" class="btn_primary action"
              v-on:click.prevent="addEntityFromSearch(searchEntity)"
              v-show="searchNotFound"
      >
        Create {{searchEntity}}
      </button>
    </transition>
  </ul>
</template>

<script>
  import { bus } from '../../main'
  import {saveCurrentEntity, saveActiveEntities, getActiveEntities, saveActiveHandles, getActiveHandles, removeActiveHandles, removeActiveEntity } from '../../utils/storageService'


  export default {
    props: ['entities', 'searchEntity', 'currentEntity', 'services'],
    components:{},
    data () {
      return {
        activeEntities : getActiveEntities(),
        isSelected: false,
        searchNotFound : false,
        entitiesIsEmpty: false,
      }
    },
    created () {
      bus.$on('ENTITIES_IS_EMPTY', (bool) => this.entitiesIsEmpty = bool)
      bus.$on('ADD_ACTIVE_ENTITY', this.addToActiveEntities)
      this.loadStoredActiveEntities()
    },
    watch: {
      entities : function () {

        // this.activeEntities = this.entities.filter(e => e.active).map(e => e.id)
      },
      activeEntities : function(){
        //saveActiveEntities(this.activeEntities);
        this.updateLocalStorage()
        //bus.$emit('UPDATE_ACTIVE_HANDLES', this.activeHandles)
      }
    },
    computed: {
      computedEntities : function () {
        const found = this.entities.filter(entity => {
          const name = entity.name.toLowerCase()
          return name.indexOf(this.searchEntity.toLowerCase()) !== -1
        });
        this.searchNotFound = /*(found.length === 0) &&*/ (this.searchEntity.length !== 0);
        for(var i=0;i<found.length;i++){
          if(found[i].name===this.searchEntity){
            this.searchNotFound = false
          }
        }
        this.entitiesIsEmpty = (found.length === 0)
        bus.$emit('ENTITIES_IS_EMPTY', this.entitiesIsEmpty)
        return found
      },
    },
    methods: {
      addToActiveEntities: function(entityID) {
        console.log("entityID", entityID)
        this.activeEntities.push(entityID)
      },
      updateLocalStorage: function() {
        console.log("updating local storage")
        var handlesIDs = []
        var self = this
        var fetched = false
        this.activeEntities.forEach(function(entityID){
          //if(self.findIndex(getActiveEntities(), entityID)==-1){
          if(getActiveHandles(entityID).length==0){
            self.$http.get(`entities/${entityID}/handles`)
                .then(res => {
                  bus.$emit('HANDLES_IS_EMPTY', res.data.length === 0)
                  res.data.forEach(function({id}){handlesIDs.push(id)})
                  //saveCurrentEntity(entityID)
                  saveActiveHandles(entityID, handlesIDs)
                  bus.$emit('UPDATE_ACTIVE_HANDLES')
                  bus.$emit('FETCH_DATA')
                  fetched = true
                }).catch(console.error)
          }
        })
        /*getActiveEntities().forEach(function(entityID){
          if(self.findIndex(self.activeEntities, entityID)==-1){
            removeActiveHandles(entityID)
            //removeActiveEntity(entityID)
          }
        })*/
        saveActiveEntities(self.activeEntities)
        console.log("after update:",getActiveEntities())
        if(!fetched){bus.$emit('FETCH_DATA')}
      },
      getAllActiveHandles : function (){
        const handles = [];
        getActiveEntities().forEach(ent_id => {
          const activeHandles = getActiveHandles(ent_id);
          handles.push(... activeHandles);
        })
        console.log('Active Handles to fetch : ',handles);
        return handles;
      },
      findIndex: function(array, id) {
        var index = -1
        for(var i=0;i<array.length;i++){
          if(id == array[i].id){index = i; break;}
        }
        return index
      },
      selectEntity: function (e,item) {
        console.log(e.target)
        if(this.isSelected){ // Already, select a handle
          if(this.currentEntity.id == item.id) {
            this.isSelected = false
          }
        }
        else{
          this.isSelected = true
        }
        bus.$emit('CHANGE_CURRENT_ENTITY', item)
      },
      closeSideBar: function () {
        bus.$emit('CLOSE_HANDLES_SIDEBAR')
      },
      updateEntities: function() {
        bus.$emit('UPDATE_ENTITIES')
      },
      addEntityFromSearch: function(name){
        console.log('[EntitiesList] Add new entity from button create')
        bus.$emit('ADD_NEW_ENTITY_FROM_SEARCH', name)
      },
      loadStoredActiveEntities : function () {
        this.activeEntities = getActiveEntities();
      }
      // updateSelectedEntities: _debounce( function() {
        // var entitiesHTML = document.getElementsByClassName("entity")
        // for(var i=0;i<this.entities.length;i++){
        //   entitiesHTML[i].getElementsByClassName("checkbox")[0].checked = this.entities[i].active
        // }
      // }, 1),
    }
  }
</script>

<style >
  .fade-enter-active, .fade-leave-active {
    transition: opacity .5s
  }
  .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0
  }
</style>
