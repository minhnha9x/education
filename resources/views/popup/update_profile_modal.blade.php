<div id="update_profile" class="modal profile-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 800px">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                    <form method="POST" role="form" action="{{url('updateProfile')}}">
                        <h2 id="form-title">Update Profile Information</h2>
                        <input type="number" name="id" value="{{$userInfo->id}}" hidden>
                        <div class="form-sub-w3 col-md-6">
                            <input type="text" name="fullname" value="{{$userInfo->name}}" required>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <input type="text" name="phone" value="{{$userInfo->phone}}" required>
                        </div>
                        <div class="form-sub-w3 col-md-12">
                            <input type="text" name="address" value="{{$userInfo->address}}" required>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <span>Ngày sinh: </span>
                            <input type="date" name="birthday" value="{{$userInfo->birthday}}" required>
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