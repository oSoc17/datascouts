<template>
  <div id="content" v-on:click="hideFilters($event)">
    <div class="flashmessage">You succesfully created an entity called {{ entity }}</div>

    <div class="filters" id="filters">
		<button class="btn_primary btn_filter" v-on:click="showFilters()">
			<!-- This source should be replaced with filtered.svg
					IF any checkboxes are check
					OR any keyword is added -->
			<!-- <i class="fa fa-filter fa-active"></i> -->
      <i class="fa fa-filter"></i>
			Filter
		</button>
		<form action="" id="filter" style="display: none;" class="">
			<div class="arrow"></div>
			<div class="filter-socialmedia">
				<h2>Social media</h2>
				<div class="form-group">
					<input class="styled-checkbox" id="styled-checkbox-sm-1" type="checkbox" value="twitter" checked>
					<label for="styled-checkbox-sm-1">Twitter</label>
				</div>
				<div class="form-group">
					<input class="styled-checkbox" id="styled-checkbox-sm-2" type="checkbox" value="youtube">
					<label for="styled-checkbox-sm-2">YouTube</label>
				</div>
				<div class="form-group">
					<input class="styled-checkbox" id="styled-checkbox-sm-3" type="checkbox" value="vimeo">
					<label for="styled-checkbox-sm-3">Vimeo</label>
				</div>
			</div>

			<div class="filter-keywords">
				<h2>Keyword</h2>
				<div class="form-group">
          <form>
            <input type="text" placeholder="Keyword" v-model="newKeyword">
            <button type="submit" class="btn_primary action" id="entity_add" v-on:click.prevent="addKeyword()">
              <i class="plus">+</i>
              Add keyword
            </button>
          </form>
				</div>
				<div class="form-group">
					<!-- You can add any html tag for vue, not styled yet, I'll do it afterwards -->
          <input type="radio" id="noFilter" value="" v-model="selectedKeyword">
          <label for="noFilter">no filter</label>
          <template v-for="keyword in keywords">
            <input type="radio" :id="keyword" :value="keyword" v-model="selectedKeyword">
            <label :for="keyword">{{keyword}}</label>
            <button v-on:click.prevent="deleteKeyword(keyword)">x</button>
          </template>
				</div>
			</div>

		</form>
	</div>

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
				<h2>What is a member?</h2>
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
            <div class="wf-box twitter" v-show="hasKeyword(handle)"v-if="handle.social_media === 'twitter'">
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
  import _debounce  from 'lodash.debounce'

  import { bus } from '../../main'
  import {
    getActiveEntities,
    getActiveHandles,

  } from '../../utils/storageService'


  export default {
    components : {

    },
    data () {
      return {
        entitiesIsEmpty: false,
        items: [],
        filteredItems: [],
        selectedKeyword: '',
        newKeyword: '',
        keywords: [],
        isLoading: false
      }
    },
    created () {
      console.log('Created WaterDisplay')
    },
    mounted() {
      this.waterfall = new Waterfall(200)
      bus.$on('ENTITIES_IS_EMPTY', (bool) => this.entitiesIsEmpty = bool)
      bus.$on('FETCH_DATA', this.fetchData)
    },
    watch: {
      items: function(updatingWfContainer){
        this.updateWaterfall()
      }
    },
    methods: {
      addKeyword: function(){
        if(this.keywords.indexOf(this.newKeyword)==-1 && this.newKeyword!==''){
          this.keywords.push(this.newKeyword)
        }
        this.selectedKeyword = this.newKeyword
        this.newKeyword = ""
      },
      hasKeyword: function(item){
        if(typeof(item.body)!=='undefined'){
          return item.body.indexOf(keyword)!==-1
        }
        else{
          return false
        }
        setTimeout(function(){this.updateWaterfall()},10)
      },
      deleteKeyword: function(keyword){
        const i = this.keywords.findIndex(k => k === keyword)
        this.selectedKeyword = ''
        this.keywords.splice(i,1)
      },
      hideFilters: function(e){
        var el = document.getElementById("filter")
        var filters = document.getElementById("filters")
        if(el.style.display !== 'none' && !this.isDescendant(filters, e.target)){
          el.style.display = 'none';
          el.classList.toggle("display-filter")
        }
      },
      isDescendant: function (parent, child) {
       var node = child.parentNode;
       while (node != null) {
           if (node == parent) {
               return true;
           }
           node = node.parentNode;
       }
       return false;
      },
      showFilters: function(e){
        var el = document.getElementById("filter")
        var el2 = document.querySelector("button.btn_primary.btn_filter");
        el.style.display = el.style.display === 'none' ? 'initial' : 'none';
        el.classList.toggle("display-filter");
        el2.classList.toggle("fa-active");
      },
      getAllActiveHandles : function (){
        const handles = [];
        getActiveEntities().forEach(ent_id => {
          const activeHandles = getActiveHandles(ent_id);
          handles.push(... activeHandles);
        })
        console.log('Active Handles to fetch : ',handles);
        return handles;
      },
      fetchData: function(){
        console.log('fetching data')

        //display load templates & adjust them to the screen, hide loading elements
        this.isLoading = true
        document.getElementById("wf-container").style.visibility = "hidden"
        var boxes = document.getElementsByClassName("template_box")
        this.$nextTick(function(){
          for(var i=0;i<boxes.length;i++){
            boxes[i].style.width = this.loadingTemplatesWidth
          }
        })

        const handles = this.getAllActiveHandles()

        this.$http.post('fetch', {handles})
            .then(res => {this.items = res.data})
            .catch(console.error)
        console.log(this.items)
      },
      updateWaterfall: _debounce(
        function() {
          this.waterfall.compose(true)
          document.getElementById("wf-container").style.visibility = "visible"

          //get waterfall variables to adjust loading templates.
          //TO-DO(low-prior.): copy the width calc & columnsNum code from waterfall.js so
          //that waterfall doesnt need to be rendered first to get the variables
          var columns = document.getElementsByClassName("wf-column")
          this.loadingTemplatesWidth = "calc("+columns[columns.length-1].style.width+" - 30px)"
          //console.log(this.loadingTemplatesWidth)
          this.loadingTemplatesAmount = this.waterfall.getColumnsNum()

          this.isLoading = false
        },
      1)
    }
  }
</script>

<style>

</style>
