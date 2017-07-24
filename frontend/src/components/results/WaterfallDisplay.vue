<template>
  <div id="content">
    <!--<div class="flashmessage">You succesfully created an entity called {{ entity }}</div>-->

    <!--<button type="button" v-on:click="fetchData">fetch data (this button is only for testing)</button>-->

    <div class="template" v-if="isLoading">
        <h1>loading...</h1>
        <template v-for="item in loadingTemplatesAmount">
          <div class="template_box">
              <div class="template_image"></div>
              <div class="template_text"></div>
              <div class="template_text"></div>

              <div class="template_text"></div>
              <div class="template_text"></div>
              <div class="template_text"></div>
          </div>
        </template>
    </div>

    <div class="empty-state empty-state-feed" v-show="entitiesIsEmpty">
				<h2>What is an entity?</h2>
				<p>
					Curabitur aliquet quam id dui posuere blandit.
					Lorem ipsum dolor sit amet, consectetur adipiscing elit.
					Curabitur aliquet quam id dui posuere blandit. Proin eget tortor risus.
				</p>
				<h2>How to add one?</h2>
				<ul>
					<li>Step 1</li>
					<li>Step 2</li>
					<li>Step 3</li>
				</ul>
			</div>

    <div class="tweets wf-container" id="wf-container">
      <template v-for="entity in items">
        <template v-for="handle in entity">
            <!--TWEET-->
            <div class="wf-box twitter" v-if="handle.social_media === 'twitter'">
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
      </template>
    </div>

  </div>
</template>

<script>
  import { bus } from '../../main'
  //import EntitiesSidebar  from './components/sidebars/EntitiesSidebar.vue'

  export default {
    components : {

    },
    data () {
      return {
        entitiesIsEmpty: false,
        handlesIsEmpty: false,
      }
    },
    created () {
      bus.$on('ENTITIES_IS_EMPTY', (bool) => this.entitiesIsEmpty = bool)
      bus.$on('HANDLES_IS_EMPTY', (bool) => this.handlesIsEmpty = bool)
    },
    mounted() {

    },
    methods: {



    }
  }
</script>

<style>

</style>
