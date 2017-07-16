var vue = new Vue({
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
    entities: [],
    selectedEntities: [],
    searchEntity: '',
    currentEntity: {
      name: '',
      url: '',
      image: '',
      id: '',
    },
    handles: [],
    currentHandle: {
      name: '',
      url: ''
    },
    newName: '',
    newUrl: '',
    isEntitySelected: false,
    handleSelected: false,
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
    },
    entities: function(updatingEntities){
      this.updateSelectedEntities()
    }
  },
  mounted: function() {
    this.loadEntities()
  },
  methods: {
    fetchData: function(entities) {
      var self = this
      //display load templates & adjust them to the screen, hide loading elements
      this.isLoading = true
      document.getElementById("wf-container").style.visibility = "hidden"
      var boxes = document.getElementsByClassName("template_box")
      this.$nextTick(function(){
        for(var i=0;i<boxes.length;i++){
          boxes[i].style.width = this.loadingTemplatesWidth
        }
      })

      //creating body of the post request
      var entitiesIds = []
      var socialMedia
      if(self.entities.length != 0 ){
        for(var i=0;i<self.entities.length;i++){
          if(self.entities[i].active){
            entitiesIds.push(self.entities[i].entity.id)
          }

        }
        for(item in self.socialMediaFilters){
          if(item.active){
            socialMedia.push(item.name)
          }
        }

        this.$http.post(this.url + '/providers/fetch', {entitiesIds, socialMedia}).then(function (response) {
            self.items = response.data
            //console.log(response)
          }, function (response) {
            console.log("Error Fail to get data from server. Loading mockdata instead.")
            this.$http.get(this.mockDataTwitter).then(function (response) {
                self.items = response.data
                //console.log(response)
              }, function (response) {
                console.log("Error Fail to load mockdata")
            });
        });
      }
      else{
        this.$http.get(this.mockDataTwitter).then(function (response) {
            self.items = response.data
            //console.log(response)
          }, function (response) {
            console.log("Error Fail to load mockdata")
        });
      }
    },
    loadEntities: function() {
      var self = this
      this.$http.get(this.url + '/entities').then(function (response) {
        var newEntities = []
        var bool
        var index
        // response.data.forEach(e => this.selectedEntities.push(e));
        response.data.forEach(function(entity) {
          bool = false
          if(self.entities.length != 0 ){
            for(var i=0;i<self.entities.length;i++){
              if(entity.id == self.entities[i].entity.id){bool = true; index = i; break;}
            }
            if(!bool){
              newEntities.push({"entity" : entity, "active": true})
            }
            else{
              newEntities.push({"entity" : entity, "active": self.entities[index].active})
            }
          }
          else{
            newEntities.push({"entity" : entity, "active": true})
          }
        });
          self.entities = newEntities.slice()
          //console.log(response)
        }, function (response) {
          console.log("Error Failed to get data")
          console.log(response)
      })
    },
    updateSelectedEntities: _.debounce( function() {
      //set all checkboxes to the appropriate state
      var entitiesHTML = document.getElementsByClassName("entity")
      for(var i=0;i<this.entities.length;i++){
        entitiesHTML[i].getElementsByClassName("checkbox")[0].checked = this.entities[i].active
      }
    }, 1),
    toggleEntity: _.debounce( function (e){
      var entitiesHTML = document.getElementsByClassName("entity")
      for(var i=0;i<this.entities.length;i++){
        this.entities[i].active = entitiesHTML[i].getElementsByClassName("checkbox")[0].checked
      }
      this.fetchData()
    }, 100),
    addEntity: function (name, e) {
      e.preventDefault()
      this.$http.post(this.url + '/entities', {"name" : name}).then(function (response) {
        this.loadEntities()
        console.log("Entity added")
        }, function (response) {
          console.log("Error Failed to add entity")
      })
      this.searchEntity=""
    },
    selectEntity: function (entity, e) {
      e.preventDefault()
      //console.log(entity)
      if(!this.isEntitySelected || this.currentEntity.id==entity.id){
        this.isEntitySelected = !this.isEntitySelected
      }
      this.currentEntity.name = entity.name
      this.currentEntity.url = entity.url
      this.currentEntity.image = entity.image
      this.currentEntity.id = entity.id
      if(this.isEntitySelected){
        document.getElementById("sidenav_handles").style.marginLeft = "250px"
      }
      else{
        document.getElementById("sidenav_handles").style.marginLeft = "0px"
        this.discardHandle()
      }

      this.loadHandles(entity)
    },
    confirmEditEntity: function(entity, e){
      e.preventDefault()
      var newName = prompt("Enter a new name for your entity", entity.name);
      if(newName != null){
        this.editEntity(entity, newName, e)
      }
    },
    editEntity: function(entity, newName, e) {
      e.preventDefault()
      console.log(entity)
      this.$http.put(this.url + '/entities/'+ entity.id,
      {"name": newName}).then(function (response) {
          this.currentEntity = response.data
          console.log("Entity updated")
          this.loadEntities()
          //console.log(response)
        }, function (response) {
          console.log("Error Failed to edit entity")
      })
    },
    confirmDeleteEntity: function(entity, e) {
      if(confirm("Are you sure you want to delete this entity?") == true){
        this.deleteEntity(entity, e)
      }
    },
    deleteEntity: function(entity, e) {
      e.preventDefault()
      console.log(entity.name)
      this.$http.delete(this.url + '/entities/' + entity.id).then(function (response) {
          this.selectEntity(this.currentEntity, e)
          console.log("Entity deleted")
          this.loadEntities()
          //console.log(response)
        }, function (response) {
          console.log("Error Failed to delete entity")
      })

    },
    loadHandles: function(entity) {
      this.$http.get(this.url + '/entities/' + entity.id + '/handles').then(function (response) {
        for(var i=0; i<response.data.length; i++){
          this.handles[i] = response.data[i]
        }
        console.log("Handles loaded")
          //console.log(response)
        }, function (response) {
          console.log("Error Fail to get data")
          console.log(response)
      })
    },
    promptAddHandle: function(entity, e){
      e.preventDefault()
      var name = prompt("Enter a name for your handle", "");
      if(name != null){
        var url = prompt("Enter a url for your handle", "");
        if(url != null){
          var handle = {"name" : name, "url" : url, "socialMedia": 'twitter'}
          this.addHandle(entity, handle, e)
        }
      }
    },
    addHandle: function (entity, handle, e) {
      e.preventDefault()
      this.$http.post(this.url + '/handles/'+ entity.id, {"name" : handle.name, "url" : handle.url}).then(function (response) {
        this.loadHandles()
        console.log("Handle added")
        }, function (response) {
          console.log("Error Failed to add handle")
      })
      this.searchEntity=""
    },
    selectHandle: function(handle, e) {
      e.preventDefault()
      //console.log(entity)
      if(!this.handleSelected || this.currentHandle.id==handle.id){
        this.handleSelected = !this.handleSelected
      }
      this.currentHandle.name = handle.name
      this.currentHandle.url = handle.url
      this.currentHandle.id = handle.id
      if(this.handleSelected){
        document.getElementById("sidenav_action").style.marginLeft = "500px"
      }
      else{
        document.getElementById("sidenav_action").style.marginLeft = "0px"
      }
    },
    editHandle: function(handle, e) {
      e.preventDefault()
      console.log(handle.id)
      this.$http.put(this.url + '/entities/' + handle.id, {"name:" : handle.name, "url" : handle.url}).then(function (response) {
          console.log("Handle updated")
          this.loadHandles(this.currentEntity)
          //console.log(response)
        }, function (response) {
          console.log("Error Failed to update handle")
      })
    },
    confirmDeleteHandle: function(handle, e) {
      if(confirm("Are you sure you want to delete this handle?") == true){
        this.deleteEntity(handle, e)
      }
    },
    deleteHandle: function(handle, e) {
      e.preventDefault()
      console.log(handle)
      this.$http.delete(this.url + '/services'/ + handle.id).then(function (response) {
          console.log("Handle deleted")
          this.loadEntities()
          //console.log(response)
        }, function (response) {
          console.log("Error Failed to delete handle")
      })

    },
    discardHandle: function(e) {
      this.handleSelected = !this.handleSelected
      document.getElementById("sidenav_action").style.marginLeft = "0px"
      this.currentHandle.id = ""
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
