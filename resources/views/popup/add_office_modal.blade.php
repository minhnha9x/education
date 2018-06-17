<div id="officeModal" class="modal admin-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document" style="width: 650px">
		<div class="modal-content">
			<div class="main-agileits">
				<div class="form-w3-agile clearfix">
					<form role="form" class="clearfix" ng-submit="addOffice(edit)">
						<h2 id="form-title"><% button %></h2>
						<div class="form-sub-w3 col-md-12">
							<input type="text" placeholder="Tên trung tâm" ng-model="officeName" required>
						</div>
						<div class="form-sub-w3 col-md-12">
							<input type="text" placeholder="Địa chỉ" ng-model="officeAddr" required>
						</div>
						<div class="form-sub-w3 col-md-6">
							<input type="email" placeholder="Email" ng-model="officeMail" required>
						</div>
						<div class="form-sub-w3 col-md-6">
							<input type="text" placeholder="Số điện thoại" ng-model="officePhone" required>
						</div>
						<div class="form-sub-w3 col-md-12">
							<textarea rows="3" ng-model="Googlemap" placeholder="Link Google Map" required></textarea>
						</div>
						{!! csrf_field() !!}
						<div class="submit-w3l col-md-12">
							<input type="submit" value="<% button %>">
						</div>
					</form>
				</div>	  
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->