<template>
  <ul class="entities">
    <div class="empty-state empty-state-entities" v-show="entitiesIsEmpty">
      <li>You don't have any entitites yet. You can follow the steps on the right side to add one.</li>
    </div>

    <template v-for="item in computedEntities">

      <li class="entity" v-on:click="selectEntity($event,item)">
        <div class="image_entity">
          <img v-bind:src="item.image" alt="Entity avatar">
        </div>
        <p>{{item.name}}</p>
        <input type="checkbox" class="checkbox" name="checkbox"
          :click="toggleEntity()"
          :value="item.id" v-model="activeEntities">
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

  export default {
    props: {
      entities : Array,
      searchEntity : String
    },
    components:{},
    data () {
      return {
        activeEntities : [],
        isEntitySelected: false,
        searchNotFound : false,
        entitiesIsEmpty: false,
      }
    },
    created () {
      bus.$on('ENTITIES_IS_EMPTY', (bool) => this.entitiesIsEmpty = bool)
    },
    watch: {
      entities : function () {
        this.activeEntities = this.entities.filter(e => e.active).map(e => e.id)
      },
      activeEntities : function(){
        console.log('Active entities IDs :',this.activeEntities);
        bus.$emit('UPDATE_ACTIVE_HANDLES', this.activeHandles)
      }
    },
    computed: {
      computedEntities : function () {
        const found = this.entities.filter(entity => {
          const name = entity.name.toLowerCase()
          return name.indexOf(this.searchEntity.toLowerCase()) !== -1
        });
        this.searchNotFound = (found.length === 0) && (this.searchEntity.length !== 0);
        return found
      },


    },
    methods: {
      selectEntity: function (e,item) {
        console.log(e.target)
        bus.$emit('CHANGE_CURRENT_ENTITY', item)
      },
      toggleEntity: function () {

      },
      updateEntities: function() {
        bus.$emit('UPDATE_ENTITIES')
      },
      addEntityFromSearch: function(name){
        console.log('[EntitiesList] Add new entity from button create')
        bus.$emit('ADD_NEW_ENTITY_FROM_SEARCH', name)
      },
      // updateSelectedEntities: _debounce( function() {
        // var entitiesHTML = document.getElementsByClassName("entity")
        // for(var i=0;i<this.entities.length;i++){
        //   entitiesHTML[i].getElementsByClassName("checkbox")[0].checked = this.entities[i].active
        // }
      // }, 1),
    }
  }
</script>

<style lang="scss">
  .fade-enter-active, .fade-leave-active {
    transition: opacity .5s
  }
  .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0
  }
</style>
