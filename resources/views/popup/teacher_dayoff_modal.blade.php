<div id="teaching_backup" class="modal profile-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document" style="width: 800px">
		<div class="modal-content">
			<div class="main-agileits">
				<div class="form-w3-agile clearfix">
					<form method="POST" role="form" ng-submit="addTeacherDayoff()">
						<h2 id="form-title">Đăng ký nghỉ dạy</h2>
						<div id="review" class="review-wrapper col-md-12">
							Thông tin buổi học:<br>
							Khóa học: <% course %> - Lớp <% class %><br>
							Tuần hiện tại: <% currentweek %> (<% newdate | date: "dd/MM/y" %> - <% newdate2 | date: "dd/MM/y" %>)<br>
							Thời gian: <% date %> (<% start_time | limitTo: 5 %> - <% end_time | limitTo: 5 %>)<br>
							Địa điểm: Phòng <% room %> (<% office %>)
						</div>
						<div class="form-sub-w3 col-md-5">
							<select name="week" required ng-model="weekSelected" ng-change=updateTeacher()>
								<option value="" disabled selected hidden>Chọn tuần học</option>
								<option ng-repeat="x in listWeek" value="<% x.date | date: 'y-MM-dd' %>">Tuần <% x.week %> (<% x.start | date: "dd/MM/y" %> - <% x.end | date: "dd/MM/y" %>)</option>
							</select>
						</div>
						<div class="form-sub-w3 col-md-5">
							<select name="teacher" ng-model="teacherSelected">
								<option value="" selected value="">Giáo viên dạy thay</option>
								<option ng-repeat="x in listTeacher" value="<% x.id %>"><% x.name %> (<% x.mail %>)</option>
							</select>
						</div>
						{!! csrf_field() !!}
						<div class="submit-w3l col-md-2">
							<input type="submit" value="OK">
						</div>
						<div id="error" class="review-wrapper col-md-12">
						</div>
					</form>
				</div>	  
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->