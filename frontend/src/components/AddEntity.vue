<template>
  <form action="" class="slide-up" id="entity_form">
    <div class="form-group">
      <label for="">{{name}}</label>
      <input type="text" placeholder="Name" v-model="name">
    </div>
    <div class="form-group">
      <button class="btn_primary action" id="entity_add" v-on:click="addEntity($event)">
        <i class="plus">+</i>
        Add an entity
      </button>
    </div>
  </form>
</template>

<script>
import { bus } from '../main'

export default {
  props:['url'],
  components:{

  },
  data () {
    return {
      name
    }
  },
  created () {
    bus.$on('addEntity', (entity, e) => {
      this.addEntity(entity, e)
    })
  },
  methods: {
    addEntity: function (e) {
      e.preventDefault()
      var self = this
      bus.$emit('loadEntities')
      Vue.http.post(this.url + '/entities', {"name" : self.name}).then(function (response) {
        bus.$emit('loadEntities')
        console.log("Entity added")
        self.name = ""
        }, function (response) {
          console.log("Error Failed to add entity")
      })
    }
  }
}
</script>

<style lang="scss">

</style>
