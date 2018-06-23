angular.module('educationApp').controller('RoomController', function($scope, $http) {
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
        url: './getAllOffice',
        method: 'GET',
    })
    .then(function(response) {
        $scope.officeInfo = response.data;
    }, function(response) {
        $.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
    });

    $scope.init = function () {
        $('#roomModal').modal('hide');
        $('#roomTable').hide();
        $('#menu5 .loading').show();
        $http({
            url: './getAllRoom',
            method: 'GET',
        })
        .then(function(response) {
            $scope.roomInfo = response.data;
            $('#menu5 .loading').hide();
            $('#roomTable').show();
        }, function(response) {
            $.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
        });
    }

    $scope.$on('load-5', function(event, args) {
        if ($scope.roomInfo == null)
            $scope.init();
    });

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
                $('#roomModal input[type=submit]').attr('disabled', 'disabled');
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
                    $.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
                });
                break;
            default:
        }
        $('#roomModal').modal('show', 300);
        $('#roomModal input[type=checkbox]').change(function() {
            $check = false;
            $('#roomModal .checkbox-wrapper input[type="checkbox"]:checked').each(function(){
                $check = true;
            });
            if ($check)
                $('#roomModal input[type=submit]').removeAttr('disabled');
            else
                $('#roomModal input[type=submit]').attr('disabled', 'disabled');
        });
    }

    $scope.addRoom = function(param) {
        $scope.courseList = [];
        $scope.courseDelList = [];
        $('#roomModal .checkbox-wrapper input[type="checkbox"]:checked').each(function(){
            $scope.courseList.push($(this).val());
        });
        $('#roomModal .checkbox-wrapper input[type="checkbox"]:not(:checked)').each(function(){
            $scope.courseDelList.push($(this).val());
        });
        switch (param) {
            case -1:
                $http({
                    url: './addRoom',
                    method: 'POST',
                    data: {
                        'office': $scope.officeName,
                        'max_student': $scope.roomLimit,
                        'course': $scope.courseList,
                        'coursedel': $scope.courseDelList,
                    },
                })
                .then(function(response) {
                    $scope.init();
                    $.toaster(response.data['msg'], '', response.data['type']);
                }, function(response) {
                    $.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
                });
                break;
            default:
                $http({
                    url: './addRoom',
                    method: 'POST',
                    data: {
                        'id': param,
                        'office': $scope.officeName,
                        'max_student': $scope.roomLimit,
                        'course': $scope.courseList,
                        'coursedel': $scope.courseDelList,
                    },
                })
                .then(function(response) {
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
          title: "Xóa phòng học",
          text: "Khi đã xóa phòng học, các lớp học liên quan cũng sẽ bị xóa!!!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $http({
                url: './deleteRoom',
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