angular.module('educationApp').controller('SubjectController', function($scope, $http) {
    $scope.init = function () {
        $http({
            url: './getAllSubject',
            method: 'GET',
        })
        .then(function(response) {
            $scope.subjectInfo = response.data;
            $('#subjectModal').modal('hide');
        }, function(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
    }
    $scope.init();
    $scope.showModal = function(param1, param2) {
        switch (param1) {
            case 1:
                $scope.button = "Thêm môn học";
                $scope.edit = -1;
                $scope.subjectName = '';
                $scope.subjectDesc = '';
                break;
            case 2:
                $scope.button = "Sửa môn học";
                $scope.edit = param2;
                $http({
                    url: './getSubject',
                    method: 'GET',
                    params: {
                        'id': param2,
                    },
                })
                .then(function(response) {
                    $scope.subjectName = response.data.name;
                    $scope.subjectDesc = response.data.description;
                }, function(response) {
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                });
                break;
            default:
        }
        $('#subjectModal').modal('show', 300);
    }
    $scope.addSubject = function(param) {
        switch (param) {
            case -1:
                $http({
                    url: './addSubject',
                    method: 'POST',
                    data: {
                        'name': $scope.subjectName,
                        'desc': $scope.subjectDesc,
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
                    url: './addSubject',
                    method: 'POST',
                    data: {
                        'id': param,
                        'name': $scope.subjectName,
                        'desc': $scope.subjectDesc,
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
        if (confirm("Are you sure you want to delete this subject?")) {
            $http({
                url: './deleteSubject',
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