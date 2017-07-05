(function(){
var mainApp = angular.module('mainApp', []);
var grid = document.querySelector('.grid');

mainApp.controller('homeCtrl',['$scope',function($scope){

  $scope.filtersList = [
    {
      name: "twitter",
      active: true,
      thumb: "content/img/twitter.png"
    }
  ];

  $scope.entities = [
    {
      name: "test",
      active: true
    }
  ];

  $scope.addEntity = function(){
    $scope.entities.push({
      name: $scope.newEntity.name,
      active: true
    });

    $scope.newEntity.name = "";
  }

  $scope.handles = [
    {
      data:"test"
    },
    {
      data:"test"
    },
    {
      data:"test"
    },
    {
      data:"test"
    },
    {
      data:"test"
    }
  ];

  console.log(grid);

  //waterfall(grid);

}]);
})();
