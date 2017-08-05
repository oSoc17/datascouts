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
    <figure class="content-media"  ref="media">
      <youtube  v-if="feed.type == 'video' && isLoaded" 
                ref="ytb_vid" 
                :videoId="feed.id"
                :player-vars="{ autoplay: 1, controls: 0,  showinfo: 0, rel: 0 }" 
                @ready="ready" 
                @playing="playing" 
                @error="error"
      ></youtube>

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
  import _throttle from 'lodash.throttle'
  
  import Vue from 'vue'
  import VueYouTubeEmbed from 'vue-youtube-embed'

  import { bus, app } from '../../main'
  
  
  // app.use(VueYouTubeEmbed, { global: false })


	export default {
		props: ['feed', 'keyword', 'active'],
		components: {VueYouTubeEmbed },
		data() {
			return {
        isLoaded : false,
        ids : {
          media : 'media-'+this.feed.id,
          video : 'video-'+this.feed.id,
        },
        player : {}
			}
		},
		created() { },
		mounted() { },
		watch : { },
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
		
		  onPlayerStateChange : function(e) {
        console.log('Yep', e.data);
        switch (e.data) {
            case YT.PlayerState.PLAYING:
                this.player.$featuredVideo.removeClass("is-paused");
                this.player.$featuredVideo.toggleClass("is-playing");
                break;

            case YT.PlayerState.PAUSED:
                // this.player.$featuredVideo.removeClass("is-playing");
                // this.player.$featuredVideo.toggleClass("is-paused");
                break;

            case YT.PlayerState.ENDED:
                this.player.$featuredVideo.removeClass("is-playing", "is-paused");
                break;

            default:
                break;
        }
    },
		  
		  initStickyFloat : function (e){
		    console.log('? isLoaded ?');
		    
		    if(!this.isLoaded) return

        const $featuredMedia = this.$el.querySelector('#'+this.ids.media); // Container.
        const $featuredVideo = $featuredMedia.querySelector('#'+this.ids.video); // Actual Video.
        
        console.log($featuredMedia, '#'+this.ids.video ,$featuredVideo, this.$refs.video);
        
        // this.player = {
        //   top : $featuredMedia.offset().top,
        //   offset : Math.floor(top + ($featuredMedia.outerHeight() / 2)),
        //   $featuredMedia, $featuredVideo
        // };
        
        // window.onYouTubeIframeAPIReady = function() {
        //   player = new YT.Player("featured-video-2", {
        //       events: {
        //           "onStateChange": this.onPlayerStateChange
        //       }
        //   });
        // };
  
        // $window
        //   .on("resize", _throttle(function() {
        //       top = this.player.$featuredMedia.offset().top;
        //       offset = Math.floor(top + (this.player.$featuredMedia.outerHeight() / 2));
        //   }, 150))
        //   .on("scroll", _throttle(function() {
        //       this.player.$featuredVideo.toggleClass("is-sticky",
        //           $window.scrollTop() > offset && this.player.$featuredVideo.hasClass("is-playing")
        //       );
        //   }, 350)); 
		  },
		  
		  ready (player) {
		    console.log(this.feed.id + ' => READY');
        this.player = player
        
      },
      playing (player) {
		    console.log(this.feed.id + ' => PLAYING');
        // The player is playing a video.
      },

      stop () {
		    console.log(this.feed.id + ' => STOPPED');
        this.player.stopVideo()
      },
      pause () {
		    console.log(this.feed.id + ' => PAUSED');
        this.player.pauseVideo()
      },
      
      error (err) {
		    console.log(this.feed.id + ' => ERROR', err);
        
      },
		}

	}

</script>

<style>
  .content-media iframe {
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
  
  .content-media-video {
      transition: width .2s ease-in-out, height .2s ease-in-out, transform .38s ease-in-out;
  }
  /** Use .sticky */
  
  
  .is-sticky {
      position: fixed;
      top: 15px;
      right: 0;
      min-width: 480px;
      min-height: 270pc;
  }
  
  @media screen and (min-width: 1120px) {
      .content-media-video .is-sticky {
          transform: translateX(-30%);
      }
  }
  
  @media screen and (min-width: 1300px) {
      .content-media-video .is-sticky {
          transform: translateX(-75%);
      }
  }
</style>
