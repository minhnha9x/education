angular.module('educationApp').controller('EmployeeController', function($scope, $http) {
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
    
    $scope.init = function () {
        $('#employeeModal').modal('hide');
        $('#teacherModal').modal('hide');
        $('#taModal').modal('hide');
        $('#workerModal').modal('hide');
        $('#employee_manager_wrapper table').each(function() {
            $(this).hide();
        });
        $('#menu6 .loading').show();
        $http({
            url: './getAllEmployee',
            method: 'GET',
        })
        .then(function(response) {
            $scope.employeeInfo = response.data;
            $('#menu6 .loading').hide();
            $scope.changeTable();
        }, function(response) {
            $.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
        });
        $http({
            url: './getAllTeacher',
            method: 'GET',
        })
        .then(function(response) {
            $scope.teacherInfo = response.data;
            $('#menu6 .loading').hide();
            $scope.changeTable();
        }, function(response) {
            $.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
        });
        $http({
            url: './getAllTA',
            method: 'GET',
        })
        .then(function(response) {
            $scope.TAInfo = response.data;
            $('#menu6 .loading').hide();
            $scope.changeTable();
        }, function(response) {
            $.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
        });
        $http({
            url: './getAllWorker',
            method: 'GET',
        })
        .then(function(response) {
            $scope.workerInfo = response.data;
            $('#menu6 .loading').hide();
            $scope.changeTable();
        }, function(response) {
            $.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
        });
    }

    $scope.$on('load-6', function(event, args) {
        if ($scope.employeeInfo == null)
            $scope.init();
    });

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
                $('#employee_manager_wrapper table').each(function() {
                    $(this).hide();
                });
                $('#taTable').show();
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
                $('#teacherModal .office-wrapper input[type="checkbox"]').each(function(){
                    $(this).removeAttr('checked');
                });
                $('#teacherModal .course-wrapper input[type="checkbox"]').each(function(){
                    $(this).removeAttr('checked');
                });
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
                    if (response.data[0].office != null)
                        for (var i=0; i < response.data[0].office.length; i++) {
                            $('#teacherModal .office-wrapper input[type="checkbox"][value="' + response.data[0].office[i] + '"]').attr('checked', 'checked');
                        }
                    if (response.data[0].course != null)
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

    $scope.showTAModal = function(param1, param2) {
        $http({
            url: './getEmployeeNotTA',
            method: 'GET',
        })
        .then(function(response) {
            $scope.listEmployeeInfo = response.data;
        }, function(response) {
            $.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
        });
        switch (param1) {
            case 1:
                $scope.button = "Thêm trợ giảng";
                $scope.editTA = -1;
                $scope.taNameSelected = '';
                $scope.taDegree = '';
                $scope.showSelect = true;
                $('#taModal .office-wrapper input[type="checkbox"]').each(function(){
                    $(this).removeAttr('checked');
                });
                $('#taModal .course-wrapper input[type="checkbox"]').each(function(){
                    $(this).removeAttr('checked');
                });
                $('#taModal input[type=submit]').attr('disabled', 'disabled');
                break;
            case 2:
                $scope.button = "Sửa trợ giảng";
                $scope.editTA = param2;
                $scope.showSelect = false;
                $('#taModal .office-wrapper input[type="checkbox"]').each(function(){
                    $(this).removeAttr('checked');
                });
                $('#taModal .course-wrapper input[type="checkbox"]').each(function(){
                    $(this).removeAttr('checked');
                });
                $http({
                    url: './getTA',
                    method: 'GET',
                    params: {
                        'id': param2,
                    },
                })
                .then(function(response) {
                    $scope.taDegree = response.data[0].degree;
                    $scope.taName = response.data[0].name;
                    if (response.data[0].office != null)
                        for (var i=0; i < response.data[0].office.length; i++) {
                            $('#taModal .office-wrapper input[type="checkbox"][value="' + response.data[0].office[i] + '"]').attr('checked', 'checked');
                        }
                    if (response.data[0].course != null)
                        for (var i=0; i < response.data[0].course.length; i++) {
                            $('#taModal .course-wrapper input[type="checkbox"][value="' + response.data[0].course[i] + '"]').attr('checked', 'checked');
                        }
                    $('#taModal input[type=submit]').removeAttr('disabled');
                }, function(response) {
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                });
                break;
            default:
        }
        $('#taModal').modal('show', 300);
        $('#taModal input[type=checkbox]').change(function() {
            $check1 = $('#taModal .office-wrapper input[type="checkbox"]:checked').length;
            $check2 = $('#taModal .course-wrapper input[type="checkbox"]:checked').length;
            if ($check1 > 0 && $check2 > 0)
                $('#taModal input[type=submit]').removeAttr('disabled');
            else
                $('#taModal input[type=submit]').attr('disabled', 'disabled');
        });
    }

    $scope.addEmployee = function(param) {
        switch (param) {
            case -1:
                console.log("hoho", $scope.employeeNameSelected);
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
                console.log("asdad", $scope.employeeName);
                $http({
                    url: './addEmployee',
                    method: 'POST',
                    data: {
                        'id': param,
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

    $scope.addTA = function(param) {
        $scope.courseList = [];
        $scope.courseDelList = [];
        $scope.officeList = [];
        $scope.officeDelList = [];
        $('#taModal .course-wrapper input[type="checkbox"]:checked').each(function(){
            $scope.courseList.push($(this).val());
        });
        $('#taModal .course-wrapper input[type="checkbox"]:not(:checked)').each(function(){
            $scope.courseDelList.push($(this).val());
        });
        $('#taModal .office-wrapper input[type="checkbox"]:checked').each(function(){
            $scope.officeList.push($(this).val());
        });
        $('#taModal .office-wrapper input[type="checkbox"]:not(:checked)').each(function(){
            $scope.officeDelList.push($(this).val());
        });
        switch (param) {
            case -1:
                $http({
                    url: './addTA',
                    method: 'POST',
                    data: {
                        'degree': $scope.taDegree,
                        'id': $scope.taNameSelected,
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
                    url: './addTA',
                    method: 'POST',
                    data: {
                        'employeeid': param,
                        'degree': $scope.taDegree,
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
        swal({
          title: "Xóa nhân viên",
          text: "Hành động sẽ xóa toàn bộ thông tin của nhân viên này, bạn có chắc không!!!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
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
        });
    }

    $scope.deleteWorker = function(param) {
        swal({
          title: "Xóa nhân viên văn phòng",
          text: "Hành động này sẽ chỉ xóa thông tin làm việc của nhân viên văn phòng, thông tin cá nhân của nhân viên vẫn sẽ an toàn!!!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
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
        });
    }

    $scope.deleteTeacher = function(param) {
        swal({
          title: "Xóa giáo viên",
          text: "Hành động này sẽ chỉ xóa thông tin giảng dạy của giáo viên, thông tin nhân viên vẫn sẽ an toàn!!!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
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
        });
    }

    $scope.deleteTA = function(param) {
        swal({
          title: "Xóa trợ giảng",
          text: "Hành động này sẽ chỉ xóa thông tin giảng dạy của trợ giảng, thông tin nhân viên vẫn sẽ an toàn!!!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $http({
                url: './deleteTA',
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
        });
    }
});