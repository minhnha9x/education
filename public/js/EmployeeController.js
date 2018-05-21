angular.module('educationApp').controller('EmployeeController', function($scope, $http) {
    $scope.init = function () {
        $http({
            url: './getAllEmployee',
            method: 'GET',
        })
        .then(function(response) {
            $scope.employeeInfo = response.data;
            $('#employeeModal').modal('hide');
        }, function(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
    }
    $scope.init();
    $scope.showModal = function(param1, param2) {
        switch (param1) {
            case 1:
                $scope.button = "Thêm nhân viên";
                $scope.edit = -1;
                $scope.employeeName = '';
                $scope.employeeAddr = '';
                $scope.employeeMail = '';
                $scope.employeePhone = '';
                $scope.employeeBirthday = '';
                $scope.officeName = '';
                $scope.Position = '';
                break;
            case 2:
                $scope.button = "Sửa nhân viên";
                $scope.edit = param2;
                $http({
                    url: './getEmployee',
                    method: 'GET',
                    params: {
                        'id': param2,
                    },
                })
                .then(function(response) {
                    $scope.employeeName = response.data[0].name;
                    $scope.employeeAddr = response.data[0].address;
                    $scope.employeeMail = response.data[0].mail;
                    $scope.employeePhone = response.data[0].phone;
                    if (response.data[0].birthday != null)
                        $scope.employeeBirthday = new Date(response.data[0].birthday);
                    $scope.officeName = response.data[0].officeid + '';
                    $scope.Position = response.data[0].positionid + '';
                }, function(response) {
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                });
                break;
            default:
        }
        $http({
            url: './getAllOffice',
            method: 'GET',
        })
        .then(function(response) {
            $scope.officeInfo = response.data;
        }, function(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
        $http({
            url: './getAllPosition',
            method: 'GET',
        })
        .then(function(response) {
            $scope.positionInfo = response.data;
        }, function(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
        $('#employeeModal').modal('show', 300);
    }

    $scope.addEmployee = function(param) {
        switch (param) {
            case -1:
                $http({
                    url: './addEmployee',
                    method: 'POST',
                    data: {
                        'name': $scope.employeeName,
                        'address': $scope.employeeAddr,
                        'phone': $scope.employeePhone,
                        'mail': $scope.employeeMail,
                        'birthday': $scope.employeeBirthday,
                        'position': $scope.Position,
                        'office': $scope.officeName,
                    },
                })
                .then(function(response) {
                    $scope.init();
                    $.toaster(response.data['msg'], '', response.data['type']);
                }, function(response) {
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                });
                break;
            default:
                $http({
                    url: './addEmployee',
                    method: 'POST',
                    data: {
                        'id': param,
                        'name': $scope.employeeName,
                        'address': $scope.employeeAddr,
                        'phone': $scope.employeePhone,
                        'mail': $scope.employeeMail,
                        'birthday': $scope.employeeBirthday,
                        'position': $scope.Position,
                        'office': $scope.officeName,
                    },
                })
                .then(function(response) {
                    $scope.init();
                    $.toaster(response.data['msg'], '', response.data['type']);
                }, function(response) {
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                });
                break;
        }
    }
    $scope.delete = function(param) {
        if (confirm("Are you sure you want to delete this employee?")) {
            $http({
                url: './deleteEmployee',
                method: 'GET',
                params: {
                    'id': param,
                },
            })
            .then(function(response) {
                $scope.init();
                $.toaster(response.data['msg'], '', response.data['type']);
            }, function(response) {
                // called asynchronously if an error occurs
                // or server returns response with an error status.
            });
        }
    }
});