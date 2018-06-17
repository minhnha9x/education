angular.module('educationApp').controller('CourseController', function($scope, $http, Upload) {
	$scope.init = function () {
		$http({
			url: './getAllCourse',
			method: 'GET',
		})
		.then(function(response) {
			$scope.courseInfo = response.data;
			$('#courseModal').modal('hide');
		}, function(response) {
			$.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
		});
	}
	$scope.init();
	$scope.showModal = function(param1, param2) {
		switch (param1) {
			case 1:
				$scope.button = "Thêm khóa học";
				$scope.edit = -1;
				$scope.courseName = '';
				$scope.courseDesc = '';
				$scope.coursePrice = '';
				$scope.total_of_period = '';
				$scope.certificate_required = '';
				$scope.subjectName = '';
				$scope.picFile = '';
				break;
			case 2:
				$scope.button = "Sửa khóa học";
				$scope.edit = param2;
				$http({
					url: './getCourse',
					method: 'GET',
					params: {
						'id': param2,
					},
				})
				.then(function(response) {
					$scope.courseName = response.data[0].name;
					$scope.courseDesc = response.data[0].description;
					$scope.coursePrice = response.data[0].price;
					$scope.total_of_period = response.data[0].total_of_period;
					$scope.picFile = response.data[0].img_url;
					if (response.data[0].certificate_required != null)
						$scope.certificate_required = response.data[0].certificate_required + "";
					else
						$scope.certificate_required = "";
					$scope.subjectName = response.data[0].subjectid + "";
				}, function(response) {
					$.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
				});
				break;
			default:
		}
		$http({
			url: './getAllSubject',
			method: 'GET',
		})
		.then(function(response) {
			$scope.subjectInfo = response.data;
		}, function(response) {
			$.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
		});
		$http({
			url: './getAllCourse',
			method: 'GET',
		})
		.then(function(response) {
			$scope.courseList = response.data;
		}, function(response) {
			$.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
		});
		$('#courseModal').modal('show', 300);
	}

	$scope.updateCourseList = function(param) {
		$http({
			url: './getCourseFromSub',
			method: 'GET',
			params: {
				'id': param,
			},
		})
		.then(function(response) {
			$scope.courseList = response.data;
		}, function(response) {
			$.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
		});
	}

	$scope.addCourse = function(param, param2) {
		switch (param) {
			case -1:
				$http({
					url: './addCourse',
					method: 'POST',
					data: {
						'name': $scope.courseName,
						'description': $scope.courseDesc,
						'price': $scope.coursePrice,
						'total_of_period': $scope.total_of_period,
						'subject': $scope.subjectName,
						'certificate_required': $scope.certificate_required,
					},
				})
				.then(function(response) {
					if (param2 != null && param2 != "") {
						Upload.upload({
							url: './updateCourseImg',
							data: {
								id: response.data['id'],
								file: param2,
							}
						}).then(function (resp) {
							//location.reload();
						}, function (resp) {
							console.log('Error status: ' + resp.status);
						}, function (evt) {
							var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
							console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
						});
					}
					$scope.init();
					$.toaster(response.data['msg'], '', response.data['type']);
				}, function(response) {
					$.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
				});
				break;
			default:
				$http({
					url: './addCourse',
					method: 'POST',
					data: {
						'id': param,
						'name': $scope.courseName,
						'description': $scope.courseDesc,
						'price': $scope.coursePrice,
						'total_of_period': $scope.total_of_period,
						'subject': $scope.subjectName,
						'certificate_required': $scope.certificate_required,
					},
				})
				.then(function(response) {
					if (param2 != null && param2 != "") {
						Upload.upload({
							url: './updateCourseImg',
							data: {
								id: param,
								file: param2,
							}
						}).then(function (resp) {
							//location.reload();
						}, function (resp) {
							console.log('Error status: ' + resp.status);
						}, function (evt) {
							var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
							console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
						});
					}
					$scope.init();
					$.toaster(response.data['msg'], '', response.data['type']);
				}, function(response) {
					$.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
				});
				break;
		}
	}
	$scope.delete = function(param) {
		swal({
		  title: "Xóa khóa học",
		  text: "Khi đã xóa khóa học, các lớp học, đăng ký học của môn học cũng sẽ bị mất!!!",
		  icon: "warning",
		  buttons: true,
		  dangerMode: true,
		})
		.then((willDelete) => {
		  if (willDelete) {
			$http({
				url: './deleteCourse',
				method: 'GET',
				params: {
					'id': param,
				},
			})
			.then(function(response) {
				$scope.init();
				$.toaster(response.data['msg'], '', response.data['type']);
			}, function(response) {
				$.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
			});
		  }
		});
	}
});