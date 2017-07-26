<template>
  <ul class="handles">
    <div class="empty-state empty-state-handles" v-show="handlesIsEmpty">
      <li>You don't have any accounts yet. You can add them by clicking on '+ ADD ACCOUNT' beneath.</li>
    </div>

    <template v-for="handle in handles">

      <li v-bind:class="[{ active: isSelected && select.id == handle.id }, 'handle']">
          <div v-on:click="selectHandle(handle)">
            <div class="icon-handle">
              <i v-bind:class="['icon-handle', 'fa', 'fa-'+handle.service]"></i>
            </div>
            <p >{{handle.name}}</p>
          </div>
          <input type="checkbox" class="checkbox" name="checkbox"
            :value="handle.id" v-model="activeHandles">
      </li>
    </template>
  </ul>
</template>

<script>
  import { bus } from '../../main'

  export default {
    props:['handles', 'actives'],
    components:{

    },
    data () {
      return {
        activeHandles : [],
        select : {},
        isSelected: false,
        handlesIsEmpty: false,
      }
    },
    created () {
      bus.$on('selectHandle', (handle, e) => {
        this.selectHandle(handle, e)
      }),
      /*bus.$on('handleSelected', () => {
        this.handleSelected()
      }),
      bus.$on('handleNotSelected', () => {
        this.handleNotSelected()
      }),*/
      bus.$on('HANDLES_IS_EMPTY', (bool) => this.handlesIsEmpty = bool)
      bus.$on('DESELECT_HANDLE', () => {console.log("nope")})
    },
    watch : {
      handles : function (){
        this.activeHandles = this.handles.filter(h => h.active).map(h => h.id)
        this.handlesIsEmpty = this.handles.length == 0
      },
      actives : function () {
        this.activeHandles = this.actives
      },
      activeHandles : function () {
        bus.$emit('CHANGE_ACTIVE_HANDLES', this.activeHandles)
        bus.$emit('FETCH_DATA')

      }

    },
    methods: {
      deselectHandle: function(){
        this.isSelected = false
        console.log(this.isSelected)
      },
      selectHandle: function(handle, e) {
        if(this.isSelected){ // Already, select a handle
          if(handle.id == this.select.id) {
            this.isSelected = false
            return bus.$emit('CLOSE_EDITHANDLE_SIDEBAR')
          }
        }
        this.select = handle
        bus.$emit('CHANGE_CURRENT_HANDLE', this.select)
        this.isSelected = true
      },

      // updateSelectedHandles: _debounce( function() {
      //   this.fetchData()
      // }, 1),

    }
  }
</script>

<style lang="scss">

</style>
