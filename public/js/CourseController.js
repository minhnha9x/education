angular.module('educationApp').controller('CourseController', function($scope, $http) {
    $scope.init = function () {
        $http({
            url: './getAllCourse',
            method: 'GET',
        })
        .then(function(response) {
            $scope.courseInfo = response.data;
            $('#courseModal').modal('hide');
        }, function(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
    }
    $scope.init();
    $scope.showModal = function(param1, param2) {
        switch (param1) {
            case 1:
                $scope.button = "Thêm khóa học";
                $scope.edit = -1;
                $scope.courseName = '';
                $scope.courseDesc = '';
                $scope.coursePrice = '';
                $scope.total_of_period = '';
                $scope.certificate_required = '';
                $scope.subjectName = '';
                break;
            case 2:
                $scope.button = "Sửa khóa học";
                $scope.edit = param2;
                $http({
                    url: './getCourse',
                    method: 'GET',
                    params: {
                        'id': param2,
                    },
                })
                .then(function(response) {
                    console.log(response.data[0]);
                    $scope.courseName = response.data[0].name;
                    $scope.courseDesc = response.data[0].description;
                    $scope.coursePrice = response.data[0].price;
                    $scope.total_of_period = response.data[0].total_of_period;
                    if (response.data[0].certificate_required != null)
                        $scope.certificate_required = response.data[0].certificate_required + "";
                    else
                        $scope.certificate_required = "";
                    $scope.subjectName = response.data[0].subjectid + "";
                }, function(response) {
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                });
                break;
            default:
        }
        $http({
            url: './getAllSubject',
            method: 'GET',
        })
        .then(function(response) {
            $scope.subjectInfo = response.data;
        }, function(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
        $http({
            url: './getAllCourse',
            method: 'GET',
        })
        .then(function(response) {
            $scope.courseList = response.data;
        }, function(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
        $('#courseModal').modal('show', 300);
    }

    $scope.updateCourseList = function(param) {
        $http({
            url: './getCourseFromSub',
            method: 'GET',
            params: {
                'id': param,
            },
        })
        .then(function(response) {
            $scope.courseList = response.data;
        }, function(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
    }

    $scope.addCourse = function(param) {
        switch (param) {
            case -1:
                $http({
                    url: './addCourse',
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
                    $.toaster(response.data['msg'], '', response.data['type']);
                }, function(response) {
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                });
                break;
            default:
                $http({
                    url: './addCourse',
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
                    $.toaster(response.data['msg'], '', response.data['type']);
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
                url: './deleteCourse',
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