<template>
  <div class="wf-box vimeo"  v-show="hasKeyword && active">
    <!-- BODY -->
    <div class="body">
      <h3 class="title">
        {{ feed.title }}
      </h3>
      <div
      <p class="description" v-if="feed.description !== null && needsTruncation(feed.description)">
        {{ feed.description.substring(0, max_length) }}...
      </p>
      <p class="description" v-else>
        {{ feed.description}}
      </p>
      <div class="date">{{newFormatDate()}}</div>
    </div>


    <!-- THUMBNAIL -->
    <div style="position: relative;">
      <img v-bind:src="feed.thumbnail" alt="" class="media">
      <a href="" class="play-button">
        <i class="fa fa-play"></i>
      </a>
    </div>

    <!-- VIDEO-IFRAME -->
    <!--  <figure class="content-media content-media--video" id="featured-media">
    <iframe class="content-media__object media" id="featured-video"
            v-bind:src=="'https://player.vimeo.com/'+feed.id?title=0&byline=0&badge=0&autopause=0&player_id=0">
      </iframe>
    </figure> -->

    <!-- METADATA - likes/comments/views -->
    <div class="metadata_1">
      <i class="fa fa-eye"></i> {{feed.played_count}}
      <a v-bind:href="feed.link"><i class="fa fa-external-link"></i></a>
    </div>
    <div class="metadata_2">
      <div class="image_avatar">
        <img v-bind:src="feed.user.avatar" alt="" class="avatar">
      </div>
      <div class="name">{{feed.user.name}}</div>
      <div class="social_media">
        <i class="fa fa-vimeo"></i>
      </div>
    </div>
  </div>
</template>


<script>
  import { bus } from '../../main'


	export default {
		props: ['feed', 'keyword', 'active'],
		components: { },
		data() {
			return {
        max_length: 140,
			}
		},
		created() { },
		mounted() {	},
		computed : {
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
    	}
		},
		methods: {
      newFormatDate: function() {
        const date = new Date(this.feed.created_at);
        // const month = date.getMonth();
        const locale = "en-us";
        const newMonth = date.toLocaleString(locale, { month: "short" });

        return  newMonth + ' ' + date.getDate();
      },
      needsTruncation: function(string){
        if(typeof(string)!=='undefined'){
          return string.length > this.max_length
        }
        else{
          return false
        }
      }
		}

	}
</script>

<style>

</style>
