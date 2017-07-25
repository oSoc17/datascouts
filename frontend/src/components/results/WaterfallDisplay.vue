<template>
  <div id="content">
    <!--<div class="flashmessage">You succesfully created an entity called {{ entity }}</div>-->

    <!--<button type="button" v-on:click="fetchData">fetch data (this button is only for testing)</button>-->

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

    <div class="empty-state empty-state-feed" v-show="entitiesIsEmpty">
				<h2>What is a member?</h2>
				<p>
					Curabitur aliquet quam id dui posuere blandit.
					Lorem ipsum dolor sit amet, consectetur adipiscing elit.
					Curabitur aliquet quam id dui posuere blandit. Proin eget tortor risus.
				</p>
				<h2>How to add one?</h2>
				<ul>
					<li>Step 1</li>
					<li>Step 2</li>
					<li>Step 3</li>
				</ul>
			</div>

    <div class="tweets wf-container" id="wf-container">
      <template v-for="entity in items">
        <template v-for="handle in entity">
            <!--TWEET-->
            <div class="wf-box twitter" v-if="handle.social_media === 'twitter'">
              <!-- BODY -->
              <div class="body">
                <p>
                  {{ handle.body }}
                </p>
              </div>
              <!-- IMAGE -->
              <img v-bind:src="handle.media" alt="" class="media">

              <!-- METADATA - likes/comments/views -->
              <div class="metadata_1">
                <i class="fa fa-retweet"></i> {{handle.retweet_count}} | <i class="fa fa-heart"></i> {{handle.favorite_count}}
                <a v-bind:href="handle.link" target="_blank"><i class="fa fa-external-link"></i></a>
              </div>
              <div class="metadata_2">
                <div class="image_avatar">
                  <img v-bind:src="handle.user.profile_image_url_https" alt="" class="avatar">
                </div>
                <div class="name">{{handle.user_full_name}}</div>
                <div class="social_media">
                  <i class="fa fa-twitter"></i>
                </div>
              </div>

            </div>
        </template>
      </template>
    </div>

  </div>
</template>

<script>
  import { bus } from '../../main'

  import _debounce  from 'lodash.debounce'

  export default {
    components : {

    },
    data () {
      return {
        entitiesIsEmpty: false,
        items: [],
        isLoading: false
      }
    },
    created () {
      bus.$on('ENTITIES_IS_EMPTY', (bool) => this.entitiesIsEmpty = bool)
      bus.$on('FETCH_DATA', (entities) => this.fetchData)
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
      fetchData: function(entities/*, socialMedia*/){
        console.log('fetching data')

        //display load templates & adjust them to the screen, hide loading elements
        this.isLoading = true
        document.getElementById("wf-container").style.visibility = "hidden"
        var boxes = document.getElementsByClassName("template_box")
        this.$nextTick(function(){
          for(var i=0;i<boxes.length;i++){
            boxes[i].style.width = this.loadingTemplatesWidth
          }
        })

        var handles = []
        var socialMedia = []

        for(var i=0;i<entities.length;i++){
          if(entities[i].active){
            for(var j=0;j<entities[i].handles.length;j++){
              if(entities[i].handles[j].active){
                handles.push(entities[i].handles[j].handle.id)
              }
            }
          }

        }
        /*for(var i=0;i<socialMedia.length;i++){
          if(socialMedia[i].active){
            socialMedia.push(socialMedia[i].object.id)
          }
        }*/

        Vue.http.post(this.url + '/fetch', {"handles" : handles/*,"socialMedia" : socialMedia*/}).then(res => {
          items = res.data}).catch(console.log)

      },
      updateWaterfall: _debounce(
        function() {
          console.log(this.items)
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

<style>

</style>
