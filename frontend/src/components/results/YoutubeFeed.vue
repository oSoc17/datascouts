<template>
  <div class="wf-box youtube"  v-show="hasKeyword && active">
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
    <div style="position: relative;margin-bottom:16px;" v-show="!isLoaded"  >
      <img v-bind:src="feed.thumbnail" alt="Thumbnail" class="media">
      
      <a target="_blank" class="play-button" v-if="feed.type == 'channel'" :href="feed.channel_link">
        <i class="fa fa-external-link"></i>
      </a>
      
      <span class="play-button" 
            v-if="feed.type == 'video' && !isLoaded" @click="isLoaded = true"
      >
        <i class="fa fa-youtube-play"></i>
      </span>
    </div>

    <!-- VIDEO-IFRAME -->
    <figure class="content-media content-media--video featured-media" 
            v-if="feed.type == 'video' && isLoaded"
    >
      <iframe class="content-media_object media featured-video" 
              frameborder="0"
              v-bind:src="feed.link + '?enablejsapi=1&autoplay=1&controls=0&rel=1&showinfo=0'"
      > </iframe>
    </figure>

    <!-- METADATA - likes/comments/views -->
    <div class="metadata_2">
      <div class="name">
        <a target="_blank"  v-bind:href="feed.channel_link" :alt="feed.channel +' Channel'" :title="feed.channel +' Channel'">
          {{feed.channel}}
        </a>
      </div>
      <div class="social_media">
        <a target="_blank" v-bind:href="'https://www.youtube.com/watch?v='+feed.id" alt="Go to Youtube" title="Go to Youtube">
          <i class="fa fa-youtube-play"></i>
        </a>
      </div>
      </div>
  </div>
</template>

<script>
  import { bus } from '../../main'

	export default {
		props: ['feed', 'keyword', 'active'],
		components: {
		},
		data() {
			return {
        isLoaded : false,
			}
		},
		created() { },
		mounted() { },
		computed : {
   	  hasKeyword: function(item){
    		if(this.keyword){
      		let isIncluded = this.feed.description != null  // ? Contains the selected keyword
      		isIncluded = isIncluded && this.feed.description.includes(this.keyword)
      		if(isIncluded) setTimeout(() => bus.$emit('UPDATE_WATERFALL'), 10)
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

.featured-media iframe {
  top: 0;
  left: 0;
  height:100%;
  width: 100%;
}


.play-button {
  cursor : pointer;
}

.metadata_2 .name a {
  color: #515151;
  text-decoration: none;
}

.social_media a .fa {
  color : #FFF;
}
</style>
