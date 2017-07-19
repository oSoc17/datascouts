<template>
  <div class="full-screen">
    <div class="header">
      <a href="https://www.datascouts.eu"  class="logo">
        <img src="../content/assets/img/datascouts-logo.svg" alt="datascouts-logo">
      </a>
    </div>
      <!-- SIDEBAR-ENTITIES -->
      <entitiesSidebar v-bind:url="url"></entitiesSidebar>
    <div id="main">
      <div class="content">
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
                <div class="tweet wf-box">
                    <a class="tweet_url" v-bind:href="item.link">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/8/81/Octicons-link-external.svg" alt="" title="visit tweet"> <!--temporary-->
                    </a>
                    <div class="user">
                        <img class="profile_picture" v-bind:src="item.user_avatar" alt="">
                        <div class="name">
                            <div class="full_name"> {{ item.user_full_name}} </div>
                            <a v-bind:href="'https://www.twitter.com/' + item.user" class="" target="_blank">@{{ item.user }}</a>
                        </div>
                    </div>
                    <p class="body">{{ item.body }}</p>

                    <div v-if="item.media != null">
                        <img v-bind:src="item.media" class="media" alt="">
                    </div>

                    <small class="created_at"> {{ item.created_at }} </small>
                    <hr>
                        <div class="info">
                            <div class="retweets">
                                <strong> {{ item.retweet_count }} </strong>
                                retweets&nbsp;|&nbsp;
                            </div>
                            <div class="favorites">
                                <strong> {{ item.favorite_count }} </strong>
                                favorites </div>
                        </div>
                    <hr>
                    <div class="actions">
                        <!--REPLY-->
                        <a class="action action-reply">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 65 72">
                                <path fill="#AAB8C2" d="M41 31h-9V19c0-1.14-.647-2.183-1.668-2.688-1.022-.507-2.243-.39-3.15.302l-21 16C5.438 33.18 5 34.064 5 35s.437 1.82 1.182 2.387l21 16c.533.405 1.174.613 1.82.613.453 0 .908-.103 1.33-.312C31.354 53.183 32 52.14 32 51V39h9c5.514 0 10 4.486 10 10 0 2.21 1.79 4 4 4s4-1.79 4-4c0-9.925-8.075-18-18-18z"/>
                            </svg>
                        </a>

                        <a class="action action-retweet">
                        <!--RETWEET-->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 75 72">
                                <path fill="#AAB8C2" d="M70.676 36.644C70.166 35.636 69.13 35 68 35h-7V19c0-2.21-1.79-4-4-4H34c-2.21 0-4 1.79-4 4s1.79 4 4 4h18c.552 0 .998.446 1 .998V35h-7c-1.13 0-2.165.636-2.676 1.644-.51 1.01-.412 2.22.257 3.13l11 15C55.148 55.545 56.046 56 57 56s1.855-.455 2.42-1.226l11-15c.668-.912.767-2.122.256-3.13zM40 48H22c-.54 0-.97-.427-.992-.96L21 36h7c1.13 0 2.166-.636 2.677-1.644.51-1.01.412-2.22-.257-3.13l-11-15C18.854 15.455 17.956 15 17 15s-1.854.455-2.42 1.226l-11 15c-.667.912-.767 2.122-.255 3.13C3.835 35.365 4.87 36 6 36h7l.012 16.003c.002 2.208 1.792 3.997 4 3.997h22.99c2.208 0 4-1.79 4-4s-1.792-4-4-4z"/>
                            </svg>
                        </a>

                        <a class="action action-favorite">
                        <!--FAVORITE-->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 54 72">
                                <path fill="#AAB8C2" d="M38.723,12c-7.187,0-11.16,7.306-11.723,8.131C26.437,19.306,22.504,12,15.277,12C8.791,12,3.533,18.163,3.533,24.647 C3.533,39.964,21.891,55.907,27,56c5.109-0.093,23.467-16.036,23.467-31.353C50.467,18.163,45.209,12,38.723,12z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </template>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import EntitiesSidebar from './EntitiesSidebar.vue'
import { bus } from './main.js'

export default {
  name: 'app',
  components: {
    'entitiesSidebar': EntitiesSidebar
  },
  data () {
    return {
      items: [],
      isLoading: false,
      entities: [],
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
    bus.$on('entitiesLoaded', (entity) => {
      this.entities = entities
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
    var handlesIds = []
    var socialMedia
    if(self.entities.length != 0 ){
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
          this.$http.get(this.mockDataTwitter).then(function (response) {
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
    }
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
