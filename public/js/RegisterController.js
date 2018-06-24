angular.module('educationApp').controller('RegisterController', function($scope, $http) {
    $scope.init = function () {
        $('#menu0 .loading').show();
        $('#registerTable').hide();
        $http({
            url: './getAllRegister',
            method: 'GET',
        })
        .then(function(response) {
            $scope.registerInfo = response.data;
            $('#menu0 .loading').hide();
            $('#registerTable').show();
        }, function(response) {
            $.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
        });
    }
    $scope.init();
    $scope.delete = function(param) {
        swal({
          title: "Xóa đăng ký học",
          text: "Khi đã xóa đăng ký học, hãy liên hệ với học viên để thông báo đăng ký lại!!!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $http({
                url: './deleteRegister',
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
    $scope.updateFee = function(param) {
        $http({
            url: './updateFee',
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