<template>
  <div id="content" v-on:click="hideFilters($event)">
  	<div class="flashmessage">You succesfully created an entity called {{ entity }}</div>

  	<div class="filters" id="filters">
  		<button class="btn_primary btn_filter" v-on:click="showFilters()">
				<!-- <i class="fa fa-filter fa-active"></i> -->
  			<i class="fa fa-filter"></i>
  			Filter
  		</button>
  		<form action="" id="filter" style="display: none;" class="">
  			<div class="arrow"></div>
  			<div class="filter-socialmedia">
					<h2>Social media</h2>
					<template v-for="(item, index) in socialMedia">
						<div class="form-group">
							<input class="styled-checkbox" :id="'styled-checkbox-sm-1'+index" type="checkbox" :value="item" v-model="activeSocialMedia">
							<label :for="'styled-checkbox-sm-1'+index">{{item}}</label>
						</div>
					</template>
  			</div>
  			<div class="filter-keywords">
  				<h2>Keyword</h2>
          <form>
            <div class="form-group">
              <input type="text" placeholder="Keyword" v-model.trim="newKeyword">
              <button type="submit" class="btn_primary action" id="entity_add" v-on:click.prevent="addKeyword()">
                 <i class="plus">+</i>
              </button>
            </div>
          </form>
    			<div class="radio-filter">
    				<input type="radio" id="noFilter" value="" v-model="selectedKeyword">
    				<label for="noFilter">no filter</label>
    			</div>

    			<template v-for="keyword in keywords">
    				<div class="radio-filter">
    					<input type="radio" :id="keyword"  :value="keyword" v-model="selectedKeyword">
    					<label :for="keyword">{{keyword}}</label>
    					<button v-on:click.prevent="deleteKeyword(keyword)"><i class="fa fa-times" aria-hidden="true"></i></button>
    				</div>
    			</template>
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
			<h2>Visualise what your colleagues, friends, companies and competitors are talking about.</h2>
			<ol>
				<li>Add the name of your first company or person you want to follow. We call this a member.</li>
				<li>Click on the member and add all social media channels for this member.</li>
				<li>All done!</li>
			</ol>
		</div>

		<div class="tweets wf-container" id="wf-container">
			<template v-for="item in items">
				<template v-for="feed in item"> <!-- Make a v-for on socialMedia instead of  item -->

					<!--TWITTER-->
					<twitterFeed :feed="feed" :keyword="selectedKeyword" :activeSocialMedia="activeSocialMedia" v-if="feed.service_name == 'twitter'"></twitterFeed>

					<!--YOUTUBE-->
					<youtubeFeed :feed="feed" :keyword="selectedKeyword" :activeSocialMedia="activeSocialMedia" v-if="feed.service_name == 'youtube'"></youtubeFeed>

					<!--VIMEO-->
					<vimeoFeed :feed="feed" :keyword="selectedKeyword" :activeSocialMedia="activeSocialMedia" v-if="feed.service_name == 'vimeo'"></vimeoFeed>

				</template>
			</template>
		</div>

  </div>
</template>

<script>
  import _debounce  from 'lodash.debounce'

	import { bus } from '../../main'
	import TwitterFeed  from './TwitterFeed.vue'
	import VimeoFeed  from './VimeoFeed.vue'
	import YoutubeFeed  from './YoutubeFeed.vue'
  import {
  	getActiveEntities,
  	getActiveHandles,

  } from '../../utils/storageService'


	export default {
		props: ['services'],
		components : {
			TwitterFeed,
			VimeoFeed,
			YoutubeFeed,
		},
  	data () {
    	return {
    		entitiesIsEmpty: false,
    		items: [],
    		filteredItems: [],
    		selectedKeyword: '',
    		newKeyword: '',
    		keywords: [],
    		isLoading: false,
    		socialMedia: [],
    		activeSocialMedia: [],
    	}
  	},
  	created () {
			let i = 1
			while(typeof(this.services[i])!=='undefined'){
				this.socialMedia.push(this.services[i++].name)
			}
			this.activeSocialMedia = this.socialMedia
		},
		mounted() {
			this.waterfall = new Waterfall(200)
			bus.$on('ENTITIES_IS_EMPTY', (bool) => this.entitiesIsEmpty = bool)
      bus.$on('UPDATE_WATERFALL', this.updateWaterfall)
			bus.$on('FETCH_DATA', this.fetchData)
		},
		watch: {
			items: function(updatingWfContainer){
				this.updateWaterfall()
			}
		},
		methods: {
    	addKeyword: function(){
    		if(this.newKeyword && this.keywords.indexOf(this.newKeyword) == -1){
    		  this.keywords.push(this.newKeyword)
    		}
    		this.selectedKeyword = this.newKeyword
    		this.newKeyword = ""
    	},
    	deleteKeyword: function(keyword){
    		const i = this.keywords.findIndex(k => k === keyword)
    		this.selectedKeyword = ''
    		this.keywords.splice(i,1)
    	},
    	hideFilters: function(e){
				const el = document.getElementById("filter")
				const filters = document.getElementById("filters")
				if(el.style.display !== 'none' && !this.isDescendant(filters, e.target)){
  				el.style.display = 'none';
  				el.classList.toggle("display-filter")
				}
			},
			isDescendant: function (parent, child) {
  			let node = child.parentNode;
  			while (node != null) {
  				if (node == parent) {
  					return true;
  				}
  				node = node.parentNode;
  			}
  			return false;
			},
			showFilters: function(e){
				const el = document.getElementById("filter")
				const el2 = document.querySelector("button.btn_primary.btn_filter");
				el.style.display = el.style.display === 'none' ? 'initial' : 'none';
				el.classList.toggle("display-filter");
				el2.classList.toggle("fa-active");
			},
			getAllActiveHandles : function (){
				const handles = [];
				getActiveEntities().forEach(ent_id => {
  				const activeHandles = getActiveHandles(ent_id);
  				handles.push(... activeHandles);
				})
				return handles;
			},

			fetchData: _debounce(function(){
				//display load templates & adjust them to the screen, hide loading elements
    		this.isLoading = true
    		document.getElementById("wf-container").style.visibility = "hidden"
    		const boxes = document.getElementsByClassName("template_box")
    		this.$nextTick(function(){
      		for(var i=0;i<boxes.length;i++){
      			boxes[i].style.width = this.loadingTemplatesWidth
      		}
    		})

    		const handles = this.getAllActiveHandles()

				this.$http.post('fetch', {handles})
					.then(res => this.items = res.data)
					.catch(console.error)
			},300),

    	updateWaterfall: _debounce(
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
    	10)
  	}
  }
</script>

<style>

</style>
