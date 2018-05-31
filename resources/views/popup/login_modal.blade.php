<div id="myLoginModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile">
                    <form id="login-form" action="{{url('login')}}" method="POST" role="form">
                        <h2>Đăng nhập</h2>
                        @if($errors->has('errorlogin'))
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{$errors->first('errorlogin')}}
                            </div>
                        @endif
                        <div class="form-sub-w3">
                            <input type="text" id="email" placeholder="Email" name="email" value="{{old('email')}}" required>
                            <div class="icon-w3">
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </div>
                            @if($errors->has('email'))
                                <p style="color:red">{{$errors->first('email')}}</p>
                             @endif
                        </div>
                        <div class="form-sub-w3">
                            <input type="password" id="password" placeholder="Mật khẩu" name="password" required>
                            <div class="icon-w3">
                                <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                            </div>
                            @if($errors->has('password'))
                                <p style="color:red">{{$errors->first('password')}}</p>
                            @endif
                        </div>
                        {!! csrf_field() !!}
                        <div class="clearfix">
                            <p class="p-bottom-w3ls">Quên mật khẩu?<button id="login_lost_btn" type="button">Click tại đây</button></p>
                            <p class="p-bottom-w3ls1">Chưa có tài khoản?<button id="login_register_btn" type="button">Đăng ký ngay</button></p>
                        </div>
                        <div class="submit-w3l">
                            <input type="submit" value="Đăng nhập">
                        </div>
                    </form>

                    <form id="lost-form" action="{{url('forgotPassword')}}" method="post" style="display:none;">
                        <h2>Quên mật khẩu</h2>
                        <div class="form-sub-w3">
                            <input type="text" name="email" placeholder="Email" required>
                            <div class="icon-w3">
                                <i class="fa fa-paper-plane" aria-hidden="true"></i>
                            </div>
                        </div>
                        {!! csrf_field() !!}
                        <div class="clearfix">
                            <p class="p-bottom-w3ls">Đã có tài khoản?<button id="lost_login_btn" type="button">Đăng nhập ngay</button></p>
                            <p class="p-bottom-w3ls1">Chưa có tài khoản?<button id="lost_register_btn" type="button">Đăng ký ngay</button></p>
                        </div>
                        
                        <div class="submit-w3l">
                            <input type="submit" value="OK" name="lost-submit">
                        </div>
                        
                    </form>
                    <!-- End | Lost Password Form -->
                    
                    <!-- Begin | Register Form -->
                    <form id="register-form" method="post" action="{{url('adduser')}}" style="display:none;">
                        <h2>Đăng ký tài khoản</h2>
                        <div class="form-sub-w3">
                            <input type="text" name="username" placeholder="Tên tài khoản" required>
                            <div class="icon-w3">
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </div>
                            
                        </div>
                        <div class="form-sub-w3">
                            <input type="email" name="email" placeholder="Email" required>
                            <div class="icon-w3">
                                <i class="fa fa-paper-plane" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="form-sub-w3">
                            <input type="password" minlength="8" name="password" placeholder="Mật khẩu" required>
                            <div class="icon-w3">
                                <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                            </div>
                        </div>
                        {!! csrf_field() !!}
                        <div class="clearfix">
                            <p class="p-bottom-w3ls">Đã có tài khoản?<button id="register_login_btn" type="button">Đăng nhập ngay</button></p>
                            <p class="p-bottom-w3ls">Quên mật khẩu?<button id="register_lost_btn" type="button">Click tại đây</button></p>
                        </div>
                        <div class="submit-w3l">
                            <input type="submit" value="Đăng ký" name="register-submit">
                        </div>
                    </form>
                </div>      
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    var $divForms = $('#myLoginModal .form-w3-agile');
    var $modalAnimateTime = 300;
    var $msgAnimateTime = 150;
    var $msgShowTime = 2000;

    function modalAnimate ($oldForm, $newForm) {
        var $oldH = $oldForm.height();
        var $newH = $newForm.height() + 120;
        $oldForm.fadeToggle($modalAnimateTime, function(){
            $divForms.animate({height: $newH}, $modalAnimateTime, function(){
                $newForm.fadeToggle($modalAnimateTime);
            });
        });
    }
    
    $('#login_register_btn').click( function () { modalAnimate($('#login-form'), $('#register-form')) });
    $('#register_login_btn').click( function () { modalAnimate($('#register-form'), $('#login-form')); });
    $('#login_lost_btn').click( function () { modalAnimate($('#login-form'), $('#lost-form')); });
    $('#lost_login_btn').click( function () { modalAnimate($('#lost-form'), $('#login-form')); });
    $('#lost_register_btn').click( function () { modalAnimate($('#lost-form'), $('#register-form')); });
    $('#register_lost_btn').click( function () { modalAnimate($('#register-form'), $('#lost-form')); });
</script>