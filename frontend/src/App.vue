<template>
  <div class="full-screen">

    <div class="header">
      <a href="https://www.datascouts.eu"  class="logo">
        <img src="../assets/img/datascouts-logo.svg" alt="datascouts-logo">
      </a>
    </div>

    <div class="main">

      <entitiesSidebar v-bind:url="url" v-bind:currentEntity="currentEntity"></entitiesSidebar>

      <handlesSidebar v-bind:entity="currentEntity" v-bind:url="url"></handlesSidebar>

      <editHandle v-bind:entity="entity" v-bind:url="url" v-bind:handle="currentHandle"></editHandle>

      <div id="content">
        <div class="flashmessage">You succesfully created an entity called {{ entity }}</div>

        <div class="filters">
          <form action="">
            <div class="form-group">
              <input type="checkbox">
              <label for="">Twitter</label>
            </div>
            <div class="form-group">
              <input type="checkbox">
              <label for="">Facebook</label>
            </div>
            <div class="form-group">
              <input type="checkbox">
              <label for="">YouTube</label>
            </div>
          </form>
        </div>

        <button type="button" v-on:click="fetchData">fetch data (this button is only for testing)</button>

        <div class="template" v-if="isLoading">
            <h1>loading...</h1>
            <template v-for="item in loadingTemplatesAmount">
              <div class="template_box">
                  <div class="template_image"></div>
                  <div class="template_text"></div>
                  <div class="template_text"></div>

                  <div class="template_text"></div>
                  <div class="template_text"></div>
                  <div class="template_text"></div>
              </div>
            </template>
        </div>

        <div class="tweets wf-container" id="wf-container">
            <template v-for="item in items">
                <!--TWEET-->
                <div class="wf-box twitter">
                  <!-- BODY -->
    							<div class="body">
    								<p>
                      {{ item.body }}
                    </p>
    							</div>
    							<!-- IMAGE -->
    							<img v-bind:src="item.media" alt="" class="media">

    							<!-- METADATA - likes/comments/views -->
    							<div class="metadata_1">
    								<i class="fa fa-retweet"></i> 53 | <i class="fa fa-heart"></i> 29
    								<a href="http://127.0.0.1/" target="_blank"><i class="fa fa-external-link"></i></a>
    							</div>
    							<div class="metadata_2">
    								<div class="image_avatar">
    									<img src="" alt="" class="avatar">
    								</div>
    								<div class="name">{{item.name}}</div>
    								<div class="social_media">
    									<i class="fa fa-twitter"></i>
    								</div>
    							</div>

                </div>
            </template>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
import EntitiesSidebar from './components/EntitiesSidebar.vue'
import HandlesSidebar from './components/HandlesSidebar.vue'
import EditHandle from './components/EditHandle.vue'

import { bus } from './main.js'

export default {
  name: 'app',
  components: {
    'entitiesSidebar': EntitiesSidebar,
    'handlesSidebar': HandlesSidebar,
    'editHandle': EditHandle
  },
  data () {
    return {
      items: [],
      isLoading: false,
      entities: [],
      currentEntity: {
        entity: '',
        active: false,
        handles: []
      },
      url: 'https://osoc-2017-datascouts-backend-akad1070.c9users.io/api/v1',
      mockDataTwitter: 'http://www.json-generator.com/api/json/get/ckwxgssyXm?indent=2',
      socialMediaFilters:[
        {name: 'Twitter',
        active: true},
        {name: 'Facebook',
        active: false}
      ],
      waterfallIsCreated: false,
      waterfall: '',
      isLoading: false,
      loadingTemplatesWidth: 'calc(33.33% - 30px)',
      loadingTemplatesAmount: 3
    }
  },
  created () {
    bus.$on('entitiesLoaded', (entities) => {
      this.updateEntities(entities)
    }),
    bus.$on('changeCurrentEntity', (entity) =>{
      this.changeCurrentEntity(entity)
    }),
    bus.$on('changeCurrentHandle', (handle) => {
      this.changeCurrentHandle(handle)
    })
  },
  mounted() {
    this.waterfall = new Waterfall(200)
  },
  watch: {
    items: function(updatingWfContainer){
      this.updateWaterfall()
    }
  },
  methods: {
    updateEntities(entities){
      this.entities = entities
    },
    changeCurrentEntity(entity){
      this.currentEntity = entity
    },
    changeCurrentHandle: function(handle){
      this.currentHandle = handle
    },
    fetchData: function(entities) {
      var self = this
      //display load templates & adjust them to the screen, hide loading elements
      this.isLoading = true
      document.getElementById("wf-container").style.visibility = "hidden"
      var boxes = document.getElementsByClassName("template_box")
      this.$nextTick(function(){
        for(var i=0;i<boxes.length;i++){
          boxes[i].style.width = this.loadingTemplatesWidth
        }
      })

      //creating body of the post request
      var handles = []
      var socialMedia = []

      for(var i=0;i<self.entities.length;i++){
        if(self.entities[i].active){
          for(var j=0;j<self.entities[i].handles.length;j++){
            if(self.entities[i].handles[j].active){
              handles.push(self.entities[i].handles[j].handle)
            }
          }
        }

      }
      for(var i=0;i<self.socialMediaFilters.length;i++){
        if(self.socialMediaFilters[i].active){
          socialMedia.push(self.socialMediaFilters[i].name)
        }
      }

      console.log("post body=")
      console.log({handles, socialMedia})

      Vue.http.post(this.url + '/providers/fetch', {handles, socialMedia}).then(function (response) {
          self.items = response.data
          //console.log(response)
        }, function (response) {
          console.log("Error Fail to get data from server. Loading mockdata instead.")
          Vue.http.get(self.mockDataTwitter).then(function (response) {
              self.items = response.data
              //console.log(response)
            }, function (response) {
              console.log("Error Fail to load mockdata")
          });
      });

      /*if(self.entities.length != 0 ){
        for(var i=0;i<self.entities.length;i++){
          if(self.entities[i].active){
            for(var j=0;j<self.entities[i].handles.length;j++){
              if(self.entities[i].handles[j].active){
                handlesIds.push(self.entities[i].handles[j].handle.id)
              }
            }
          }

        }
        for(item in self.socialMediaFilters){
          if(item.active){
            socialMedia.push(item.name)
          }
        }

        Vue.http.post(this.url + '/providers/fetch', {entitiesIds, socialMedia}).then(function (response) {
            self.items = response.data
            //console.log(response)
          }, function (response) {
            console.log("Error Fail to get data from server. Loading mockdata instead.")
            Vue.http.get(this.mockDataTwitter).then(function (response) {
                self.items = response.data
                //console.log(response)
              }, function (response) {
                console.log("Error Fail to load mockdata")
            });
        });
      }
      else{
        Vue.http.get(this.mockDataTwitter).then(function (response) {
            self.items = response.data
            //console.log(response)
          }, function (response) {
            console.log("Error Fail to load mockdata")
        });
      }*/
    },
    updateWaterfall: _.debounce(
      function() {
        this.waterfall.compose(true)
        document.getElementById("wf-container").style.visibility = "visible"

        //get waterfall variables to adjust loading templates.
        //TO-DO(low-prior.): copy the width calc & columnsNum code from waterfall.js so
        //that waterfall doesnt need to be rendered first to get the variables
        var columns = document.getElementsByClassName("wf-column")
        this.loadingTemplatesWidth = "calc("+columns[columns.length-1].style.width+" - 30px)"
        //console.log(this.loadingTemplatesWidth)
        this.loadingTemplatesAmount = this.waterfall.getColumnsNum()

        this.isLoading = false
      },
    1)
  }
}
</script>
