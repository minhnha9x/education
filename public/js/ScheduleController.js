angular.module('educationApp').controller('ScheduleController', function($scope, $http) {
    $scope.init = function () {
        $http({
            url: './getAllSubject',
            method: 'GET',
        })
        .then(function(response) {
            $scope.subjectInfo = response.data;
        }, function(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
        $http({
            url: './getAllOffice',
            method: 'GET',
        })
        .then(function(response) {
            $scope.officeInfo = response.data;
        }, function(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
    }
    $scope.init();

    $scope.updateCourse = function() {
        $http({
            url: './getCourseFromSub',
            method: 'GET',
            params: {
                id: $scope.subjectSelected
            }
        })
        .then(function(response) {
            console.log(response);
            $scope.courseInfo = response.data;
        }, function(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
    }

    $scope.getSchedule = function() {
        $http({
            url: './getSchedule',
            method: 'GET',
            params: {
                subject: $scope.subjectSelected,
                course: $scope.courseSelected,
                office: $scope.officeSelected,
            }
        })
        .then(function(response) {
            console.log(response.data.class);
            $scope.scheduleClassInfo = response.data.class;
            $scope.scheduleInfo = response.data.schedule;
        }, function(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
    }
    $scope.modalLoginShow = function() {
        $('#myLoginModal').modal('show', 300);
    }
});