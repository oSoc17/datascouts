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
    <figure ref="ytb_media"  class="content-media">
      <youtube  v-if="feed.type == 'video' && isLoaded" 
                ref="ytb_vid" :class="classList"
                :videoId="feed.id"
                :player-vars="{ autoplay: 1, controls: 0,  showinfo: 0, rel: 0 }" 
                @ready="initStickyFloat" 
                @playing="playing" 
                @paused="paused"
                @error="error"
      ></youtube>

    </figure>

    <!-- METADATA - likes/comments/views -->
    <div class="metadata_2">
      <div class="name">
        <a target="_blank"  :href="feed.channel_link" :alt="feed.channel +' Channel'" :title="feed.channel +' Channel'">
          {{feed.channel}}
        </a>
      </div>
      <div class="social_media">
        <a target="_blank" :href="'https://www.youtube.com/watch?v='+feed.id" alt="Go to Youtube" title="Go to Youtube">
          <i class="fa fa-youtube-play"></i>
        </a>
      </div>
      </div>
  </div>
</template>

<script>
  import _throttle from 'lodash.throttle'
  
  import Vue from 'vue'

  import { bus } from '../../main'
  

	export default {
		props: ['feed', 'keyword', 'active', 'scroll'],
		components: { },
		data() {
			return {
			  classList : {'is-playing':false, 'is-paused':false, 'is-sticky' : false},
        isLoaded : false,
        player : {},
			}
		},
		created() { },
		mounted() { 
		  bus.$on('RESIZE', function (){
		    if(this.player.isPlaying)
		      this.calcOffset()
		  })
		  // bus.$on('SCROLLING', this.float)
		},
		watch : { 
		  scroll : function (scroll){
	      this.player.scroll = scroll
		    if(this.classList['is-playing']){
          const state = this.classList['is-playing'] && (scroll-50) > this.player.offset
          console.log(this.feed.id, ' => SCROLLED\n',
                scroll, this.player.offset ,'isSticky : ', state);
                
          this.classList['is-sticky'] = state
		    }
      },
		},
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
    	},
    	generateIframeSrc : function(){
    	  let link = this.feed.link 
    	  link += '?enablejsapi=1&autoplay=1&controls=0&rel=1&showinfo=0'
    	  return link
    	},
    	
		},
		methods: {
		  calcOffset : function (){
		    console.log('CALC OFFSET');
		    this.player.top = this.$refs.ytb_media.offsetTop
        this.player.offset = Math.floor(
          this.player.top + (this.$refs.ytb_media.offsetHeight / 2)
        )
		  },
		  initStickyFloat : function (player) {
		    console.log(this.feed.id + ' => READY');
		    this.player = player
        this.calcOffset()
      },
      
      playing : function (player) {
		    console.log(this.feed.id + ' => PLAYING');
		    this.player = player
        this.classList['is-playing'] = true
        this.classList['is-paused'] = false
      },
      paused : function (player) {
		    console.log(this.feed.id + ' => PAUSED');
        this.classList['is-paused'] = true
        this.classList['is-playing'] = true
      },
      stop : function() {
		    console.log(this.feed.id + ' => STOPPED');
        this.player.stopVideo()
        this.player['is-playing'] = false
      },

      error : function(err) {
		    console.log(this.feed.id + ' => ERROR', err);
        
      },
    },

	}

</script>

<style>
  
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
  
  
  .content-media iframe {
    top: 0;
    left: 0;
    height:100%;
    width: 100%;
  }
  
  .content-media {
      transition: width .2s ease-in-out, height .2s ease-in-out, transform .38s ease-in-out;
  }
  
  /** Use .sticky */
  
  .is-sticky {
      position: fixed;
      top: 45px;
      right: 0;
      max-width: 350px;
      max-height: 250px;
  }
        
  
  @media screen and (min-width: 1120px) {
      .is-sticky {
          transform: translateX(-80%);
      }
  }
  
  @media screen and (min-width: 1300px) {
      .is-sticky {
          transform: translateX(-115%);
      }
  }
</style>
