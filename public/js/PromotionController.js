angular.module('educationApp').controller('PromotionController', function($scope, $http) {
    $scope.init = function () {
        $http({
            url: './getAllPromotion',
            method: 'GET',
        })
        .then(function(response) {
            $scope.promotionInfo = response.data;
            $('#promotionModal').modal('hide');
        }, function(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
    }
        $http({
            url: './getAllCourse',
            method: 'GET',
        })
        .then(function(response) {
            $scope.courseInfo = response.data;
        }, function(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
    $scope.init();
    $scope.showModal = function(param1, param2) {
        switch (param1) {
            case 1:
                $scope.button = "Thêm mã giảm giá";
                $scope.edit = -1;
                $scope.promotionCode = '';
                $scope.promotionBenefit = '';
                break;
            case 2:
                $scope.button = "Sửa mã giảm giá";
                $scope.edit = param2;
                $http({
                    url: './getPromotion',
                    method: 'GET',
                    params: {
                        'code': param2,
                    },
                })
                .then(function(response) {
                    $scope.promotionCode = response.data[0].code;
                    $scope.promotionBenefit = response.data[0].benefit;
                    $scope.courseName = response.data[0].course + '';
                }, function(response) {
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                });
                break;
            default:
        }
        $('#promotionModal').modal('show', 300);
    }

    $scope.addPromotion = function(param) {
        switch (param) {
            case -1:
                $http({
                    url: './addPromotion',
                    method: 'POST',
                    params: {
                        'code': $scope.promotionCode,
                        'benefit': $scope.promotionBenefit,
                        'course': $scope.courseName,
                    },
                })
                .then(function(response) {
                    $scope.init();
                }, function(response) {
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                });
                break;
            default:
                $http({
                    url: './addPromotion',
                    method: 'POST',
                    params: {
                        'code': $scope.promotionCode,
                        'benefit': $scope.promotionBenefit,
                        'course': $scope.courseName,
                    },
                })
                .then(function(response) {
                    $scope.init();
                }, function(response) {
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                });
                break;
        }
    }
    $scope.delete = function(param) {
        if (confirm("Are you sure you want to delete this promotion?")) {
            $http({
                url: './deletePromotion',
                method: 'GET',
                params: {
                    'code': param,
                },
            })
            .then(function(response) {
                $scope.init();
            }, function(response) {
                // called asynchronously if an error occurs
                // or server returns response with an error status.
            });
        }
    }
});