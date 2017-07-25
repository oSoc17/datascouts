<template>
  <div id="content">
    <div class="flashmessage">You succesfully created an entity called {{ entity }}</div>

    <div class="filters" v-on:click="showFilters()">
		<button class="btn_filter">
			<!-- This source should be replaced with filtered.svg
					IF any checkboxes are check
					OR any keyword is added -->
			<!--<img src="assets/font-awesome-svg/filtered.svg" alt="">-->
			<img src="assets/font-awesome-svg/unfiltered.svg" alt="">
			Filter
		</button>
		<form action="" id="filter">
			<div class="arrow"></div>
			<div class="filter-socialmedia">
				<h2>Social media</h2>
				<div class="form-group">
					<input class="styled-checkbox" id="styled-checkbox-sm-1" type="checkbox" value="twitter" checked>
					<label for="styled-checkbox-sm-1">Twitter</label>
				</div>
				<div class="form-group">
					<input class="styled-checkbox" id="styled-checkbox-sm-2" type="checkbox" value="youtube">
					<label for="styled-checkbox-sm-2">YouTube</label>
				</div>
				<div class="form-group">
					<input class="styled-checkbox" id="styled-checkbox-sm-3" type="checkbox" value="vimeo">
					<label for="styled-checkbox-sm-3">Vimeo</label>
				</div>
			</div>
			<div class="filter-keywords">
				<h2>Keywords</h2>
				<div class="form-group">
					<input type="text" placeholder="Keyword">
				</div>
				<div class="form-group">
					<!-- You can add any html tag for vue, not styled yet, I'll do it afterwards -->
					<div class="keyword">Keyword1</div>
					<div class="keyword">Keyword2</div>
					<div class="keyword">Keyword3</div>
				</div>
			</div>
		</form>
	</div>

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
  import _debounce  from 'lodash.debounce'

  import { bus } from '../../main'
  import {
    getActiveEntities,
    getActiveHandles,

  } from '../../utils/storageService'


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
      console.log('Created WaterDisplay')
    },
    mounted() {
      this.waterfall = new Waterfall(200)
      bus.$on('ENTITIES_IS_EMPTY', (bool) => this.entitiesIsEmpty = bool)
      bus.$on('FETCH_DATA', this.fetchData)
    },
    watch: {
      items: function(updatingWfContainer){
        this.updateWaterfall()
      }
    },
    methods: {
      showFilters: function(e){
        var el = document.getElementById("filter")
        el.style.display = el.style.display === 'none' ? '' : 'none';
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
      fetchData: function(){
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
        
        const handles = this.getAllActiveHandles()
        
        this.$http.post('providers/fetch', {handles})
            .then(res => {this.items = res.data})
            .catch(console.error)

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
