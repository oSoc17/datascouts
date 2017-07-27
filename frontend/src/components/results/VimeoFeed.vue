<template v-if="feed.service_name == 'vimeo' ">
<div class="wf-box vimeo">
  <!-- BODY -->
  <div class="body">
    <p class="title">
      {{ feed.title }}
    </p>
    <p class="description">
      {{ feed.description }}
    </p>
  </div>

  <!-- THUMBNAIL -->
  <div style="position: relative;">
    <img v-bind:src="feed.thumbnail" alt="" class="media">
    <a href="" class="play-button">
      <i class="fa fa-youtube-play"></i>
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
    <i class="fa fa-views"></i> {{feed.played_count}}
    <a v-bind:href="'test'"><i class="fa fa-external-link">{{feed.link}}</i></a>
  </div>
  <div class="metadata_2">
    <div class="image_avatar">
      <img src="test" alt="" class="avatar">
    </div>
    <div class="name">{{feed.channel}}</div>
      <div class="social_media">
        <i class="fa fa-vimeo"></i>
      </div>
    </div>
  </div>
</template>


<script>
  
	export default {
		props: ['feed'],
		components: {
		},
		data() {
			return {

			}
		},
		created() {
		},
		mounted() {
		  console.log(this.feed)
		},
		watch: {
		},
		methods: {
		}
		
	}
</script>

<style>

</style>
