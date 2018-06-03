<div id="update_password" class="modal profile-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 500px">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                    <form method="POST" role="form" action="{{url('updatePassword')}}">
                        <h2 id="form-title">Đổi mật khẩu</h2>
                        <input type="number" name="id" value="{{$userInfo->id}}" hidden>
                        <div class="form-sub-w3 col-md-12">
                            <input type="password" name="oldpassword" placeholder="Mật khẩu cũ" required>
                        </div>
                        <div class="form-sub-w3 col-md-12">
                            <input type="password" name="newpassword" placeholder="Mật khẩu mới" required>
                        </div>
                        <div class="form-sub-w3 col-md-12">
                            <input type="password" name="confirmpassword" placeholder="Nhập lại mật khẩu mới" required>
                        </div>
                        {!! csrf_field() !!}
                        <div class="col-md-12">
                            <input type="submit" value="Cập nhật">
                        </div>
                    </form>
                </div>      
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->