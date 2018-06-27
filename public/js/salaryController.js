angular.module('educationApp').controller('SalaryController', function($scope, $http) {
    $scope.init = function () {
        $('#positionModal').modal('hide');
        $('#positionTable').hide();
        $('#menu7 .loading').show();
        $http({
            url: './getAllPosition',
            method: 'GET',
        })
        .then(function(response) {
            $scope.positionInfo = response.data;
            $('#menu7 .loading').hide();
            $('#positionTable').show();
        }, function(response) {
            $.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
        });
    }
    $scope.$on('load-7', function(event, args) {
        $scope.init();
    });

    $scope.showModal = function(param1, param2) {
        switch (param1) {
            case 1:
                $scope.button = "Thêm chức vụ";
                $scope.edit = -1;
                $scope.positionName = '';
                $scope.positionSalary = '';
                $scope.positionUnit = '';
                break;
            case 2:
                $scope.button = "Sửa chức vụ";
                $scope.edit = param2;
                $http({
                    url: './getPosition',
                    method: 'GET',
                    params: {
                        'id': param2,
                    },
                })
                .then(function(response) {
                    $scope.positionName = response.data[0].name;
                    $scope.positionSalary = response.data[0].salary;
                    $scope.positionUnit = response.data[0].unit;
                }, function(response) {
                    $.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
                });
                break;
            default:
        }
        $('#positionModal').modal('show', 300);
    }

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