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
	    <select class="page-select" ng-model="viewSelected" ng-change="updateChartData()">
	        <option value="1">Tổng số lượt đăng kí</option>
	        <option value="2">Từng môn học</option>
	        <option value="3">Từng trung tâm</option>
	    </select>
		<div id="linechart" class="chart col-md-12"></div>
		<div id="piechart" class="chart col-md-12"></div>
		<div id="piechart2" class="chart col-md-12"></div>
	</div>
</div>