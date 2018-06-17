angular.module('educationApp').controller('HomepageController', function($scope, $http) {
	$scope.showModal = function(param) {
		$http({
			url: './getSchedule',
			method: 'GET',
			params: {
				course: param,
			}
		})
		.then(function(response) {
			console.log(response.data.class);
			$scope.scheduleClassInfo = response.data.class;
			$scope.scheduleInfo = response.data.schedule;
			$('#classInfoModal').modal('show', 300);
		}, function(response) {
			$.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
		});
	}

	$scope.modalLoginShow = function() {
		$('#myLoginModal').modal('show', 300);
		$('#classInfoModal').modal('hide');
	}

	$scope.modalRegisterShow = function(param) {
		$.each($scope.scheduleClassInfo, function(i, item) {
			if ($scope.scheduleClassInfo[i]['id'] == param)
			{
				$scope.courseName = $scope.scheduleClassInfo[i]['course'];
				$scope.officeName = $scope.scheduleClassInfo[i]['office'];
				$scope.courseId = $scope.scheduleClassInfo[i]['courseid'];
				$scope.classId = param;
			}

		});
		$('#classRegisterModal').modal('show', 300);
		$('#classInfoModal').modal('hide');
	}

	$scope.backModal = function() {
		$('#classRegisterModal').modal('hide');
		$('#classInfoModal').modal('show', 300);
	}

	$scope.addRegister = function(param) {
		$http({
			url: './addClassRegister',
			method: 'POST',
			data: {
				promotion: $scope.Promotion,
				course: $scope.courseId,
				class: $scope.classId,
			}
		})
		.then(function(response) {
			$('#classRegisterModal').modal('hide');
			$.toaster(response.data['msg'], '', response.data['type']);
			//location.href = './profile';
		}, function(response) {
			$.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
		});
	}
});