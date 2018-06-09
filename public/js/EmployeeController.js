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
            $.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
        });
        $http({
            url: './getAllTeacher',
            method: 'GET',
        })
        .then(function(response) {
            $scope.teacherInfo = response.data;
            $('#teacherModal').modal('hide');
        }, function(response) {
            $.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
        });
        $http({
            url: './getAllWorker',
            method: 'GET',
        })
        .then(function(response) {
            $scope.workerInfo = response.data;
            $('#workerModal').modal('hide');
        }, function(response) {
            $.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
        });
        $http({
            url: './getAllOffice',
            method: 'GET',
        })
        .then(function(response) {
            $scope.officeInfo = response.data;
        }, function(response) {
            $.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
        });
        $http({
            url: './getAllCourse',
            method: 'GET',
        })
        .then(function(response) {
            $scope.courseInfo = response.data;
        }, function(response) {
            $.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
        });
        $http({
            url: './getAllPosition',
            method: 'GET',
        })
        .then(function(response) {
            $scope.positionInfo = response.data;
        }, function(response) {
            $.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
        });
    }
    $scope.init();

    $scope.changeTable = function() {
        switch ($scope.employeeType) {
            case '0':
                $('#employee_manager_wrapper table').each(function() {
                    $(this).hide();
                });
                $('#employeeTable').show();
                break;
            case '1':
                $('#employee_manager_wrapper table').each(function() {
                    $(this).hide();
                });
                $('#workerTable').show();
                break;
            case '2':
                $('#employee_manager_wrapper table').each(function() {
                    $(this).hide();
                });
                $('#teacherTable').show();
                break;
            case '3':
                break;
            default:
                break;
        }
    }

    $scope.showEmployeeModal = function(param1, param2) {
        switch (param1) {
            case 1:
                $scope.button = "Thêm nhân viên";
                $scope.edit = -1;
                $scope.employeeName = '';
                $scope.employeeAddr = '';
                $scope.employeeMail = '';
                $scope.employeePhone = '';
                $scope.employeeBirthday = '';
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
                }, function(response) {
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                });
                break;
            default:
        }
        $('#employeeModal').modal('show', 300);
    }

    $scope.showWorkerModal = function(param1, param2) {
        $http({
            url: './getEmployeeNotWorker',
            method: 'GET',
        })
        .then(function(response) {
            $scope.listEmployeeInfo = response.data;
        }, function(response) {
            $.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
        });
        switch (param1) {
            case 1:
                $scope.button = "Thêm nhân viên văn phòng";
                $scope.editWorker = -1;
                $scope.workerNameSelected = '';
                $scope.workerOffice = '';
                $scope.workerPosition = '';
                $scope.workerExperience = '';
                $scope.showSelect = true;
                break;
            case 2:
                $scope.button = "Sửa nhân viên văn phòng";
                $scope.editWorker = param2;
                $scope.showSelect = false;
                $http({
                    url: './getWorker',
                    method: 'GET',
                    params: {
                        'id': param2,
                    },
                })
                .then(function(response) {
                    $scope.workerName = response.data[0].name;
                    $scope.workerOffice = response.data[0].officeid + '';
                    $scope.workerPosition = response.data[0].positionid + '';
                    $scope.workerExperience = response.data[0].experience;
                }, function(response) {
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                });
                break;
            default:
        }
        $('#workerModal').modal('show', 300);
    }

    $scope.showTeacherModal = function(param1, param2) {
        $http({
            url: './getEmployeeNotTeacher',
            method: 'GET',
        })
        .then(function(response) {
            $scope.listEmployeeInfo = response.data;
        }, function(response) {
            $.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
        });
        switch (param1) {
            case 1:
                $scope.button = "Thêm giáo viên";
                $scope.editTeacher = -1;
                $scope.teacherNameSelected = '';
                $scope.teacherDegree = '';
                $scope.showSelect = true;
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
                $scope.editTeacher = param2;
                $scope.showSelect = false;
                $http({
                    url: './getTeacher',
                    method: 'GET',
                    params: {
                        'id': param2,
                    },
                })
                .then(function(response) {
                    $scope.teacherDegree = response.data[0].degree;
                    $scope.teacherName = response.data[0].name;
                    if (response.data[0].birthday != null)
                        $scope.teacherBirthday = new Date(response.data[0].birthday);
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
            $check1 = $('#teacherModal .office-wrapper input[type="checkbox"]:checked').length;
            $check2 = $('#teacherModal .course-wrapper input[type="checkbox"]:checked').length;
            if ($check1 > 0 && $check2 > 0)
                $('#teacherModal input[type=submit]').removeAttr('disabled');
            else
                $('#teacherModal input[type=submit]').attr('disabled', 'disabled');
        });
    }

    $scope.addEmployee = function(param) {
        switch (param) {
            case -1:
                $http({
                    url: './addEmployee',
                    method: 'POST',
                    data: {
                        'name': $scope.employeeNameSelected,
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

    $scope.addWorker = function(param) {
        switch (param) {
            case -1:
                $http({
                    url: './addWorker',
                    method: 'POST',
                    data: {
                        'id': $scope.workerNameSelected,
                        'office': $scope.workerOffice,
                        'position': $scope.workerPosition,
                        'experience': $scope.workerExperience,
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
                    url: './addWorker',
                    method: 'POST',
                    data: {
                        'employeeid': param,
                        'office': $scope.workerOffice,
                        'position': $scope.workerPosition,
                        'experience': $scope.workerExperience,
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

    $scope.addTeacher = function(param) {
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
                    url: './addTeacher',
                    method: 'POST',
                    data: {
                        'degree': $scope.teacherDegree,
                        'id': $scope.teacherNameSelected,
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
                    url: './addTeacher',
                    method: 'POST',
                    data: {
                        'employeeid': param,
                        'degree': $scope.teacherDegree,
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
        }
    }

    $scope.deleteEmployee = function(param) {
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

    $scope.deleteWorker = function(param) {
        if (confirm("Are you sure you want to delete this worker?")) {
            $http({
                url: './deleteWorker',
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

    $scope.deleteTeacher = function(param) {
        if (confirm("Are you sure you want to delete this teacher?")) {
            $http({
                url: './deleteTeacher',
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