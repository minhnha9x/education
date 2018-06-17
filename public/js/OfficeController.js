angular.module('educationApp').controller('OfficeController', function($scope, $http) {
	$scope.init = function () {
		$http({
			url: './getAllOffice',
			method: 'GET',
		})
		.then(function(response) {
			$scope.officeInfo = response.data;
			$('#officeModal').modal('hide');
		}, function(response) {
			$.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
		});
	}
	$scope.init();
	$scope.showModal = function(param1, param2) {
		switch (param1) {
			case 1:
				$scope.button = "Thêm trung tâm";
				$scope.edit = -1;
				$scope.officeName = '';
				$scope.officeAddr = '';
				$scope.officePhone = '';
				$scope.officeMail = '';
				$scope.Googlemap = '';
				break;
			case 2:
				$scope.button = "Sửa trung tâm";
				$scope.edit = param2;
				$http({
					url: './getOffice',
					method: 'GET',
					params: {
						'id': param2,
					},
				})
				.then(function(response) {
					$scope.officeName = response.data[0].name;
					$scope.officeAddr = response.data[0].address;
					$scope.officePhone = response.data[0].phone;
					$scope.officeMail = response.data[0].mail;
					$scope.Googlemap = response.data[0].location;
				}, function(response) {
					$.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
				});
				break;
			default:
		}
		$('#officeModal').modal('show', 300);
	}

	$scope.addOffice = function(param) {
		switch (param) {
			case -1:
				$http({
					url: './addOffice',
					method: 'POST',
					data: {
						'name': $scope.officeName,
						'address': $scope.officeAddr,
						'phone': $scope.officePhone,
						'mail': $scope.officeMail,
						'location': $scope.Googlemap,
					},
				})
				.then(function(response) {
					$scope.init();
					$.toaster(response.data['msg'], '', response.data['type']);
				}, function(response) {
					$.toaster('Lỗi kết nối server, vui lòng thử lại sau.', '', 'danger');
				});
				break;
			default:
				$http({
					url: './addOffice',
					method: 'POST',
					data: {
						'id': param,
						'name': $scope.officeName,
						'address': $scope.officeAddr,
						'phone': $scope.officePhone,
						'mail': $scope.officeMail,
						'location': $scope.Googlemap,
					},
				})
				.then(function(response) {
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
		  title: "Xóa trung tâm",
		  text: "Khi đã xóa trung tâm, các phòng học, các lớp học và đăng ký học của trung tâm đó cũng sẽ bị mất!!!",
		  icon: "warning",
		  buttons: true,
		  dangerMode: true,
		})
		.then((willDelete) => {
		  if (willDelete) {
			$http({
				url: './deleteOffice',
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