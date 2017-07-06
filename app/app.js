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
    newEntity: '',
    currentEntity: '',
    entities: [],
    vueIsWorking: 'Hurray, Vue is working!'
  },
  methods: {
    fetchData: function () {
      var xhr = new XMLHttpRequest()
      var self = this
      xhr.open('GET', self.url + self.currentEntity)
      xhr.onload = function () {
        console.log(xhr.responseText)
        self.items = JSON.parse(xhr.responseText)

      }
      xhr.send()
    },
    addEntity: function (e) {
      e.preventDefault()
      this.currentEntity = this.newEntity
      this.fetchData()
      this.entities.push(this.newEntity)
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
