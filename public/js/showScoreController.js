angular.module('educationApp').controller('showScoreController', function($scope, $http) {

    $scope.showScore = function(param) {
        $http({
            url: './getScore',
            method: 'GET',
            params: {id: param},
            headers: {'Content-Type' : 'application/x-www-form-urlencoded'}
        })
        .then(function(response) {
            console.log(response.data);
            $scope.scoreInfo = response.data;
        }, function(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
        $('#scoreTable').modal('show', 300);
    }
});