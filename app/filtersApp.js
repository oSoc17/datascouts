var filtersApp = angular.module('filtersApp', []);

filtersApp.controller('filtersCtrl',['$scope',function($scope){

  $scope.filtersList = [
    {
      name: "twitter",
      active: true,
      thumb: "content/img/twitter.png"
    }
  ];

  $scope.entities = [
    {

    }
  ];



}]);
