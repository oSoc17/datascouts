<template>
  <div id="sidebar_entities">
    <button class="collapse"
      v-on:click="closeSideBar()">
      <i class="fa fa-angle-left" ></i>
    </button>

    <form action="">
      <div class="form-group">
        <label class="hide" for="">Entity</label>
        <div class="search-entity">
          <input 
            name="name"
            type="text"
            placeholder="Search for a member"
            v-model="searchEntity"
            v-validate="'min:3'"
            data-vv-validate-on="none"/>
          <div class="input-icon">
            <i class="fa fa-search"></i>
          </div>
        </div>

        <div class="validation-error" v-show="errors.has('name')">
          <div class="error-icon">
            <i class="fa fa-exclamation "></i>
          </div>
          <ul>
            <li>{{errors.first('name')}}</li>
          </ul>
        </div>

      </div>
    </form>

    <entitiesList v-bind:entities="list" v-bind:currentEntity="currentEntity" v-bind:searchEntity="searchEntity"
    v-bind:services="services"></entitiesList>


    <addEntity></addEntity>

  </div>
</template>


<script>
  import _debounce  from 'lodash.debounce'

  import { bus } from '../../main'
  import EntitiesList from '../entities/EntitiesList.vue'
  import AddEntity from '../entities/AddEntity.vue'

  import { saveActiveEntities, getActiveEntities } from '../../utils/storageService'

  export default {
    props : ['currentEntity', 'services'],
    components: {
      'entitiesList' : EntitiesList,
      'addEntity' : AddEntity,
    },
    data () {
      return {
        list : [],
        searchEntity : ''
      }
    },
    created () {
      this.loadEntities()

    },
    mounted () {
      bus.$on('ADD_NEW_ENTITY',this.insertNewEntity)
      bus.$on('ADD_NEW_ENTITY_FROM_SEARCH',this.insertNewEntity)
      bus.$on('DELETE_LISTED_ENTITY',this.deleteEntity)
      bus.$on('UPDATE_ENTITIES',this.updateEntities)
      bus.$on('VALIDATE_CREATE_ENTITY', this.validateCreateEntity)
    },
    watch: {
       searchEntity : function () {
        if(this.errors.any()){
          this.errors.clear()
        }  
      }
    },
    methods: {
      validateCreateEntity: function(){
        this.$validator.validateAll();
        if (this.errors.any()) {
          bus.$emit('ERROR_CREATE_ENTITY')
        }
      },
      findEntity: function (entity) {
        return this.list.find(e => e.id === entity.id);
      },
      loadEntities: function() {
        return this.$http.get('entities?fields=id,name,url')
            .then(res => {
              // Already got a bunch of entities
              if(this.list.length !== 0){
                res.data.forEach(entity => {
                  const foundEntity = this.findEntity(entity)
                  if(!foundEntity){
                    foundEntity['active'] = false;
                  }
                })
              }else{ // My Entities List is empty
                this.list = res.data.map(({id,name,url})=>{
                  return {id, name, url,
                    active : false
                  }
                })

              }
            })
            .catch(console.error)

      },
      closeSideBar: function() {
        bus.$emit('CLOSE_HANDLES_SIDEBAR')
      },
      insertNewEntity : function(name){
        this.searchEntity = ""
        this.$http.post('entities', {"name" : name || this.name})
          .then(({data}) => {
            this.searchEntity = ''
            // Add on the top of the list
            this.list.unshift({
              'id' : data.id,
              'name' :data.name,
              'active' : true
            })
          })
          .catch(console.error)
      },

      deleteEntity : function (){
        const i = this.list.findIndex(e => e.id === this.currentEntity.id)
        this.list.splice(i,1)

        // Also need to delete this entity
        // Get that list of active entities
        const actives = getActiveEntities()
        // Get the position of the specified entity on that list
        const pos = actives.findIndex(h_id => h_id == this.currentEntity.id)

        // Check if that handle was active
        if(pos > -1) {
          actives.splice(pos, 1); // Remove that entity
          saveActiveEntities(actives); // Store the new list
        }
      },

      updateEntities: _debounce(function() {

      },1),

    }
  }
</script>


<style>

</style>