<template>
  <div class="wf-box vimeo"  v-show="hasKeyword && active">
    <!-- BODY -->
    <div class="body">
      <h3 class="title">
        {{ feed.title }}
      </h3>
      <div
      <p class="description">
        {{ feed.description | truncate(maxLength) }}
      </p>
      <div class="date">{{newFormatDate}}</div>
    </div>


    <!-- THUMBNAIL -->
    <div style="position: relative;" v-show="!isLoaded"  >
      <img v-bind:src="feed.thumbnail" alt="Thumbnail" class="media">
      <span href="" class="play-button"  
        v-if="!isLoaded" @click="isLoaded = true"
      >
        <i class="fa fa-play"></i>
      </span>
    </div>

    <!-- VIDEO-IFRAME -->
    <figure class="content-media content-media--video featured-media" v-if="isLoaded">
      <iframe class="content-media_object media featured-video"
              frameborder="0" :title="feed.title"
              v-bind:src="generateIframeSrc"
      ></iframe>
    </figure>

    <!-- METADATA - likes/comments/views -->
    <div class="metadata_1">
      <i class="fa fa-eye" title="Views count" v-if="feed.played_count"></i> {{feed.played_count}}
      <i class="fa fa-low-vision" title="No played" v-if="!feed.played_count"></i> | 
      <i class="fa fa-heart"  title="Likes count"></i> {{feed.likes_count}}
      <a v-bind:href="feed.link" alt="Watch on Vimeo" title="Watch on Vimeo" target='_blank'>
        <i class="fa fa-external-link"></i>
      </a>
    </div>
    <div class="metadata_2">
      <div class="image_avatar">
        <img v-bind:src="feed.user.avatar" alt="Vimeo User Avatar" class="avatar">
      </div>
      <div class="name">{{feed.user.name}}</div>
      <div class="social_media">
        <i class="fa fa-vimeo"></i>
      </div>
    </div>
  </div>
</template>


<script>
  import Config  from '../../config/'
  import { bus } from '../../main'
  

	export default {
		props: ['feed', 'keyword', 'active'],
		components: { },
		data() {
			return {
			  maxLength : Config.TRUNCATE_MAX_LENGTH,
			  isLoaded : false,
			}
		},
		created() { },
		mounted() {	},
		computed : {
      newFormatDate: function() {
        const date = new Date(this.feed.created_at);
        // const month = date.getMonth();
        const locale = "en-us";
        const newMonth = date.toLocaleString(locale, { month: "short" });

        return  newMonth + ' ' + date.getDate();
      },
   	  hasKeyword: function(item){
    		if(this.keyword){
    		  // ? Contains the selected keyword
      		let  isIncluded = this.feed.description != null
      		isIncluded = isIncluded && this.feed.description.includes(this.keyword)

      		if(isIncluded) setTimeout(() => bus.$emit('UPDATE_WATERFALL'), 10)

      		return isIncluded
    		}
    		// No keyword selected
  		  return true
    	},
    	generateIframeSrc : function (){
    	  let src = 'https://player.vimeo.com/video/'
    	  src += this.feed.id.split('/').pop()
    	  src +='?title=0&byline=0&portrait=0&badge=0&autoplay=1&autopause=1&api=1'
    	  return src
    	}
		},
		methods: {
      
		}

	}
</script>

<style>




.play-button {
  cursor : pointer;
}

</style>
