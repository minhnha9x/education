<div id="classRegisterModal" class="modal homepage-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 750px">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                	<form role='form' ng-submit="addRegister()">
                		<input type="number" name="class" hidden>
                		<input type="number" name="course" hidden>
                		<h2>Thông tin đăng ký học</h2>
	                    <div class="form-sub-w3 col-md-12">
	                    	<div class="info">
                                <div class="course">Khóa học: <span><% courseName %></span></div>
                                <div class="course"><span><% officeName %></span></div>
                                <div class="schedule">
                                    Giờ học<br>
                                    <span ng-repeat="y in scheduleInfo" ng-if="y.class == classId">
                                        <% y.current_date %>: <% y.start_time %> - <% y.end_time %> (Phòng <% y.room %>)<br>
                                    </span>
                                </div>
	                    	</div>
	                    </div>
	                    <div class="form-sub-w3 col-md-5">
                            <input type="text" placeholder="Mã giảm giá" ng-model="Promotion">
                        </div>
	                    {!! csrf_field() !!}
	                    <div class="submit-w3l col-md-12">
                            @if ($check)
                                <input type="button" name="back" value='back' ng-click="backModal()">
                            @endif
                            <input type="submit" value="Đăng ký">
                        </div>
                	</form>
                </div>      
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->