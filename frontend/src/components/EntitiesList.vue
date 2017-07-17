<template>
  <div id="root-element">
    <template v-for="item in entities">
      <div class="entity">
        <button type="button" v-on:click="selectEntity(item,$event)"
        v-if=" (item.entity.name.indexOf(searchEntity) !== -1 || searchEntity == '')">
          {{item.entity.name}}
        </button>
        <input type="checkbox" class="checkbox" name="checkbox" value=""
        v-if=" (item.entity.name.indexOf(searchEntity) !== -1 || searchEntity == '')"
        v-on:click="toggleEntity($event)">
      </div>
    </template>
  </div>
</template>

<script>

export default {
  props:{
    'entities':{
      type: Array,
      required: false
    }
  },
  data () {
    return {
    }
  },
  methods: {
    addEntity: function(){

    }
  }
</script>

<style lang="scss">

</style>
