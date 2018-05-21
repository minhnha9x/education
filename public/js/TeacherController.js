angular.module('educationApp').controller('TeacherController', function($scope, $http) {
    $scope.init = function () {
        $http({
            url: './getAllTeacher',
            method: 'GET',
        })
        .then(function(response) {
            $scope.teacherInfo = response.data;
            $('#teacherModal').modal('hide');
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
    }
    $scope.init();
    $scope.showModal = function(param1, param2) {
        switch (param1) {
            case 1:
                $scope.button = "Thêm giáo viên";
                $scope.edit = -1;
                $scope.teacherName = '';
                $scope.teacherMail = '';
                $scope.teacherLevel = '';
                $scope.officeName = '';
                $scope.showPassword = false;
                $('#teacherModal .office-wrapper input[type="checkbox"]').each(function(){
                    $(this).removeAttr('checked');
                });
                $('#teacherModal .course-wrapper input[type="checkbox"]').each(function(){
                    $(this).removeAttr('checked');
                });
                $('#teacherModal input[type=submit]').attr('disabled', 'disabled');
                break;
            case 2:
                $scope.button = "Sửa giáo viên";
                $scope.edit = param2;
                $http({
                    url: './getTeacher',
                    method: 'GET',
                    params: {
                        'id': param2,
                    },
                })
                .then(function(response) {
                    $scope.teacherName = response.data[0].name;
                    $scope.teacherMail = response.data[0].mail;
                    $scope.teacherLevel = response.data[0].degree;
                    $scope.officeName = response.data[0].officeid + '';
                    $scope.showPassword = true;
                    for (var i=0; i < response.data[0].office.length; i++) {
                        $('#teacherModal .office-wrapper input[type="checkbox"][value="' + response.data[0].office[i] + '"]').attr('checked', 'checked');
                    }
                    for (var i=0; i < response.data[0].course.length; i++) {
                        $('#teacherModal .course-wrapper input[type="checkbox"][value="' + response.data[0].course[i] + '"]').attr('checked', 'checked');
                    }
                    $('#teacherModal input[type=submit]').removeAttr('disabled');
                }, function(response) {
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                });
                break;
            default:
        }
        $('#teacherModal').modal('show', 300);
        $('#teacherModal input[type=checkbox]').change(function() {
            $check1 = false;
            $check2 = false;
            $('#teacherModal .office-wrapper input[type="checkbox"]:checked').each(function(){
                $check1 = true;
            });
            $('#teacherModal .course-wrapper input[type="checkbox"]:checked').each(function(){
                $check2 = true;
            });
            if ($check1 && $check2)
                $('#teacherModal input[type=submit]').removeAttr('disabled');
            else
                $('#teacherModal input[type=submit]').attr('disabled', 'disabled');
        });
    }

    $scope.addteacher = function(param) {
        $scope.courseList = [];
        $scope.courseDelList = [];
        $scope.officeList = [];
        $scope.officeDelList = [];
        $('#teacherModal .course-wrapper input[type="checkbox"]:checked').each(function(){
            $scope.courseList.push($(this).val());
        });
        $('#teacherModal .course-wrapper input[type="checkbox"]:not(:checked)').each(function(){
            $scope.courseDelList.push($(this).val());
        });
        $('#teacherModal .office-wrapper input[type="checkbox"]:checked').each(function(){
            $scope.officeList.push($(this).val());
        });
        $('#teacherModal .office-wrapper input[type="checkbox"]:not(:checked)').each(function(){
            $scope.officeDelList.push($(this).val());
        });
        switch (param) {
            case -1:
                $http({
                    url: './addteacher',
                    method: 'POST',
                    data: {
                        'name': $scope.teacherName,
                        'mail': $scope.teacherMail,
                        'degree': $scope.teacherLevel,
                        'course': $scope.courseList,
                        'coursedel': $scope.courseDelList,
                        'office': $scope.officeList,
                        'officedel': $scope.officeDelList,
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
                    url: './addteacher',
                    method: 'POST',
                    data: {
                        'id': param,
                        'name': $scope.teacherName,
                        'address': $scope.teacherAddr,
                        'phone': $scope.teacherPhone,
                        'mail': $scope.teacherMail,
                        'birthday': $scope.teacherBirthday,
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
        if (confirm("Are you sure you want to delete this teacher?")) {
            $http({
                url: './deleteteacher',
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