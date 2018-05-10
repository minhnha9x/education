angular.module('educationApp').controller('OfficeController', function($scope, $http) {
    $scope.init = function () {
        $http({
            url: './getAllOffice',
            method: 'GET',
        })
        .then(function(response) {
            console.log(response.data);
            $scope.officeInfo = response.data;
            $('#officeModal').modal('hide');
        }, function(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
    }
    $scope.init();
    $scope.showModal = function(param1, param2) {
        switch (param1) {
            case 1:
                $scope.button = "Thêm trung tâm";
                $scope.edit = -1;
                $scope.officeName = '';
                $scope.officeAddr = '';
                $scope.officePhone = '';
                $scope.officeMail = '';
                $scope.Googlemap = '';
                break;
            case 2:
                $scope.button = "Sửa trung tâm";
                $scope.edit = param2;
                $http({
                    url: './getOffice',
                    method: 'GET',
                    params: {
                        'id': param2,
                    },
                })
                .then(function(response) {
                    console.log(response.data[0]);
                    $scope.officeName = response.data[0].name;
                    $scope.officeAddr = response.data[0].address;
                    $scope.officePhone = response.data[0].phone;
                    $scope.officeMail = response.data[0].mail;
                    $scope.Googlemap = response.data[0].location;
                }, function(response) {
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                });
                break;
            default:
        }
        $('#officeModal').modal('show', 300);
    }

    $scope.addOffice = function(param) {
        switch (param) {
            case -1:
                $http({
                    url: './addOffice',
                    method: 'POST',
                    params: {
                        'name': $scope.officeName,
                        'address': $scope.officeAddr,
                        'phone': $scope.officePhone,
                        'mail': $scope.officeMail,
                        'location': $scope.Googlemap,
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
                    url: './addOffice',
                    method: 'POST',
                    params: {
                        'id': param,
                        'name': $scope.officeName,
                        'address': $scope.officeAddr,
                        'phone': $scope.officePhone,
                        'mail': $scope.officeMail,
                        'location': $scope.Googlemap,
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
        if (confirm("Are you sure you want to delete this office?")) {
            $http({
                url: './deleteOffice',
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