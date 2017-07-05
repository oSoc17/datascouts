(function(){
var mainApp = angular.module('mainApp', []);
var grid = document.querySelector('.grid');
var url = "https://osoc-2017-datascouts-akad1070.c9users.io/twitter/q/";

mainApp.controller('homeCtrl',['$scope','$http', function($scope, $http){

  $scope.myData = [
    {a : 'b'}
  ];


  $scope.filtersList = [
    {
      name: "Twitter",
      active: true,
      thumb: "content/img/twitter.png"
    },
    {
      name: "Facebook",
      active: true,
      thumb: "content/img/twitter.png"
    }
  ];

  $scope.entities = [{}];

  $scope.addEntity = function(){

    /*$scope.entities.push({
      name: $scope.newEntity.name,
      active: true,

    });*/



    //$scope.newEntity.name = "";
}
//https://osoc-2017-datascouts-akad1070.c9users.io/twitter/q/ananas
//https://jsonplaceholder.typicode.com/posts

$http.get(url+"osoc")
.then(function(response) {

      $scope.myData = response.data;
console.log($scope.myData);
  });


  //console.log(grid);

  //waterfall(grid);

}]);
})();
