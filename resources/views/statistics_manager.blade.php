<div class="chart-wrapper">
	<div id="linechart" class="chart col-md-6"></div>
	<div id="piechart" class="chart col-md-6"></div>
	<div id="piechart2" class="chart col-md-6"></div>
</div>

<script type="text/javascript">
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

	var chart2 = new CanvasJS.Chart("piechart", {
		title: {
			text: "Favourite Subject"
		},
		data: [{
			type: "pie",
			startAngle: 240,
			//yValueFormatString: "##0.00'%'",
			indexLabel: "{label} {y}",
			dataPoints: [
				{y: 79.45, label: "English"},
				{y: 7.31, label: "Maths"},
				{y: 7.06, label: "Fine Art"},
				{y: 4.91, label: "IT"},
				{y: 1.26, label: "Music"}
			]
		}]
	});
	chart2.render();

	var chart3 = new CanvasJS.Chart("piechart2", {
		title: {
			text: "Favourite Office"
		},
		data: [{
			type: "pie",
			startAngle: 240,
			yValueFormatString: "##0.00'%'",
			indexLabel: "{label} {y}",
			dataPoints: [
				{y: 59.45, label: "Trung Tam Anh Ngu B.E.N"},
				{y: 27.31, label: "Trung Tam Ve Sang Tao Wow Art"},
				{y: 8.32, label: "Trung Tam Am Nhac FASOL"},
				{y: 4.91, label: "Trung Tam Toan TITAN EDUCATION"},
			]
		}]
	});
	chart3.render();
</script>