angular.module('educationApp').controller('MenuController', function($scope, $rootScope, $http) {
    $scope.loadData = function(param) {
        switch (param) {
            case 0:
                $rootScope.$broadcast('load-0');
                break;
            case 1:
                $rootScope.$broadcast('load-1');
                break;
            case 2:
                $rootScope.$broadcast('load-2');
                break;
            case 3:
                $rootScope.$broadcast('load-3');
                break;
            case 4:
                $rootScope.$broadcast('load-4');
                break;
            case 5:
                $rootScope.$broadcast('load-5');
                break;
            case 6:
                $rootScope.$broadcast('load-6');
                break;
            case 7:
                $rootScope.$broadcast('load-7');
                break;
            case 8:
                $rootScope.$broadcast('load-8');
                break;
            case 9:
                $rootScope.$broadcast('load-9');
                break;
            default:
                break;
        }
    }
});