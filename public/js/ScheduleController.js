angular.module('educationApp').controller('ScheduleController', function($scope, $http) {
	$scope.init = function () {
		$http({
			url: './getAllSubject2',
			method: 'GET',
		})
		.then(function(response) {
			$scope.subjectInfo = response.data;
		}, function(response) {
			$.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
		});
		$http({
			url: './getAllOffice2',
			method: 'GET',
		})
		.then(function(response) {
			$scope.officeInfo = response.data;
		}, function(response) {
			$.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
		});
	}
	$scope.init();

	$scope.updateCourse = function() {
		$http({
			url: './getCourseFromSub2',
			method: 'GET',
			params: {
				id: $scope.subjectSelected
			}
		})
		.then(function(response) {
			$scope.courseInfo = response.data;
		}, function(response) {
			$.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
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
			$scope.scheduleClassInfo = response.data.class;
			$scope.scheduleInfo = response.data.schedule;
			$('#scheduleTable').show();
		}, function(response) {
			$.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
		});
	}

	$scope.modalLoginShow = function() {
		$('#myLoginModal').modal('show', 300);
	}

	$scope.modalShow = function(param) {
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