<div id="classRegisterModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 750px">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                	<form method="POST" role='form' action="{{url('classregister')}}">
                		<input type="number" name="class" hidden>
                		<input type="number" name="course" hidden>
                		<h2>Thông tin đăng kí</h2>
	                    <div class="form-sub-w3 col-md-12">
	                    	<div class="info">
	                    	</div>
	                    </div>
	                    <div class="form-sub-w3 col-md-5">
                            <input type="text" placeholder="Mã giảm giá" name="promotion">
                        </div>
	                    {!! csrf_field() !!}
	                    <div class="submit-w3l col-md-12">
                            <input type="submit" value="Đăng kí">
                        </div>
                	</form>
                </div>      
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->