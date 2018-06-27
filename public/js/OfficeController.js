angular.module('educationApp').controller('OfficeController', function($scope, $http, Upload) {
    $scope.init = function () {
        $('#officeModal').modal('hide');
        $('#officeTable').hide();
        $('#menu4 .loading').show();
        $http({
            url: './getAllOffice',
            method: 'GET',
        })
        .then(function(response) {
            $scope.officeInfo = response.data;
            $('#menu4 .loading').hide();
            $('#officeTable').show();
        }, function(response) {
            $.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
        });
    }
    $scope.$on('load-4', function(event, args) {
        $scope.init();
    });
    $scope.showModal = function(param1, param2) {
        switch (param1) {
            case 1:
                $scope.button = "Thêm trung tâm";
                $scope.edit = -1;
                $scope.officeName = '';
                $scope.officeAddr = '';
                $scope.officePhone = '';
                $scope.officeMail = '';
                $scope.picFile = '';
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
                    $scope.officeName = response.data[0].name;
                    $scope.officeAddr = response.data[0].address;
                    $scope.officePhone = response.data[0].phone;
                    $scope.officeMail = response.data[0].mail;
                    $scope.picFile = response.data[0].location;
                }, function(response) {
                    $.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
                });
                break;
            default:
        }
        $('#officeModal').modal('show', 300);
    }

    $scope.addOffice = function(param, param2) {
        switch (param) {
            case -1:
                $http({
                    url: './addOffice',
                    method: 'POST',
                    data: {
                        'name': $scope.officeName,
                        'address': $scope.officeAddr,
                        'phone': $scope.officePhone,
                        'mail': $scope.officeMail,
                        'location': $scope.Googlemap,
                    },
                })
                .then(function(response) {
                    if (param2 != null && param2 != "") {
                        Upload.upload({
                            url: './updateOfficeImg',
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
                    url: './addOffice',
                    method: 'POST',
                    data: {
                        'id': param,
                        'name': $scope.officeName,
                        'address': $scope.officeAddr,
                        'phone': $scope.officePhone,
                        'mail': $scope.officeMail,
                        'location': $scope.Googlemap,
                    },
                })
                .then(function(response) {
                    if (param2 != null && param2 != "") {
                        Upload.upload({
                            url: './updateOfficeImg',
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
          title: "Xóa trung tâm",
          text: "Khi đã xóa trung tâm, các phòng học, các lớp học và đăng ký học của trung tâm đó cũng sẽ bị mất!!!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $http({
                url: './deleteOffice',
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