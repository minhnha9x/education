<div ng-controller="StatisticController">
	<div class="chart-wrapper">
		<span class="page-span">
			Xem thống kê năm:
		</span>
		<select class="page-select" ng-model="yearSelected" ng-change="updateChartData()">
	        <option value="2018">2018</option>
	        <option value="2017">2017</option>
	    </select>
	    <span class="page-span">
	    	Loại biểu đồ:
	    </span>
	    <select class="page-select" ng-model="typeSelected" ng-change="updateChartType()">
	        <option value="line">Line</option>
	        <option value="pie">Pie</option>
	        <option value="column">Column</option>
	    </select>
	    <span class="page-span">
	    	Xem thống kê theo:
	    </span>
	    <select class="page-select" ng-model="viewSelected" ng-change="updateChartView()">
	        <option value="1">Tổng số lượt đăng kí</option>
	        <option value="2">Từng môn học</option>
	        <option value="3">Từng trung tâm</option>
	    </select>
		<div id="linechart" class="chart col-md-12"></div>
		<div id="piechart" class="chart col-md-12"></div>
		<div id="piechart2" class="chart col-md-12"></div>
	</div>
</div>

<script type="text/javascript">
	$cRbyS = <?= json_encode($cRbyS); ?>;
	$cRbyO = <?= json_encode($cRbyO); ?>;
	$cS = 0;
	$cO = 0;
    for (var i = 0; i < $cRbyS.length; i++) {
    	$cS += $cRbyS[i]['count'];
    }
    for (var i = 0; i < $cRbyO.length; i++) {
    	$cO += $cRbyO[i]['count'];
    }

	var dataPoints2 = [];
	var chart2 = new CanvasJS.Chart("piechart", {
		title: {
			text: "Favourite Subject"
		},
		data: [{
			type: "pie",
			startAngle: 240,
			yValueFormatString: "##0.00'%'",
			indexLabel: "{label} {y}",
			dataPoints: dataPoints2
		}]
	});
	for (var i = 0; i < $cRbyS.length; i++) {
		dataPoints2.push({
			y: $cRbyS[i]['count'] / $cS * 100,
			label: $cRbyS[i]['name']
		});
    }
	//chart2.render();

	var dataPoints3 = [];
	var chart3 = new CanvasJS.Chart("piechart2", {
		title: {
			text: "Favourite Office"
		},
		data: [{
			type: "pie",
			startAngle: 240,
			yValueFormatString: "##0.00'%'",
			indexLabel: "{label} {y}",
			dataPoints: dataPoints3
		}]
	});
	for (var i = 0; i < $cRbyO.length; i++) {
		dataPoints3.push({
			y: $cRbyO[i]['count'] / $cO * 100,
			label: $cRbyO[i]['office']
		});
    }
	//chart3.render();
</script>