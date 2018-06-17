<div id="classInfoModal" class="modal homepage-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="main-agileits">
				<div class="form-w3-agile clearfix">
					<h2 id="form-title">Danh sách lớp học</h2>
					<table id="example" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Mã lớp</th>
								<th>Trung tâm</th>
								<th>Lịch học</th>
								<th>Sĩ số hiện tại</th>
								<th>Ngày khai giảng</th>
								<th>Hành động</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="x in scheduleClassInfo">
								<td><% x.id %></td>
								<td><% x.office %></td>
								<td style="white-space: nowrap;">
									<span ng-repeat="y in scheduleInfo" ng-if="y.class == x.id">
										<% y.current_date %>: <% y.start_time | limitTo: 5 %> - <% y.end_time | limitTo: 5 %> (Phòng <% y.room %>)<br>
									</span>
								</td>
								<td><% x.count %> / <% x.max_student %></td>
								<td><% x.start_date %></td>
								@if (Auth::check())
									<td class="action">
										<a ng-click="modalRegisterShow(x.id)">Đăng kí</a>
									</td>
								@else
									<td class="action">
										<a ng-click="modalLoginShow()">Đăng kí</a>
									</td>
								@endif
									
							</tr>
						</tbody>
					</table>
				</div>	  
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->