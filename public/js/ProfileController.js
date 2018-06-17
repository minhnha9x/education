angular.module('educationApp').controller('ProfileController', function($scope, $http, Upload) {
    $scope.scopeList = {};

    $http({
        url: './getSlot',
        method: 'GET',
    })
    .then(function(response) {
        $scope.allslot = response.data;
    });

    $scope.upload = function (file) {
        Upload.upload({
            url: './updateAvatar',
            data: {
                file: file
            }
        }).then(function (resp) {
            location.reload();
        }, function (resp) {
            console.log('Error status: ' + resp.status);
        }, function (evt) {
            var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
            console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
        });
    };

    $scope.expandScore = function(class_id, isShow) {
        if (isShow) {
            $http({
                url: './getscorelist',
                method: 'GET',
                params: {
                    'class_id': class_id,
                },
            })
            .then(function(response) {
                $scope.scopeList[class_id] = response.data;
            });
        }
    }

    $scope.updateScore = function(class_id) {
        $scope.scopeList[class_id].status = true;
        $http({
            url: './updatescorelist',
            method: 'POST',
            data: {
                'data': $scope.scopeList[class_id],
            },
        })
        .then(function(response) {
            $scope.scopeList[class_id].status = false;
        });
    }

    $scope.updatePassword = function(param) {
        $http({
            url: './updatePassword',
            method: 'POST',
            data: {
                'id': param,
                'old': $scope.oldPassword,
                'new': $scope.newPassword,
                'confirm': $scope.confirmPassword,
            },
        })
        .then(function(response) {
            $('.profile-modal .error').text('');
            if (response.data['type'] == "error")
                $('#update_password .error').text(response.data['msg']);
            else {
                $('#update_password').modal('hide');
                $.toaster(response.data['msg'], '', response.data['type']);
            }
        });
    }

    $scope.showDayoffModal = function(param, param2, param3) {
        $temp = {"Monday" : 1, "Tuesday" : 2, "Wednesday" : 3, "Thursday" : 4, "Friday" : 5,  "Saturday" : 6, "Sunday" : 7};

        $scope.slot = param2;
        $date = param3;
        $check = false;

        $http({
            url: './getTeacherSchedule',
            method: 'GET',
            param: {
                'id': param,
            },
        })
        .then(function(response) {
            $scope.tschedule = response.data;
            $http({
                url: './getTASchedule',
                method: 'GET',
                param: {
                    'id': param,
                },
            })
            .then(function(response) {
                $scope.taschedule = response.data;

                $scope.allschedule = $.merge($scope.tschedule, $scope.taschedule);
                
                $.each($scope.allschedule, function(i, item) {
                if ($temp[$scope.allschedule[i]['current_date']] == $date && $scope.allschedule[i]['schedule'] == $scope.slot)
                {
                    $today = new Date();

                    $formattedDate = new Date($scope.allschedule[i]['start_date']);
                    $sd = $formattedDate.getDate();
                    $sm = $formattedDate.getMonth() + 1;
                    $sy = $formattedDate.getFullYear();

                    $firstweekdays = ($formattedDate.getDay() == 0 ? 1 : 7 - $formattedDate.getDay() + 1);

                    $diff = new Date($today - $formattedDate);
                    $currentweek = Math.floor($diff/1000/60/60/24/7) + 1;

                    $formattedDate2 = new Date($scope.allschedule[i]['end_date']);

                    $diff2 = new Date($formattedDate2 - $formattedDate);
                    $diff2 = $diff2/1000/60/60/24;

                    $lastweekdays = ($diff2 - $firstweekdays) % 7 ;

                    $totalweek = 1 + Math.floor(($diff2 - $firstweekdays) / 7 ) + ($lastweekdays == 0 ? 0 : 1);

                    $scope.office = $scope.allschedule[i]['name'];
                    $scope.officeid = $scope.allschedule[i]['office'];
                    $course = $scope.allschedule[i]['course'];
                    $scope.courseid = $scope.allschedule[i]['courseid'];
                    $room = $scope.allschedule[i]['room'];
                    $scope.class = $scope.allschedule[i]['class'];
                    $scope.date = $scope.allschedule[i]['current_date'];
                    $scope.start_time = $scope.allslot[$scope.slot]['start_time'];
                    $scope.end_time = $scope.allslot[$scope.slot]['end_time'];
                    $check = true;
                    $scope.room_schedule = $scope.allschedule[i]['room_schedule'];
                    return;
                }
            });
            if ($check) {
                $scope.newdate = new Date($today);
                $scope.newdate.setDate($scope.newdate.getDate()  - ($today.getDay() == 0 ? 6 : $today.getDay() - 1));
                $scope.newdate2 = new Date($scope.newdate);
                $scope.newdate2.setDate($scope.newdate2.getDate() + 6);
                $('#teaching_backup').find('select[name="week"] option:not(:first-child)').remove();
                $('#teaching_backup').find('select[name="teacher"] option:not(:first-child)').remove();

                $scope.listWeek = [];
                for (var i = 1; i <= $totalweek; i ++) {
                    if (i == 1) {
                        $newdate = new Date($formattedDate);
                        $newdate2 = new Date($formattedDate);
                        $newdate2.setDate($newdate.getDate() + $firstweekdays - 1);
                        $newdate3 = new Date($formattedDate);
                        $newdate3.setDate($newdate.getDate()  - (7 - $firstweekdays) + $temp[$scope.date] - 1);
                    }
                    else if (i != $totalweek) {
                            $newdate = new Date($newdate2);
                            $newdate.setDate($newdate.getDate() + 1);
                            $newdate2 = new Date($newdate);
                            $newdate2.setDate($newdate2.getDate() + 6);
                            $newdate3 = new Date($newdate);
                            $newdate3.setDate($newdate.getDate() + $temp[$scope.date] - 1);
                        }
                        else {
                            $newdate = new Date($newdate2);
                            $newdate.setDate($newdate.getDate() + 1);
                            $newdate2 = new Date($newdate);
                            $newdate2.setDate($newdate2.getDate() + $lastweekdays);
                            $newdate3 = new Date($newdate);
                            $newdate3.setDate($newdate.getDate() + $temp[$scope.date] - 1);
                        }
                    if ($today <= $newdate3)
                    {
                        $scope.listWeek.push({
                            'date': $newdate3,
                            'week': i,
                            'start': $newdate,
                            'end': $newdate2,
                        });
                    }
                }
                $('#teaching_backup').modal('show', 300);
            }
            });
        });

    }

    $scope.addTeacherDayoff = function() {
        $http({
            url: './addteacherdayoff',
            method: 'POST',
            data : {
                week: $scope.weekSelected,
                teacher: $scope.teacherSelected,
                room_schedule: $scope.room_schedule,
            },
        })
        .then(function(response) {
            location.reload();
        });
    }

    $scope.updateTeacher = function() {
        $http({
            url: './getlistfreeteacher2',
            method: 'POST',
            data : {
                date: $scope.weekSelected,
                office: $scope.officeid,
                slot: $scope.slot,
                course: $scope.courseid,
            },
        })
        .then(function(response) {
            $scope.listTeacher = response.data;
        });
    }
});