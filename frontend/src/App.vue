<template>
  <div class="full-screen">

    <div class="header">
      <a href="https://www.datascouts.eu"  class="logo">
        <img src="../assets/img/datascouts-logo.svg" alt="datascouts-logo">
      </a>
    </div>

    <div class="main">
      <transition name="slide-entities" appear>
        <entitiesSidebar v-show="showEntitiesBar"  v-bind:currentEntity="current.entity" v-bind:services="services"></entitiesSidebar>
      </transition>

      <handlesSidebar v-show="showHandles" v-bind:entity="current.entity" ></handlesSidebar>

      <editHandleSidebar v-show="showHandles && showEditHandle" v-bind:handle="current.handle"
        @close="closeEditHandleSidebar()"
      ></editHandleSidebar>

      <WaterfallDisplay></WaterfallDisplay>

    </div>
  </div>
</template>

<script>
  import { bus } from './main'
  import {
    removeActiveHandles,
    getServices,
    saveServices,

  } from './utils/storageService'
  import EntitiesSidebar  from './components/sidebars/EntitiesSidebar.vue'
  import HandlesSidebar  from './components/sidebars/HandlesSidebar.vue'
  import EditHandleSidebar  from './components/sidebars/EditHandleSidebar.vue'
  import WaterfallDisplay from './components/results/WaterfallDisplay.vue'

  export default {
    name: 'app',
    components : {
      EntitiesSidebar,
      HandlesSidebar,
      EditHandleSidebar,
      WaterfallDisplay
    },
    data () {
      return {
        showEntitiesBar : true,
        showHandles : false,
        showEditHandle : false,
        current : {
          entity: {},
          handle: {}
        },
      }
    },
    created () {
      this.loadServices()
      // bus.$on('LOADED_ENTITIES', this.updateEntities)

      bus.$on('CHANGE_CURRENT_ENTITY', this.changeCurrentEntity)
      bus.$on('UPDATE_CURRENT_ENTITY', this.updateCurrentEntity)
      bus.$on('DELETE_CURRENT_ENTITY', this.deleteCurrentEntity)

      bus.$on('CHANGE_CURRENT_HANDLE', this.changeCurrentHandle)
      bus.$on('UPDATE_CURRENT_HANDLE', this.updateCurrentHandle)
      bus.$on('DELETE_CURRENT_HANDLE', this.deleteCurrentHandle)

      // bus.$on('toggleHandleSidebar', x => this.showHandles = !this.showHandles);
      bus.$on('CLOSE_EDITHANDLE_SIDEBAR', this.closeEditHandleSidebar)
      bus.$on('CLOSE_HANDLES_SIDEBAR', this.closeHandlesSidebar)


    },
    mounted() {

    },
    watch: {

    },
    computed : {

    },

    methods: {
      loadServices : function (){
        const isCached = Object.keys(getServices()).length > 0
        if(!isCached){
          this.$http.get('services')
              .then(({data}) => {
                const services = data.reduce((list,media) => {
                  list[media.id] = media;
                  return list
                },{});
                saveServices(services)
              })
              .catch(console.error)
        }
      },

      closeEditHandleSidebar : function (){
        this.showEditHandle = false
      },
      closeHandlesSidebar : function (){
        this.showHandles = false
        this.closeEditHandleSidebar()
      },


      changeCurrentEntity : function (select) {
        if(select && select.id !== this.current.entity.id){
          this.current.entity = select
          this.showHandles = true
        }
        else{
          this.closeHandlesSidebar()
          this.current.entity = {}
        }
      },

      updateCurrentEntity : function (newName) {
        this.current.entity.name = newName
      },

      deleteCurrentEntity : function () {
        this.showHandles = false // Hide the HandleSidebar
        removeActiveHandles(this.current.entity.id); // Remove from the localStorage
        bus.$emit('DELETE_LISTED_ENTITY') // Send Event to delete Entity from the list
              
        this.current.entity = {}
      },

      changeCurrentHandle : function (select) {
        // No current Handle or different handle
        if(!this.current.handle || select.id !== this.current.handle.id){
          this.current.handle = select
        }
        this.showEditHandle = true // Show the editHandle Sidebar
      },

      updateCurrentHandle : function (newName) {
        this.current.handle.name = newName
      },

      deleteCurrentHandle : function () {
        this.showEditHandle = false // Close the editHandle Sidebar
        bus.$emit('DELETE_LISTED_HANDLE') // Send to HandleList cmd to delete
        this.current.handle = {}
      },


    }
  }
</script>

<style>

</style>
