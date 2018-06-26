angular.module('educationApp').controller('StudentLevelController', function($scope, $http, Upload) {
    $scope.init = function () {
        $('#studentLevelTable').hide();
        $('#menu10 .loading').show();
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
            url: './getAllCertification',
            method: 'GET',
        })
        .then(function(response) {
            $scope.studentLevelInfo = response.data;
            $('#menu10 .loading').hide();
            $('#studentLevelTable').show();
        }, function(response) {
            $.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
        });
    }
    $scope.$on('load-10', function(event, args) {
        $scope.init();
    });
    $scope.updateLevel = function() {
        $('#studentLevelTable tr.selected').each(function(){
            $http({
                url: './updateCertification',
                method: 'GET',
                params: {
                    'id': $(this).data('id'),
                    'course': $scope.courseSelected,
                },
            })
            .then(function(response) {
                $scope.init();
                $('#updateLevelButton').hide();
            }, function(response) {
                $.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
            });
        });
    }
});