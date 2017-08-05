<template>
	<div :class="['filters',{'display-filter':active}]" id="filters">
		<button :class="['btn_primary', 'btn_filter', {'fa-active' : active}]" 
		        @click="$emit('toggle:popup')">
			<i class="fa fa-filter"></i>
			Filter
		</button>
		<form action="" id="filter" 
		      :class="{'display-filter' : active}"
		      :style="{'display' : active ? 'initial' : 'none'}"
		>
			<div class="arrow"></div>
			<div class="filter-socialmedia">
				<h2>Social media</h2>
				<template v-for="service in services">
					<div class="form-group">
						<input class="styled-checkbox"  type="checkbox"
						      :id="'styled-checkbox-sm-1'+service.id" 
						      :value="service.name" 
						      v-model="activeSocialMedia"
						>
						<label :for="'styled-checkbox-sm-1'+service.id">{{service.name}}</label>
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
  import {
  	getServices,
  } from '../../utils/storageService'

	export default {
		props: ['active'],
  	data () {
    	return {
    	  services : getServices(),
    		filteredItems: [],
    		selectedKeyword: '',
    		newKeyword: '',
    		keywords: [],

    		activeSocialMedia: [],
    	}
  	},
  	created () {
		  this.activeSocialMedia = Object.keys(this.services).map(i => this.services[i].name);
		},
  	watch : {
  	  selectedKeyword : function (){
  		  this.$emit('select:keyword', this.selectedKeyword)
  	  },
  	  
  	  activeSocialMedia : function (){
  		  this.$emit('select:social_media', this.activeSocialMedia)
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
    		this.$emit('select:keyword', this.selectedKeyword)
    		this.keywords.splice(i,1)
    	},

  	}
  }
</script>

<style>

</style>
