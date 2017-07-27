<template v-if="feed.service_name === 'twitter' " >
  <div class="wf-box twitter">
    <!-- BODY -->
    <div class="body">
      <p>
        {{ feed.body }}
      </p>
    </div>
    <!-- IMAGE -->
    <img v-bind:src="feed.media" alt="" class="media">

    <!-- METADATA - likes/comments/views -->
    <div class="metadata_1">
      <i class="fa fa-retweet"></i> {{feed.retweet_count}} | <i class="fa fa-heart"></i> {{feed.favorite_count}}
      <a v-bind:href="feed.link" target="_blank"><i class="fa fa-external-link"></i></a>
    </div>
    <div class="metadata_2">
      <div class="image_avatar">
        <img v-bind:src="feed.user.profile_image_url_https" alt="" class="avatar">
      </div>
      <div class="name">{{feed.user_full_name}}</div>
      <div class="social_media">
        <i class="fa fa-twitter"></i>
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
		  // console.log(this.feed)
		},
		watch: {
		},
		methods: {
		}
		
	}
</script>

<style>

</style>
