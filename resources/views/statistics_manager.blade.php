<div class="chart-wrapper">
	<div id="linechart" class="chart col-md-6"></div>
	<div id="piechart" class="chart col-md-6"></div>
	<div id="piechart2" class="chart col-md-6"></div>
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
    
	var chart = new CanvasJS.Chart("linechart", {
		theme: "light1",
		title:{
			text: "New Register"
		},
		axisY:{
			includeZero: false
		},
		data: [{        
			type: "line",       
			dataPoints: [
				{ label: "Tháng 1", y: 450 },
				{ label: "Tháng 2",y: 414},
				{ label: "Tháng 3",y: 520},
				{ label: "Tháng 4",y: 460 },
				{ label: "Tháng 5",y: 450 },
				{ label: "Tháng 6",y: 500 },
				{ label: "Tháng 7",y: 480 },
				{ label: "Tháng 8",y: 480 },
				{ label: "Tháng 9",y: 410 },
				{ label: "Tháng 10",y: 500 },
				{ label: "Tháng 11",y: 480 },
				{ label: "Tháng 12",y: 510 }
			]
		}]
	});
	chart.render();

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
	chart2.render();

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
	chart3.render();
</script>