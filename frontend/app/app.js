new Vue({
  el:'#vue-app',
  /*http: {
    root: '/root',
    headers: {
      Authorization: 'Basic YXBpOnBhc3N3b3Jk'
    }
  },*/
  data: {
    items: [],
    socialMediaFilters: [
      {name: 'Twitter',
      active: true},
      {name: 'Facebook',
      active: false}
    ],
    dateFilters: [
      {year: 2017,
      active: true},
      {year: 2016,
      active: false}
    ],
    url: 'https://osoc-2017-datascouts-backend-akad1070.c9users.io/api/v1',
    mockDataTwitter: 'http://www.json-generator.com/api/json/get/ckwxgssyXm?indent=2',
    entities: ['osoc','tesla','spacex', 'apple'],
    selectedEntities: [],
    searchEntity: '',
    currentEntity: '',
    handles: ['facebook/user1','facebook/user2','twitter/user'],
    selected: false,
    waterfall: new Waterfall(200),
    waterfallIsCreated: false,
    isLoading: false,
    loadingTemplatesWidth: 'calc(33.33% - 30px)',
    loadingTemplatesAmount: 3,
    vueIsWorking: 'Hurray, Vue is working!'
  },
  watch: {
    items: function(updatingWfContainer){
      this.updateWaterfall()
    }
  },
  mounted: function() {
    this.loadEntities()
  },
  methods: {
    fetchData: function(entities) {
      //display load templates & adjust them to the screen, hide loading elements
      this.isLoading = true
      document.getElementById("wf-container").style.visibility = "hidden"
      var boxes = document.getElementsByClassName("template_box")
      this.$nextTick(function(){
        for(var i=0;i<boxes.length;i++){
          boxes[i].style.width = this.loadingTemplatesWidth
        }
      })

      this.$http.get(this.mockDataTwitter).then(function (response) {
          this.items = response.data
          //console.log(response)
        }, function (response) {
          console.log("Error Fail to get data")
      });

      //now the real magic happens
      /*this.$http.get(this.url + '/entities', JSON.stringify(entities)).then(function (response) {
          this.items = JSON.parse(response.data)
          //console.log(response)
        }, function (response) {
          console.log("Error Fail to get data")
      });*/

    },
    addEntity: function (entity, e) {
      e.preventDefault()
      console.log(entity)
      this.$http.post(this.url + '/entities', {"name" : entity}).then(function (response) {
          console.log("Entity added")
          //console.log(response)
        }, function (response) {
          console.log("Error Failed to add entity")
      })
      this.searchEntity=""
      this.loadEntities()
    },
    selectEntity: function (entity, e) {
      e.preventDefault()
      //console.log(entity)
      if(!this.selected || this.currentEntity==entity){
        this.selected = !this.selected
      }
      this.currentEntity = entity
      if(this.selected){
        document.getElementById("sidenav_handles").style.marginLeft = "250px"
      }
      else{
        document.getElementById("sidenav_handles").style.marginLeft = "0px"
      }
    },
    editEntity: function(entity, newName, e) {
      e.preventDefault()
      console.log(entity)
      this.$http.put(this.url + '/entities', {"id:" : entity, "name" : newName}).then(function (response) {
          console.log("Entity added")
          //console.log(response)
        }, function (response) {
          console.log("Error Failed to edit entity")
      })
      this.loadEntities()
    },
    deleteEntity: function(entity, e) {
      e.preventDefault()
      console.log(entity)
      this.$http.delete(this.url + '/entities', {"name" : entity}).then(function (response) {
          console.log("Entity added")
          //console.log(response)
        }, function (response) {
          console.log("Error Failed to delete entity")
      })
      this.loadEntities()
    },
    loadEntities: function() {
      this.$http.get(this.url + '/entities').then(function (response) {
        this.entities = response.data.map(e => e.name);
        console.log("Entity added")
          //console.log(response)
        }, function (response) {
          console.log("Error Fail to get data")
          console.log(response)
      })
    },
    updateWaterfall: _.debounce(
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
})
