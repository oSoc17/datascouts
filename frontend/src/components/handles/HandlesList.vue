<template>
  
  <ul class="handles">
    <template v-for="handle in handles">
      <input type="checkbox" class="checkbox" name="checkbox" 
        :value="handle.id" v-model="activedHandles">
      <li v-bind:class="[{ active: isSelected && select.id == handle.id }, 'handle']"
          v-on:click.stop="selectHandle(handle)">
        <div class="icon-handle">
          <i v-bind:class="['icon-handle', 'fa', 'fa-'+handle.service]"></i>
        </div>
        <p >{{handle.name}}</p>
      </li>
    </template>
  </ul>
</template>

<script>
  import { bus } from '../../main'

  export default {
    props:['handles'],
    components:{
      
    },
    data () {
      return {
        activedHandles : [],
        select : {},
        isSelected: false,
      }
    },
    created () {
      bus.$on('selectHandle', (handle, e) => {
        this.selectHandle(handle, e)
      }),
      bus.$on('handleSelected', () => {
        this.handleSelected()
      }),
      bus.$on('handleNotSelected', () => {
        this.handleNotSelected()
      })
    },
    watch : {
      handles : function (){
        this.activedHandles = this.handles.filter(h => h.active).map(h => h.id)
      },
      activedHandles : function () {
        console.log('Active handles IDs :', this.activedHandles);
        // bus.$emit('FETCH_DATA', this.activedHandles)
      }
      
    },
    methods: {
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
