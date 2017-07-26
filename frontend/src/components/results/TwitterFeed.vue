<template >
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

<script>

</script>

<style>

</style>
