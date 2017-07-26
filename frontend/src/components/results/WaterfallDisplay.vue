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
			<h2>Visualise what your colleagues, friends, companies and competitors are talking about.</h2>
			<ul>
				<li>Add the name of your first company or person you want to follow. We call this a member.</li>
				<li>Click on the member and add all social media channels for this member.</li>
				<li>All done!</li>
			</ul>
					
		</div>

		<div class="tweets wf-container" id="wf-container">
			<template v-for="entity in items">
				<template v-for="handle in entity">
				
					<!--TWITTER-->
					<template v-if="handle.social_media === 'twitter'">
					<div class="wf-box twitter">
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

					<!--YOUTUBE-->
					<template v-if="handle.service_name === 'Youtube'">
					<div class="wf-box youtube">
						<!-- BODY -->
						<div class="body">
							<p class="title">
								{{ handle.title }}
							</p>
							<p class="description">
								{{ handle.description }}
							</p>
						</div>

						<!-- THUMBNAIL -->
						<div style="position: relative;">
							<img v-bind:src="handle.thumbnail" alt="" class="media">
							<a href="" class="play-button">
								<i class="fa fa-youtube-play"></i>
							</a>
						</div>
						
						<!-- VIDEO-IFRAME -->
						<!-- <figure class="content-media content-media--video" id="featured-media">
							<iframe class="content-media__object media" id="featured-video" v-bind:src='handle.link + "?enablejsapi=1&rel=0&showinfo=0&controls=0"' frameborder="0"></iframe>
						</figure>

						<!-- METADATA - likes/comments/views -->
						<div class="metadata_1">
							<i class="fa fa-views"></i> 50,000
							<a v-bind:href="'https://www.youtube.com/watch?v=' + handle.id" target="_blank"><i class="fa fa-external-link"></i></a>
						</div>
						<div class="metadata_2">
							<div class="image_avatar">
								<img src="" alt="" class="avatar">
							</div>
							<div class="name">{{handle.channel}}</div>
								<div class="social_media">
									<i class="fa fa-youtube-play"></i>
								</div>
							</div>
						</div>
					</template>

					<!--VIMEO-->
					<template v-if="handle.service_name === 'vimeo'">
					<div class="wf-box vimeo">
						<!-- BODY -->
						<div class="body">
							<p class="title">
								{{ handle.title }}
							</p>
							<p class="description">
								{{ handle.description }}
							</p>
						</div>

						<!-- THUMBNAIL -->
						<div style="position: relative;">
							<img v-bind:src="handle.thumbnail" alt="" class="media">
							<a href="" class="play-button">
								<i class="fa fa-youtube-play"></i>
							</a>
						</div>
						
						<!-- VIDEO-IFRAME -->
						<!-- <figure class="content-media content-media--video" id="featured-media">
							<iframe class="content-media__object media" id="featured-video" v-bind:src='handle.link + "?enablejsapi=1&rel=0&showinfo=0&controls=0"' frameborder="0"></iframe>
						</figure> -->

						<!-- METADATA - likes/comments/views -->
						<div class="metadata_1">
							<i class="fa fa-views"></i> 50,000
							<a v-bind:href="'test'"><i class="fa fa-external-link"></i></a>
						</div>
						<div class="metadata_2">
							<div class="image_avatar">
								<img src="test" alt="" class="avatar">
							</div>
							<div class="name">{{handle.channel}}</div>
								<div class="social_media">
									<i class="fa fa-vimeo"></i>
								</div>
							</div>
						</div>
					</template>

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

			this.$http.post('fetch', {handles})
				.then(res => {this.items = res.data})
				.catch(console.error)
			console.log(this.items)
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
