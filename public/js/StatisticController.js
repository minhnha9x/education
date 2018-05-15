angular.module('educationApp').controller('StatisticController', function($scope, $http) {
    var chart = new CanvasJS.Chart("linechart", {
        theme: "light1",
        width: 1000,
        height: 500,
        exportEnabled: true,
        axisY:{
            includeZero: false
        },
        data: [{        
            type: 'line',
            dataPoints: null
        }]
    });
    $scope.init = function () {
        $scope.yearSelected = '2018';
        $scope.typeSelected = 'line';
        $scope.viewSelected = '1';
        $http({
            url: './getReisterInMonth',
            method: 'GET',
            params : {
                year: 2018,
            },
        })
        .then(function(response) {
            $scope.dataPoints = [];
            $.each(response.data, function(i, item) {
                $scope.dataPoints.push({
                    label: 'Tháng ' + i,
                    y: response.data[i],
                });
            });
            chart.options.data[0].dataPoints = $scope.dataPoints;
            chart.render();
        }, function(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
    }
    $scope.init();

    $scope.updateChartType = function() {
        chart.data[0].set("type", $scope.typeSelected);
        if ($scope.typeSelected == 'pie') {
            $sum = 0;
            $.each($scope.dataPoints, function(i, item) {
                $sum += $scope.dataPoints[i].y;
            });
            $.each($scope.dataPoints, function(i, item) {
                $scope.dataPoints[i].y = $scope.dataPoints[i].y / $sum * 100;
            });
            chart.options.data[0].dataPoints = $scope.dataPoints;
            chart.render();
            chart.data[0].set('indexLabel', "{label}: {y}");
            chart.data[0].set('yValueFormatString', "##0.00'%'");
        }
        else {
            chart.data[0].set('yValueFormatString', null);
            chart.data[0].set('indexLabel', null);
        }
    }
    $scope.updateChartData = function() {
        switch ($scope.viewSelected) {
            case '1':
                $http({
                    url: './getReisterInMonth',
                    method: 'GET',
                    params : {
                        year: $scope.yearSelected,
                    },
                })
                .then(function(response) {
                    $scope.dataPoints = [];
                    $.each(response.data, function(i, item) {
                        $scope.dataPoints.push({
                            label: 'Tháng ' + i,
                            y: response.data[i],
                        });
                    });
                    chart.options.data[0].dataPoints = $scope.dataPoints;
                    chart.render();
                }, function(response) {
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                });
                break;
            case '2':
                $http({
                    url: './countRegisterBySubject',
                    method: 'GET',
                    params : {
                        year: $scope.yearSelected,
                    },
                })
                .then(function(response) {
                    $scope.cRbS = response.data;
                    $scope.cS = 0;
                    for (var i=0; i < $scope.cRbS.length; i++)
                    {
                        $scope.cS += $scope.cRbS[i]['count'];
                    };
                    $scope.dataPoints = [];
                    for (var i=0; i < $scope.cRbS.length; i++)
                    {
                        $scope.dataPoints.push({
                            label: $scope.cRbS[i]['name'],
                            y: $scope.cRbS[i]['count'],
                        });
                    };
                    chart.options.data[0].dataPoints = $scope.dataPoints;
                    chart.render();
                    
                }, function(response) {
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                });
                break;
            case '3':
                $http({
                    url: './countRegisterByOffice',
                    method: 'GET',
                })
                .then(function(response) {
                    $scope.cRbO = response.data;
                    console.log($scope.cRbO);
                    $scope.cO = 0;
                    for (var i=0; i < $scope.cRbO.length; i++)
                    {
                        $scope.cO += $scope.cRbO[i]['count'];
                    };
                    $scope.dataPoints = [];
                    for (var i=0; i < $scope.cRbO.length; i++)
                    {
                        $scope.dataPoints.push({
                            label: $scope.cRbO[i]['office'],
                            y: $scope.cRbO[i]['count'],
                        });
                    };
                    chart.options.data[0].dataPoints = $scope.dataPoints;
                    chart.render();
                }, function(response) {
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                });
                break
            default:
        }
    }
});