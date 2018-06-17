<div id="scoreTable" class="modal admin-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document" style="width: 800px">
		<div class="modal-content">
			<div class="main-agileits">
				<div class="form-w3-agile clearfix">
					<h2>Bảng điểm lớp <% className %></h2>
					<table class="table table-bordered table-hover">
						<tr>
							<th>Mã học viên</th>
							<th>Họ và tên</th>
							<th>Điểm</th>
						</tr>
						<tr ng-repeat="x in scoreInfo">
							<td><% x.user %></td>
							<td><% x.name %></td>
							<td><% x.score %></td>
						</tr>
					</table>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->