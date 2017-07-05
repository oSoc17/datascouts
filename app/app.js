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
    entities: [
    ],
    vueIsWorking: 'Hurray, Vue is working!'
  },
  methods: {
    fetchData: function(event) {
      console.log("fetching data");
      var self = this;
      self.$http.get('https://osoc-2017-datascouts-akad1070.c9users.io/twitter/q/osoc', function( data ) {
      self.items = data;
      console.log(data);
      });
      this.newEntity = '';
    }
  }
})
