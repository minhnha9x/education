angular.module('educationApp').controller('PromotionController', function($scope, $http) {
    $scope.init = function () {
        $('#promotionModal').modal('hide');
        $('#promotionTable').hide();
        $('#menu8 .loading').show();
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
            url: './getAllPromotion',
            method: 'GET',
        })
        .then(function(response) {
            $scope.promotionInfo = response.data;
            $('#menu8 .loading').hide();
            $('#promotionTable').show();
        }, function(response) {
            $.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
        });
    }

    $scope.$on('load-8', function(event, args) {
        if ($scope.promotionInfo == null)
            $scope.init();
    });
    $scope.showModal = function(param1, param2) {
        switch (param1) {
            case 1:
                $scope.button = "Thêm mã giảm giá";
                $scope.edit = -1;
                $scope.promotionCode = '';
                $scope.promotionBenefit = '';
                break;
            case 2:
                $scope.button = "Sửa mã giảm giá";
                $scope.edit = param2;
                $http({
                    url: './getPromotion',
                    method: 'GET',
                    params: {
                        'code': param2,
                    },
                })
                .then(function(response) {
                    $scope.promotionCode = response.data[0].code;
                    $scope.promotionBenefit = response.data[0].benefit;
                    $scope.courseName = response.data[0].course + '';
                }, function(response) {
                    $.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
                });
                break;
            default:
        }
        $('#promotionModal').modal('show', 300);
    }

    $scope.addPromotion = function(param) {
        switch (param) {
            case -1:
                $http({
                    url: './addPromotion',
                    method: 'POST',
                    data: {
                        'code': $scope.promotionCode,
                        'benefit': $scope.promotionBenefit,
                        'course': $scope.courseName,
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
                    url: './editPromotion',
                    method: 'POST',
                    data: {
                        'code': $scope.promotionCode,
                        'benefit': $scope.promotionBenefit,
                        'course': $scope.courseName,
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
          title: "Xóa mã giảm giá",
          text: "Khi đã xóa mã giảm giá, các ưu đãi liên quan sẽ không còn tác dụng!!!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $http({
                url: './deletePromotion',
                method: 'GET',
                params: {
                    'code': param,
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