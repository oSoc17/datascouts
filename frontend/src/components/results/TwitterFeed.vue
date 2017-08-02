<template>
  <div class="wf-box twitter"  v-if="hasKeyword && activeSocialMedia.indexOf('twitter')!==-1">
    <!-- BODY -->
    <div class="body">
      <p>
        {{ feed.body }}
      </p>
      <div class="date">{{newFormatDate()}}</div>
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
  import { bus } from '../../main'

	export default {
		props: ['feed', 'keyword', 'activeSocialMedia'],
		components: {
		},
		data() {
			return {

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
      		let  isIncluded = this.feed.body != null
      		isIncluded = isIncluded && this.feed.body.includes(this.keyword)

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
        const newMonth = date.toLocaleString('en-us', { month: "short" });
        return  newMonth + ' ' + date.getDate();

      }
		}
	}
</script>

<style>

</style>
