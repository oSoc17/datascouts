<template>
<transition name="slide-handles" @enter="openSidebar" @leave="closeSideBar">
  <div id="sidebar_handles">
    <editEntity v-bind:entity.sync="entity" v-cloak></editEntity>

    <h1>Social media accounts for {{entity.name}}</h1>
    <handlesList v-bind:handles="list" v-bind:actives="activeHandles"></handlesList>

    <addHandle :services="services" :actives="activeHandles" v-cloak></addHandle>
  </div>
  </transition>
</template>


<script>
  import _debounce  from 'lodash.debounce'

  import {
    saveActiveHandles,
    getActiveHandles,
    removeActiveHandles,

  } from '../../utils/storageService'
  import { bus } from '../../main'
  import EditEntity from '../entities/EditEntity.vue'
  import HandlesList from '../handles/HandlesList.vue'
  import AddHandle from '../handles/AddHandle.vue'


  export default {
    props: ['entity', 'services'],
    components:{
      EditEntity,
      HandlesList,
      AddHandle,
    },
    data () {
      return {
        list : [],
        activeHandles : [],
      }
    },
    watch :{
      entity : function (nEntity){
        this.entity = nEntity;
        if(typeof(this.entity.id) !== 'undefined'){
          this.loadHandlesForSelectedEntity();
          this.loadActiveHandles()
        }
      }
    },
    created () {
      this.loadActiveHandles();
    },
    mounted () {
      // No need for this event, replace by the wath on entity
      // bus.$on('LOAD_HANDLES', this.loadHandlesForSelectedEntity)
      bus.$on('UPDATE_ACTIVE_HANDLES', this.loadActiveHandles)
      bus.$on('UPDATE_ENTITY', this.updateEntity)
      bus.$on('DELETE_ENTITY', this.deleteEntity)

      bus.$on('INSERT_NEW_HANDLE', this.insertNewHandle)
      bus.$on('DELETE_LISTED_HANDLE', this.deleteHandle)

      bus.$on('CHANGE_ACTIVE_HANDLES', this.changeActiveHandles)


    },

    methods : {
      openSidebar : function() {
        const $elt = document.getElementById("sidebar_handles");
        $elt.style.transition = "all .25s ease"
        $elt.style.marginLeft = "0px"
        $elt.style.zIndex = 2
      },

      closeSideBar : function (){
        const $elt = document.getElementById("sidebar_handles");
        $elt.style.marginLeft = "-301px"
        $elt.style.transition = "all .5s ease"
        $elt.style.zIndex = -1

      },

      loadHandlesForSelectedEntity : function () {
        this.$http.get(`entities/${this.entity.id}/handles`)
            .then(res => {
              bus.$emit('HANDLES_IS_EMPTY', res.data.length === 0)

              this.list = res.data.map(h => {
                const {id, name, url, service_id, fetched_at} = h
                const service = this.services[service_id] || {};
                return {
                    id, name, url, service_id, fetched_at,
                    'service' : service.name,
                    'active' : true
                  }
              })
            })
            .catch(console.error)
      },

      loadActiveHandles : function (){
        this.activeHandles = getActiveHandles(this.entity.id);
        console.log("actives:",this.activeHandles)
      },

      updateEntity: function(name) {
        if(name && name !== this.entity.name){
          this.$http.put('entities/' + this.entity.id,{name})
              .then(res => bus.$emit('UPDATE_CURRENT_ENTITY', name))
              .catch(response => console.error)
        }
      },

      deleteEntity: function() {
        this.$http.delete('entities/' + this.entity.id)
            .then(res => bus.$emit('DELETE_CURRENT_ENTITY'))
            .catch(console.error)
      },

      insertNewHandle : function (handle) {
        console.log("adding ",handle.name," to ",this.entity.name )
        console.log(handle)
        this.$http.post('handles/'+ this.entity.id, handle)
          .then(({data}) => {
            const {id, name, url, service_id, fetched_at} = data

            const service = data.service || {}
            // Add on the top of the list
            this.list.unshift({
              id, name, url, service_id, fetched_at,
              'service' : service.name,
              'active' : true
            })
            bus.$emit('ADD_ACTIVE_ENTITY', this.entity.id)
            console.log("[HandleSidebar] New handle added")
            bus.$emit('ADD_ACTIVE_HANDLE', id)
          }).then(_ => bus.$emit('FETCH_DATA'))
          .catch(err => console.error("[HandleSidebar] Failed to add handle\n",err))
      },

      deleteHandle : function (id){
        this.list.splice(this.list.findIndex(e => e.id == id), 1)

        // Also need to delete this handles from the active handles
        // Get that list of active handles
        const actives = getActiveHandles(this.entity.id)
        // Get the position of the specified handle on that list
        const pos = actives.findIndex(h_id => h_id == id)

        // Check if that handle was active
        if(pos > -1) {
          actives.splice(pos, 1); // Remove that handle
          saveActiveHandles(this.entity.id, actives); // Store the new list
        }

      },

      changeActiveHandles : function (list) {
        saveActiveHandles(this.entity.id, list);
      },

    }


  }
</script>


<style>
/*
  .slide-handles-enter-active {
    margin-left  : 0px;
    transition: all .25s ease;
    z-index : 2;
  }
  .slide-handles-leave-active {
    // transition: all 1s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    margin-left  : -301px;
    transition: all .5s ease;
    z-index : -1;
  }
  .slide-handles-enter, .slide-handles-leave-to{
    transform: translateX(-301px);
    opacity: 0;
  }
*/
</style>
