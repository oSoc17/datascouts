<template>
  <form action="" class="slide-up" id="entity_form">
    <div class="form-group hidden">
      <label for="">Name</label>
      <input type="text" placeholder="Name">
    </div>
    <div class="form-group">
      <button class="btn_primary action" id="entity_add">
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
    }
  },
  created () {
    bus.$on('addEntity', (entity, e) => {
      this.addEntity(entity, e)
    })
  },
  methods: {
    addEntity: function (name, e) {
      e.preventDefault()
      bus.$emit('loadEntities')
      Vue.http.post(this.url + '/entities', {"name" : name}).then(function (response) {
        bus.$emit('loadEntities')
        console.log("Entity added")
        }, function (response) {
          console.log("Error Failed to add entity")
      })
    }
  }
}
</script>

<style lang="scss">

</style>
