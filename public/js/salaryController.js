var myApp2 = angular.module('educationApp2', [], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

myApp2.controller('salaryController', function($scope, $http) {
	$scope.test = "zzz";
	$scope.salary = [];
	$scope.init();
	$scope.init = function() {
		$http.get('/getSalary').success(function(response) {
			console.log(response);
			$scope.salary = data;
		});
	}
});