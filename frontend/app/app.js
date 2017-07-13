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
      uuid: '',
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

      var entitiesUuids = []
      for(item in this.entities){
        entitiesUuids.push(item.entity.uuid)
      }
      var socialMedia
      for(item in this.socialMediaFilters){
        if(item.active){
          socialMedia.push(item.name)
        }
      }
      this.$http.post(this.url + '/providers/fetch', {entitiesUuids, socialMedia}).then(function (response) {
          this.items = response.data
          //console.log(response)
        }, function (response) {
          console.log("Error Fail to get data")
      });

    },
    loadEntities: function() {
      this.$http.get(this.url + '/entities').then(function (response) {
        var newEntities = []
        var bool
        var index
        // response.data.forEach(e => this.selectedEntities.push(e));
        response.data.forEach(function(entity) {
          bool = false
          for(var i=0;i<this.entities.length;i++){
            if(entity.uuid == this.entities[i].uuid){bool = true; index = i; break;}
          }
          if(!bool){
            newEntities.push({"entity" : entity, "active": true})
          }
          else{
            newEntities.push({"entity" : entity, "active": this.entities[index].active})
          }
        });
          this.entities = newEntities

        console.log("Entities loaded")
          //console.log(response)
        }, function (response) {
          console.log("Error Failed to get data")
          console.log(response)
      })
    },
    loadHandles: function(entity) {
      this.$http.get(this.url + '/entities/' + entity.uuid + '/handles').then(function (response) {
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
      if(!this.isEntitySelected || this.currentEntity.uuid==entity.uuid){
        this.isEntitySelected = !this.isEntitySelected
      }
      this.currentEntity.name = entity.name
      this.currentEntity.url = entity.url
      this.currentEntity.image = entity.image
      this.currentEntity.uuid = entity.uuid
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
      this.$http.put(this.url + '/entities/'+ entity.uuid,
      {"name": newName}).then(function (response) {
          console.log("Entity updated")
          //console.log(response)
        }, function (response) {
          console.log("Error Failed to edit entity")
      })
      this.loadEntities()
    },
    confirmDeleteEntity: function(entity, e) {
      if(confirm("Are you sure you want to delete this entity?") == true){
        this.deleteEntity(entity, e)
      }
    },
    deleteEntity: function(entity, e) {
      e.preventDefault()
      console.log(entity.name)
      this.$http.delete(this.url + '/entities/' + entity.uuid).then(function (response) {
          console.log("Entity deleted")
          //console.log(response)
        }, function (response) {
          console.log("Error Failed to delete entity")
      })
      this.loadEntities()
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
      this.$http.post(this.url + '/handles/'+ entity.uuid, {"name" : handle.name, "url" : handle.uuid,
    "socialMedia" : handle.socialMedia}).then(function (response) {
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
      if(!this.handleSelected || this.currentHandle.uuid==handle.uuid){
        this.handleSelected = !this.handleSelected
      }
      this.currentHandle.name = handle.name
      this.currentHandle.url = handle.url
      this.currentHandle.uuid = handle.uuid
      if(this.handleSelected){
        document.getElementById("sidenav_action").style.marginLeft = "500px"
      }
      else{
        document.getElementById("sidenav_action").style.marginLeft = "0px"
      }
    },
    editHandle: function(handle, e) {
      e.preventDefault()
      console.log(handle.uuid)
      this.$http.put(this.url + '/services/' + handle.uuid, {"name:" : handle.name, "url" : handle.url,
    "socialMedia" : handle.socialMedia}).then(function (response) {
          console.log("Handle updated")
          //console.log(response)
        }, function (response) {
          console.log("Error Failed to update handle")
      })
      this.loadHandles(this.currentEntity)
    },
    confirmDeleteHandle: function(handle, e) {
      if(confirm("Are you sure you want to delete this handle?") == true){
        this.deleteEntity(handle, e)
      }
    },
    deleteHandle: function(handle, e) {
      e.preventDefault()
      console.log(handle)
      this.$http.delete(this.url + '/services'/ + handle.uuid).then(function (response) {
          console.log("Handle deleted")
          //console.log(response)
        }, function (response) {
          console.log("Error Failed to delete handle")
      })
      this.loadEntities()
    },
    discardHandle: function(e) {
      this.handleSelected = !this.handleSelected
      document.getElementById("sidenav_action").style.marginLeft = "0px"
      this.currentHandle.uuid = ""
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
