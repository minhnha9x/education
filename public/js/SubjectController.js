angular.module('educationApp').controller('SubjectController', function($scope, $http, Upload) {
    $scope.init = function () {
        $http({
            url: './getAllSubject',
            method: 'GET',
        })
        .then(function(response) {
            $scope.subjectInfo = response.data;
            $('#subjectModal').modal('hide');
        }, function(response) {
            $.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
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
                $scope.picFile = '';
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
                    $scope.picFile = response.data.img;
                }, function(response) {
                    $.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
                });
                break;
            default:
        }
        $('#subjectModal').modal('show', 300);
    }
    $scope.addSubject = function(param, param2) {
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
                    if (param2 != null && param2 != "") {
                        Upload.upload({
                            url: './updateSubjectImg',
                            data: {
                                id: response.data['id'],
                                file: param2,
                            }
                        }).then(function (resp) {
                            //location.reload();
                        }, function (resp) {
                            console.log('Error status: ' + resp.status);
                        }, function (evt) {
                            var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                            console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
                        });
                    }
                    $scope.init();
                    $.toaster(response.data['msg'], '', response.data['type']);
                }, function(response) {
                    $.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
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
                    if (param2 != null && param2 != "") {
                        Upload.upload({
                            url: './updateSubjectImg',
                            data: {
                                id: param,
                                file: param2,
                            }
                        }).then(function (resp) {
                            //location.reload();
                        }, function (resp) {
                            console.log('Error status: ' + resp.status);
                        }, function (evt) {
                            var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                            console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
                        });
                    }
                    $scope.init();
                    $.toaster(response.data['msg'], '', response.data['type']);
                }, function(response) {
                    $.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
                });
                break;
        }
    }
    $scope.delete = function(param) {
        swal({
          title: "Xóa môn học",
          text: "Khi đã xóa môn học, các khóa học, lớp học, đăng ký học của môn học cũng sẽ bị mất!!!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
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
                $.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
            });
          }
        });
    }
});