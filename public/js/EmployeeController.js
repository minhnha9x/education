angular.module('educationApp').controller('EmployeeController', function($scope, $http) {
    $scope.init = function () {
        $http({
            url: './getAllEmployee',
            method: 'GET',
        })
        .then(function(response) {
            console.log(response.data);
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
                $scope.officeName = '';
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
                    $scope.employeeBirthday = response.data[0].phone;
                    $scope.officeName = response.data[0].officeid + '';
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
        $('#employeeModal').modal('show', 300);
    }

    $scope.addEmployee = function(param) {
        switch (param) {
            case -1:
                $http({
                    url: './addEmployee',
                    method: 'POST',
                    data: {
                        'name': $scope.courseName,
                        'description': $scope.courseDesc,
                        'price': $scope.coursePrice,
                        'total_of_period': $scope.total_of_period,
                        'subject': $scope.subjectName,
                        'certificate_required': $scope.certificate_required,
                    },
                })
                .then(function(response) {
                    $scope.init();
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
                        'name': $scope.courseName,
                        'description': $scope.courseDesc,
                        'price': $scope.coursePrice,
                        'total_of_period': $scope.total_of_period,
                        'subject': $scope.subjectName,
                        'certificate_required': $scope.certificate_required,
                    },
                })
                .then(function(response) {
                    $scope.init();
                }, function(response) {
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                });
                break;
        }
    }
    $scope.delete = function(param) {
        if (confirm("Are you sure you want to delete this course?")) {
            $http({
                url: './deleteEmployee',
                method: 'GET',
                params: {
                    'id': param,
                },
            })
            .then(function(response) {
                $scope.init();
            }, function(response) {
                // called asynchronously if an error occurs
                // or server returns response with an error status.
            });
        }
    }
});