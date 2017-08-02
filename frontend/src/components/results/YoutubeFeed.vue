<template v-if="feed.service_name == 'youtube'">
  <div class="wf-box youtube" v-show="hasKeyword">
    <!-- BODY -->
    <div class="body">
      <h3 class="title">
        {{ feed.title }}
      </h3>
      <p class="description">
        {{ feed.description }}
      </p>
    </div>
  
    <!-- THUMBNAIL -->
    <div style="position: relative;margin-bottom:16px;">
      <img v-bind:src="feed.thumbnail" alt="" class="media">
      <a v-bind:href="'https://www.youtube.com/watch?v='+feed.id" target="_blank" class="play-button">
        <i class="fa fa-youtube-play"></i>
      </a>
    </div>
  
    <!-- VIDEO-IFRAME -->
    <!-- <figure class="content-media content-media--video" id="featured-media" v-if="isLoaded">
      <iframe class="content-media__object media" id="featured-video" v-bind:src='feed.link + "?enablejsapi=1&rel=0&showinfo=0&controls=0"' frameborder="0"></iframe>
    </figure> -->
  
    <!-- METADATA - likes/comments/views -->
    <div class="metadata_1">
      <a v-bind:href="'https://www.youtube.com/watch?v='+feed.id" target="_blank"><i class="fa fa-external-link"></i></a>
    </div>
    <div class="metadata_2">
      <div class="name">{{feed.channel}}</div>
        <div class="social_media">
          <i class="fa fa-youtube-play"></i>
        </div>
      </div>
  </div>
</template>

<script>
  import { bus } from '../../main'

	export default {
		props: ['feed', 'keyword'],
		components: {
		},
		data() {
			return {
        isLoaded : false,
			}
		},
		created() {
		},
		mounted() {
		},
		destroyed() {
      console.log(this) // There's practically nothing here!

    },
		computed : {
   	  hasKeyword: function(item){
    		if(this.keyword){
    		  // ? Contains the selected keyword
      		let  isIncluded = this.feed.description != null
      		isIncluded = isIncluded && this.feed.description.includes(this.keyword)
      		if(isIncluded) setTimeout(() => bus.$emit('UPDATE_WATERFALL'), 100)
      		return isIncluded
    		}
    		// No keyword selected
  		  return true
    		
    	}
		},
		methods: {
		}
		
	}
		
</script>

<style>

</style>
