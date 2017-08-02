<template>
  <div class="filters" id="filters">
  	<button class="btn_primary btn_filter" v-on:click="showFilters()">
  		<!-- <i class="fa fa-filter fa-active"></i> -->
  		<i class="fa fa-filter"></i>
  		Filter
  	</button>
  	<form action="" id="filter" style="display: none;" class="">
  		<div class="arrow"></div>
  		<div class="filter-socialmedia">
  			<h2>Social media</h2>
  			<template v-for="(item, index) in socialMedia">
  				<div class="form-group">
  					<input class="styled-checkbox" :id="'styled-checkbox-sm-1'+index" type="checkbox" :value="item" v-model="activeSocialMedia">
  					<label :for="'styled-checkbox-sm-1'+index">{{item}}</label>
  				</div>
  			</template>
  		</div>
  		<div class="filter-keywords">
  			<h2>Keyword</h2>
        <form>
          <div class="form-group">
            <input type="text" placeholder="Keyword" v-model.trim="newKeyword">
            <button type="submit" class="btn_primary action" id="entity_add" v-on:click.prevent="addKeyword()">
               <i class="plus">+</i>
            </button>
          </div>
        </form>
  			<div class="radio-filter">
  				<input type="radio" id="noFilter" value="" v-model="selectedKeyword">
  				<label for="noFilter">no filter</label>
  			</div>
  
  			<template v-for="keyword in keywords">
  				<div class="radio-filter">
  					<input type="radio" :id="keyword"  :value="keyword" v-model="selectedKeyword">
  					<label :for="keyword">{{keyword}}</label>
  					<button v-on:click.prevent="deleteKeyword(keyword)"><i class="fa fa-times" aria-hidden="true"></i></button>
  				</div>
  			</template>
  		</div>
  
  	</form>
  </div>

</template>

<script>
  import _debounce  from 'lodash.debounce'
  
	import { bus } from '../../main'


	export default {
		props: [],
  	data () {
    	return {
    		filteredItems: [],
    		selectedKeyword: '',
    		newKeyword: '',
    		keywords: [],
    		socialMedia: [],
    		activeSocialMedia: [],
    	}
  	},
  	created () {
			let i = 1
			while(typeof(this.services[i])!=='undefined'){
				this.socialMedia.push(this.services[i++].name)
			}
			this.activeSocialMedia = this.socialMedia
		},
  	mounted() {
  	},
  	watch: {
    	items: function(updatingWfContainer){
    		this.updateWaterfall()
    	}
  	},
  	methods: {
    	addKeyword: function(){
    		if(this.newKeyword && this.keywords.indexOf(this.newKeyword) == -1){
    		  this.keywords.push(this.newKeyword)
    		}
    		this.selectedKeyword = this.newKeyword
    		this.newKeyword = ""
    	},
    	deleteKeyword: function(keyword){
    		const i = this.keywords.findIndex(k => k === keyword)
    		this.selectedKeyword = ''
    		this.keywords.splice(i,1)
    	},
    	hideFilters: function(e){
    		const el = document.getElementById("filter")
    		const filters = document.getElementById("filters")
    		if(el.style.display !== 'none' && !this.isDescendant(filters, e.target)){
      		el.style.display = 'none';
      		el.classList.toggle("display-filter")
    		}
    	},
    	isDescendant: function (parent, child) {
      	let node = child.parentNode;
      	while (node != null) {
      		if (node == parent) {
      			return true;
      		}
      		node = node.parentNode;
      	}
      	return false;
    	},
    	showFilters: function(e){
    		const el = document.getElementById("filter")
    		const el2 = document.querySelector("button.btn_primary.btn_filter");
    		el.style.display = el.style.display === 'none' ? 'initial' : 'none';
    		el.classList.toggle("display-filter");
    		el2.classList.toggle("fa-active");
    	},
    	
    	

  	}
  }
</script>

<style>

</style>
