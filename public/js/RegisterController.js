angular.module('educationApp').controller('RegisterController', function($scope, $http) {
    $scope.init = function () {
        $http({
            url: './getAllRegister',
            method: 'GET',
        })
        .then(function(response) {
            $scope.registerInfo = response.data;
            $('.loading').hide();
            $('#registerTable').removeClass('hidden');
        }, function(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
    }
    $scope.init();
    $scope.delete = function(param) {
        if (confirm("Are you sure you want to delete this register?")) {
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
                // called asynchronously if an error occurs
                // or server returns response with an error status.
            });
        }
    }
});