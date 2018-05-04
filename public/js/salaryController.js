angular.module('educationApp').controller('salaryController', function($scope, $http) {
    $scope.init = function() {
        $('select[name="month"]').attr('ng-init', 'monthSelected="' + new Date().getMonth() + '"');
        $('select[name="year"]').attr('ng-init', 'yearSelected="' + eval(new Date().getYear() + 1900) + '"');
        $data = {month: $scope.monthSelected, 
                year: $scope.yearSelected};
        $http({
            url: './getSalary',
            method: 'GET',
            data: $data,
            headers: {'Content-Type' : 'application/x-www-form-urlencoded'}
        })
        .then(function(response) {
            $scope.salaryInfo = response.data;
        }, function(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
    }
    $scope.init();

    $scope.update = function() {
        $data = {month: $scope.monthSelected, 
                year: $scope.yearSelected};
        $http({
            url: './getSalary',
            method: 'GET',
            data: $data,
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