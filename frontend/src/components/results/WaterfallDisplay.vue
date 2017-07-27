	<template>
	<div id="content" v-on:click="hideFilters($event)">
		<div class="flashmessage">You succesfully created an entity called {{ entity }}</div>

		<div class="filters" id="filters">
			<button class="btn_primary btn_filter" v-on:click="showFilters()">
				<!-- This source should be replaced with filtered.svg
						IF any checkboxes are check
						OR any keyword is added -->
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
			<template v-for="item in items">
				<template v-for="feed in item"> <!-- Make a v-for on socialMedia instead of  item -->

					<!--TWITTER-->
					<twitterFeed :feed="feed" v-show="feed.service_name == 'twitter' && activeSocialMedia.indexOf('twitter')!==-1"></twitterFeed>

					<!--YOUTUBE-->
					<youtubeFeed :feed="feed" v-show="feed.service_name == 'youtube' && activeSocialMedia.indexOf('youtube')!==-1"></youtubeFeed>

					<!--VIMEO-->
					<vimeoFeed :feed="feed" v-show="feed.service_name == 'vimeo' && activeSocialMedia.indexOf('vimeo')!==-1"></vimeoFeed>

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
			isLoading: false,
			socialMedia: [],
			activeSocialMedia: [],
		}
		},
		created () {
			console.log('Created WaterfallDisplay')
			var i=1
			while(typeof(this.services[i])!=='undefined'){
				this.socialMedia.push(this.services[i].name)
				i++
			}
			this.activeSocialMedia = this.socialMedia
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
			isSocialMediaActive: function(socialmedia){

			},
			hideFilters: function(e){
				var el = document.getElementById("filter")
				var filters = document.getElementById("filters")
				if(el.style.display !== 'none' && !this.isDescendant(filters, e.target)){
  				el.style.display = 'none';
  				el.classList.toggle("display-filter")
				}
			},
			isDescendant: function (parent, child) {
  			var node = child.parentNode;
  			while (node != null) {
  				if (node == parent) {
  					return true;
  				}
  				node = node.parentNode;
  			}
  			return false;
			},
			showFilters: function(e){
				var el = document.getElementById("filter")
				var el2 = document.querySelector("button.btn_primary.btn_filter");
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
				console.log('Active Handles to fetch : ',handles);
				return handles;
			},
			fetchData: _debounce(function(){
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

				this.$http.post('fetch', {handles})
					.then(res => this.items = res.data)
					.catch(console.error)
				// console.log(this.items)
			},300),
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
