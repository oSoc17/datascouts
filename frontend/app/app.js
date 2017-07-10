new Vue({
  el:'#vue-app',
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
    url: 'https://osoc-2017-datascouts-akad1070.c9users.io/',
    mockDataTwitter: 'http://www.json-generator.com/api/json/get/ckwxgssyXm?indent=2',
    newEntity: '',
    currentEntity: '',
    entities: [],
    waterfall: new Waterfall(),
    waterfallIsCreated: false,
    limit: 20,
    vueIsWorking: 'Hurray, Vue is working!'
  },
  watch: {
    items: function(updatingWfContainer){
      this.updateWaterfall()
    }

  },
  methods: {
    fetchData: function (medium) {
      var xhr = new XMLHttpRequest()
      var self = this
      var u = this.url + medium + '/q/' + this.currentEntity + '?limit=' + this.limit
      if(self.currentEntity=='mockdata'){
        u = self.mockDataTwitter
      }
      xhr.open('GET', u)
      xhr.onload = function () {
        //console.log(xhr.responseText)
        self.items = JSON.parse(xhr.responseText)

      }
      xhr.send()
      /*xhr.onreadystatechange = function() {
            if (xhr.readyState == 4){
              storeData()
            }
      }*/
    },
    addEntity: function (e) {
      e.preventDefault()
      if(this.newEntity==undefined || this.newEntity.length==0){
        if(this.entities.indexOf('mockdata')==-1){
          this.entities.push('mockdata')
        }
        this.currentEntity='mockdata'
      }
      else{
        if(this.entities.indexOf(this.newEntity)==-1){
          this.entities.push(this.newEntity)
        }
        this.currentEntity=this.newEntity
      }
      this.fetchData('twitter')
      this.newEntity=''
    },
    selectEntity: function (entity, e) {
      e.preventDefault()
      //console.log(entity)
      this.currentEntity = entity
      this.fetchData('twitter')
    },
    updateWaterfall: _.debounce(
        function() {
          this.waterfall = new Waterfall()
        },
      600)
  }
})
