<div id="update_password" class="modal profile-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 500px">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                    <form role="form" ng-submit="updatePassword({{$userInfo->id}})">
                        <h2 id="form-title">Đổi mật khẩu</h2>
                        <div class="error" ngModel="errorMsg"></div>
                        <div class="form-sub-w3 col-md-12">
                            <input type="password" ng-model="oldPassword" placeholder="Mật khẩu cũ" required minlength="8">
                        </div>
                        <div class="form-sub-w3 col-md-12">
                            <input type="password" ng-model="newPassword" placeholder="Mật khẩu mới" required minlength="8">
                        </div>
                        <div class="form-sub-w3 col-md-12">
                            <input type="password" ng-model="confirmPassword" placeholder="Nhập lại mật khẩu mới" required minlength="8">
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