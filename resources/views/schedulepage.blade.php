<link href="./css/schedulepage.css" rel="stylesheet" type="text/css">

<div class="schedulepage container" ng-controller="ScheduleController" ng-app="educationApp">
	@include('header', [$title='Schedule Page'])

	<div class="title">
		Lịch học
		<div class="subtitle">
			Để biết lịch học, vui lòng chọn môn học, khoá học, trung tâm gần nơi bạn đang sống.
		</div>
	</div>

	<div class="filter-wrapper">
		<form class="clearfix">
			<div class="form-sub-w3 col-md-3">
	            <select ng-model="subjectSelected" ng-change="updateCourse()">
	                <option disabled selected hidden value="">Môn học</option>
	                <option ng-repeat="x in subjectInfo" value="<% x.id %>"><% x.name %></option>
	            </select>
	        </div>
	        <div class="form-sub-w3 col-md-3">
	            <select ng-model="courseSelected">
	                <option disabled selected hidden value="">Khóa học</option>
	                <option ng-repeat="x in courseInfo" value="<% x.id %>"><% x.name %></option>
	            </select>
	        </div>
	        <div class="form-sub-w3 col-md-3">
	            <select ng-model="officeSelected">
	                <option disabled selected hidden value="">Trung tâm</option>
	                <option ng-repeat="x in officeInfo" value="<% x.id %>"><% x.name %></option>
	            </select>
	        </div>
	        <div class="form-sub-w3 col-md-3">
	        	<input type="button" value="View Schedule" ng-click="getSchedule()">
	        </div>
		</form>
	</div>

	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>Mã lớp</th>
				<th>Môn học</th>
				<th>Khóa học</th>
				<th>Lịch học</th>
				<th>Sĩ số</th>
				<th>Ngày khai giảng</th>
				<th>Hành động</th>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="x in scheduleClassInfo">
				<td><% x.id %></td>
				<td><% x.name %></td>
				<td><% x.course %></td>
				<td>
					<span ng-repeat="y in scheduleInfo" ng-if="y.class == x.id">
						<% y.current_date %>: <% y.start_time %> - <% y.end_time %> (Phòng <% y.room %>)<br>
					</span>
				</td>
				<td></td>
				<td><% x.start_date %></td>
				@if (Auth::check())
					<td class="action">
						<a ng-click="modalShow(x.id)">Đăng kí</a>
					</td>
				@else
					<td class="action">
						<a ng-click="modalLoginShow()">Đăng kí</a>
					</td>
				@endif
					
			</tr>
		</tbody>
	</table>

	@include('popup.class_register_modal', [$check = false])

	<script src="js/myApp.js"></script>
	<script src="js/ScheduleController.js"></script>
</div>

@include('footer')