new Vue({
  el:'#vue-app',
  data: {
    items: [],
    output: [],
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
    url: 'https://osoc-2017-datascouts-akad1070.c9users.io/twitter/q/osoc',
    newEntity: '',
    entities: [
    ],
    vueIsWorking: 'Hurray, Vue is working!'
  },
  methods: {
    fetchData: function () {
      var xhr = new XMLHttpRequest()
      var self = this
      xhr.open('GET', 'https://osoc-2017-datascouts-akad1070.c9users.io/twitter/q/osoc')
      xhr.onload = function () {
        console.log(xhr.responseText)
        self.items = JSON.parse(xhr.responseText)


      }
      xhr.send()
    },
  test: function(){
    newEntity='working';
    console.log('working');
  }
  }
})
