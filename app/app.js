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
    url: 'https://osoc-2017-datascouts-akad1070.c9users.io/twitter/q/',
    mockDataTwitter: 'http://www.json-generator.com/api/json/get/ckwxgssyXm?indent=2',
    newEntity: '',
    currentEntity: '',
    entities: [],
    waterfall: new Waterfall(),
    limit: 20,
    vueIsWorking: 'Hurray, Vue is working!'
  },
  methods: {
    fetchData: function () {
      var xhr = new XMLHttpRequest()
      var self = this
      var u = self.url + self.currentEntity + '?limit=' + self.limit
      if(self.currentEntity=='mockdata'){
        u = self.mockDataTwitter
      }
      xhr.open('GET', u)
      xhr.onload = function () {
        console.log(xhr.responseText)
        self.items = JSON.parse(xhr.responseText)

      }
      xhr.send()
      xhr.onreadystatechange = function() {
            if (xhr.readyState == 4){
              //Eventhough the data has finished loading, you have to wait a few
              //milliseconds for vue to add the elements to the DOM (i think)
              setTimeout(function () {
                waterfall = new Waterfall()
              }, 30);

            }
      }
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
      this.fetchData()
      this.newEntity=''
    },
    selectEntity: function (entity, e) {
      e.preventDefault()
      //console.log(entity)
      this.currentEntity = entity
      this.fetchData()
    }
  }
})
