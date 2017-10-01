<template>
  <div id="content" @click.self.stop="displayFilterPopup = false" @scroll="handleScroll">
  	<div class="flashmessage">You succesfully created an entity called {{ entity }}</div>

  	<filters :active="displayFilterPopup"
  	    @toggle:popup="displayFilterPopup = !displayFilterPopup " 
  	    @select:keyword="k => selectedKeyword = k"
  	    @select:social_media="media => activeSocialMedia = media"
    >
  	</filters>

  	<div class="template" v-if="isLoading">
  		<h1>Loading...</h1>
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

					<twitterFeed :feed="feed" :keyword="selectedKeyword" :active="activeSocialMedia.indexOf('twitter')!==-1" 
					              v-if="feed.service_name == 'twitter'">
					</twitterFeed>

					<youtubeFeed :feed="feed" :keyword="selectedKeyword" :active="activeSocialMedia.indexOf('youtube')!==-1" 
					              :scroll="scroll"
					              v-if="feed.service_name == 'youtube'">
					</youtubeFeed>

					<vimeoFeed :feed="feed" :keyword="selectedKeyword" :active="activeSocialMedia.indexOf('vimeo')!==-1" 
					              v-if="feed.service_name == 'vimeo'">
					</vimeoFeed>

				</template>
			</template>
		</div>

  </div>
</template>

<script>
  import _debounce  from 'lodash.debounce'

	import { bus } from '../../main'
	import Filters  from './Filters.vue'
	import TwitterFeed  from './TwitterFeed.vue'
	import VimeoFeed  from './VimeoFeed.vue'
	import YoutubeFeed  from './YoutubeFeed.vue'
  import {
  	getActiveEntities,
  	getActiveHandles,

  } from '../../utils/storageService'


	export default {
		props: [],
		components : {
		  Filters,
			TwitterFeed,
			VimeoFeed,
			YoutubeFeed,
		},
  	data () {
    	return {
    	  displayFilterPopup : false,
    		entitiesIsEmpty: false,
    		items: [],
    		isLoading: false,
    		activeSocialMedia: [],
    		selectedKeyword: '',
    		scroll : 0,
    	}
  	},
  	created () {
		},
		mounted() {
			this.waterfall = new Waterfall(200)
			bus.$on('ENTITIES_IS_EMPTY', (bool) => this.entitiesIsEmpty = bool)
      bus.$on('UPDATE_WATERFALL', this.updateWaterfall)
			bus.$on('FETCH_DATA', this.fetchData)
			
			window.addEventListener("scroll", _ => this.scroll = window.scrollY);
		},
		watch: {
			items: function(updatingWfContainer){
				this.updateWaterfall()
			}
		},
		methods: {
		  handleScroll : function ($event) {
		    bus.$emit('SCROLLING', window.scrollY)
		  },
		  out : function () {
		    this.displayFilterPopup = false
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