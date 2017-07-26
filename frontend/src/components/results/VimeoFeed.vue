<template v-if="handle.service_name === 'vimeo'">
<div class="wf-box vimeo">
  <!-- BODY -->
  <div class="body">
    <p class="title">
      {{ handle.title }}
    </p>
    <p class="description">
      {{ handle.description }}
    </p>
  </div>

  <!-- THUMBNAIL -->
  <div style="position: relative;">
    <img v-bind:src="handle.thumbnail" alt="" class="media">
    <a href="" class="play-button">
      <i class="fa fa-youtube-play"></i>
    </a>
  </div>

  <!-- VIDEO-IFRAME -->
  <!-- <figure class="content-media content-media--video" id="featured-media">
    <iframe class="content-media__object media" id="featured-video" v-bind:src='handle.link + "?enablejsapi=1&rel=0&showinfo=0&controls=0"' frameborder="0"></iframe>
  </figure> -->

  <!-- METADATA - likes/comments/views -->
  <div class="metadata_1">
    <i class="fa fa-views"></i> 50,000
    <a v-bind:href="'test'"><i class="fa fa-external-link"></i></a>
  </div>
  <div class="metadata_2">
    <div class="image_avatar">
      <img src="test" alt="" class="avatar">
    </div>
    <div class="name">{{handle.channel}}</div>
      <div class="social_media">
        <i class="fa fa-vimeo"></i>
      </div>
    </div>
  </div>
</template>


<script>

</script>

<style>

</style>
