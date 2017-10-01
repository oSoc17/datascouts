<template>
  <form action="" class="slide-up" id="entity_form">
    <div class="form-group">
      <!--<label for="">New Entity : {{name}}</label>-->
      <input 
        name="name"
        type="text"
        placeholder="Insert new member name"
        v-model="name"
        v-validate="'required|min:3'"
        data-vv-delay="1000"
        data-vv-validate-on="none">
      <span
        style="color:red"
        v-show="errors.has('name')">
        {{errors.first('name')}}
      </span> 
    </div>
    <div class="form-group">
      <button class="btn_primary action" id="entity_add" v-on:click.prevent="addEntity()">
        <i class="plus">+</i>
        Add member
      </button>
    </div>
  </form>
</template>

<script>
import { bus } from '../../main'

export default {
  props:[],
  components:{

  },
  data () {
    return {
      name
    }
  },
  created () { },
  methods: {
    addEntity: function () {
      this.$validator.validateAll()
      if(!this.errors.has('name')){
        bus.$emit('ADD_NEW_ENTITY', this.name)
        this.name = ''
      }
    }
  }
}
</script>

<style >

</style>
