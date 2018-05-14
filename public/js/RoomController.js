angular.module('educationApp').controller('RoomController', function($scope, $http) {
    $scope.init = function () {
        $http({
            url: './getAllRoom',
            method: 'GET',
        })
        .then(function(response) {
            $scope.roomInfo = response.data;
            $('#roomModal').modal('hide');
        }, function(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
        $http({
            url: './getAllCourse',
            method: 'GET',
        })
        .then(function(response) {
            $scope.courseInfo = response.data;
        }, function(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
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
    }
    $scope.init();
    $scope.showModal = function(param1, param2) {
        switch (param1) {
            case 1:
                $scope.button = "Thêm phòng học";
                $scope.edit = -1;
                $scope.officeName = '';
                $scope.roomLimit = '';
                $('#roomModal .checkbox-wrapper input[type="checkbox"]').each(function(){
                    $(this).removeAttr('checked');
                });
                break;
            case 2:
                $scope.button = "Sửa phòng học";
                $scope.edit = param2;
                $('#roomModal .checkbox-wrapper input[type="checkbox"]').each(function(){
                    $(this).removeAttr('checked');
                });
                $http({
                    url: './getRoom',
                    method: 'GET',
                    params: {
                        'id': param2,
                    },
                })
                .then(function(response) {
                    $scope.officeName = response.data[0].office + "";
                    $scope.roomLimit = response.data[0].max_student;
                    for (var i=0; i < response.data[0].course.length; i++) {
                        $('#roomModal .checkbox-wrapper input[type="checkbox"][value="' + response.data[0].course[i] + '"]').attr('checked', 'checked');
                    }
                }, function(response) {
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                });
                break;
            default:
        }
        $('#roomModal').modal('show', 300);
    }

    $scope.addRoom = function(param) {
        $scope.courseList = [];
        $('#roomModal .checkbox-wrapper input[type="checkbox"]:checked').each(function(){
            $scope.courseList.push(
                $(this).val()
            );
        });
        switch (param) {
            case -1:
                $http({
                    url: './addRoom',
                    method: 'POST',
                    params: {
                        'office': $scope.officeName,
                        'max_student': $scope.roomLimit,
                        'course': $scope.courseList,
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
                    url: './addRoom',
                    method: 'POST',
                    params: {
                        'id': param,
                        'office': $scope.officeName,
                        'max_student': $scope.roomLimit,
                        'course': $scope.courseList,
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
        if (confirm("Are you sure you want to delete this room?")) {
            $http({
                url: './deleteRoom',
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