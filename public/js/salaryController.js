angular.module('educationApp').controller('SalaryController', function($scope, $http) {
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
            $('#salaryTable').show();
        }, function(response) {
            $.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
        });
    }
});