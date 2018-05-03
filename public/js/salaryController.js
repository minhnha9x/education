angular.module('educationApp').controller('salaryController', function($scope, $http) {
    $scope.init = function() {
        $http.get('./getSalary').
          then(function(response) {
            console.log(response.data);
            $scope.salaryInfo = response.data;
          }, function(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
          });
    }
    $scope.init();
});