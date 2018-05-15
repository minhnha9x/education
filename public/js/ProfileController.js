var app = angular.module('fileUpload', ['ngFileUpload']);

app.controller('MyCtrl', ['$scope', 'Upload', function ($scope, Upload) {
    // upload on file select or drop
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
}]);