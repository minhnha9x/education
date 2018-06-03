angular.module('educationApp').controller('ProfileController', function($scope, $http, Upload) {
    // upload on file select or drop
    $scope.scopeList = {};
    $scope.upload = function (file) {
        Upload.upload({
            url: './updateAvatar',
            data: {file: file}
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
});