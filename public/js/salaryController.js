angular.module('educationApp').controller('salaryController', function($scope, $http) {
    $scope.update = function() {
        if (!($scope.monthSelected && $scope.yearSelected)) {
            return;
        }
        $http({
            url: './getSalary',
            method: 'GET',
            params: {'month': $scope.monthSelected, 'year': $scope.yearSelected},
            headers: {'Content-Type' : 'application/x-www-form-urlencoded'}
        })
        .then(function(response) {
            $scope.salaryInfo = response.data;
        }, function(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
    }
});