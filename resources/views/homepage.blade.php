<!DOCTYPE html>
<html>
<head>
    <title>Education Homepage</title>
    <link href="./css/style.css" rel="stylesheet" type="text/css">
    <link href="./css/font.css" rel="stylesheet">
    <link href="./css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="./css/owl.carousel.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css" integrity="sha384-v2Tw72dyUXeU3y4aM2Y0tBJQkGfplr39mxZqlTBDUZAb9BGoC40+rdFCG0m10lXk" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/fontawesome.css" integrity="sha384-q3jl8XQu1OpdLgGFvNRnPdj5VIlCvgsDQTQB6owSOHWlAurxul7f+JpUOVdAiJ5P" crossorigin="anonymous">
    <script src="./js/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
    <script src="./js/owl.carousel.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/modal.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="./img/favicon.png"/>
</head>
<body>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.12&appId=1614788861874943&autoLogAppEvents=1';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <div class="header">
        <a href=""><img src="./img/logo.png"></a>
        <ul class='menu'>
            <li>
                Khóa học
                <i class="fas fa-angle-down"></i>
                <ul class="sub-menu">
                    <li>
                        <a href="">Tiếng Anh<i class="fas fa-angle-right"></i></a>
                        <ul class='sub-menu2'>
                            <li><a href="">Tiếng Anh 1</a></li>
                            <li><a href="">Tiếng Anh 2</a></li>
                        </ul>
                    </li>
                    <li><a href="">Tin Học<i class="fas fa-angle-right"></i></a></li>
                    <li><a href="">Âm nhạc<i class="fas fa-angle-right"></i></a></li>
                    <li><a href="">Mỹ thuật<i class="fas fa-angle-right"></i></a></li>
                    <li><a href="">Toán học<i class="fas fa-angle-right"></i></a></li>
                </ul>
            </li>
            <li>
                Trung Tâm
                <i class="fas fa-angle-down"></i>
                <ul class="sub-menu">
                    <li><a href="">Chi nhánh Hồ Chí Minh</a></li>
                </ul>
            </li>
            <li><a href="">Về chúng tôi</a></li>
            <li><a href="">Liên hệ</a></li>
                @if( Auth::check() )
                    <div class="login" onclick="location.href = './logout'">
                        <i class="fas fa-unlock-alt"></i>HI,{{ Auth::user()->name }}
                    </div>
                @else
                    <div class="login" id="login-btn">
                        <i class="fas fa-unlock-alt"></i>Login
                    </div>
                @endif
        </ul>
    </div>
    <div class="slider">
        <div class="owl-carousel owl-theme">
            <div class="item" style="background-image: url('./img/banner1.jpg')"></div>
            <div class="item" style="background-image: url('./img/banner2.jpg')"></div>
            <div class="item" style="background-image: url('./img/banner3.jpg')"></div>
        </div>
    </div>
    <div class="course-wrapper">
        <div class="title col-xs-12">
            <div class="border-wrapper">
                <div class="border"></div>
            </div>
            Danh sách môn học
        </div>
        <div class="container">
            <div class="col-md-6 p10">
                <div class="object-wrapper">
                    <div class="object" style="background-image: url('./img/object1.jpg')"></div>
                    <div class="bg1"></div>
                    <div class="text-wrapper">
                        <div class="title">Tiếng Anh</div>
                        <div class="text">5 khóa học</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 p10">
                <div class="row-wrapper" style="display: flex">
                    <div class="object-wrapper width50 mr20">
                        <div class="object" style="background-image: url('./img/object2.jpg')"></div>
                        <div class="bg1 bg2"></div>
                        <div class="text-wrapper">
                            <div class="title">Mỹ Thuật</div>
                            <div class="text">2 khóa học</div>
                        </div>
                    </div>
                    <div class="object-wrapper width50">
                        <div class="object" style="background-image: url('./img/object3.jpg')"></div>
                        <div class="bg1 bg3"></div>
                        <div class="text-wrapper">
                            <div class="title">Âm Nhạc</div>
                            <div class="text">5 khóa học</div>
                        </div>
                    </div>
                </div>
                <div class="row-wrapper" style="display: flex">
                    <div class="object-wrapper width50 mr20">
                        <div class="object" style="background-image: url('./img/object4.jpg')"></div>
                        <div class="bg1 bg4"></div>
                        <div class="text-wrapper">
                            <div class="title">Tin Học</div>
                            <div class="text">3 khóa học</div>
                        </div>
                    </div>
                    <div class="object-wrapper width50">
                        <div class="object" style="background-image: url('./img/object5.jfif')"></div>
                        <div class="bg1 bg5"></div>
                        <div class="text-wrapper">
                            <div class="title">Toán Học</div>
                            <div class="text">1 khóa học</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <div class="container">
            <div class="col-md-4">
                <a href="">
                    <img src="./img/logo.png">
                </a>
            </div>
            <div class="col-md-4">
                <div class="title">
                    Thông tin liên hệ
                </div>
                <div class="text">
                    <p><strong>Chi nhánh 1:</strong> Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus.<br>
                    Số điện thoại: 1900 xxxx </p>
                    <p><strong>Chi nhánh 2:</strong> Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus.<br>
                    Số điện thoại: 1900 xxxx </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="title">
                    Fanpage
                </div>
                <div class="fb-page" data-href="https://www.facebook.com/facebook" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/facebook" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/facebook">Facebook</a></blockquote></div>
            </div>
            <div class="col-xs-12 copyright">
                © Copyright 2018. EDUCATION WEBSITE. All Rights Reserved. Website developed by VTOcean
            </div>
        </div>
    </div>
    <div id="myLoginModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="main-agileits">
                    <div class="form-w3-agile">
                        <form id="login-form" action="{{url('login')}}" method="POST" role="form">
                            <h2>Login Now</h2>
                            @if($errors->has('errorlogin'))
                                <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    {{$errors->first('errorlogin')}}
                                </div>
                            @endif
                            <div class="form-sub-w3">
                                <input type="text" class="form-control" id="email" placeholder="Email" name="email" value="{{old('email')}}">
                                <div class="icon-w3">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                </div>
                                @if($errors->has('email'))
                                    <p style="color:red">{{$errors->first('email')}}</p>
                                 @endif
                            </div>
                            <div class="form-sub-w3">
                                <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                                <div class="icon-w3">
                                    <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                                </div>
                                @if($errors->has('password'))
                                    <p style="color:red">{{$errors->first('password')}}</p>
                                @endif                                
                            </div>
                            {!! csrf_field() !!}
                            <div class="submit-w3l">
                                <input type="submit" value="Login">
                            </div>
                        </form>

                        <form id="lost-form" method="post" style="display:none;">
                            <h2>Forgot Password</h2>
                            <div class="form-sub-w3">
                                
                                <input type="text" name="email" placeholder="Email" required>
                                <div class="icon-w3">
                                    <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                </div>
                                
                            </div>
                            <div class="clearfix">
                                <p class="p-bottom-w3ls">Have Account?<button id="lost_login_btn" type="button">Log In here</button></p>
                                <p class="p-bottom-w3ls1">New User?<button id="lost_register_btn" type="button">Register here</button></p>
                            </div>
                            
                            <div class="submit-w3l">
                                <input type="submit" value="Send" name="lost-submit">
                            </div>
                            
                        </form>
                        <!-- End | Lost Password Form -->
                        
                        <!-- Begin | Register Form -->
                        <form id="register-form" method="post" style="display:none;">
                            <h2>Please Sign Up</h2>
                            <div class="form-sub-w3">
                                <input type="text" name="username" placeholder="Username " required=>
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
                                <input type="password" minlength="8" name="password" placeholder="Password" required>
                                <div class="icon-w3">
                                    <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="clearfix">
                                <p class="p-bottom-w3ls">Have Account?<button id="register_login_btn" type="button">Log In here</button></p>
                                <p class="p-bottom-w3ls1">Forgot Password?<button id="register_lost_btn" type="button">Click here</button></p>
                            </div>
                            <div class="submit-w3l">
                                <input type="submit" value="Register" name="register-submit">
                            </div>
                        </form>
                    </div>      
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</body>
<script type="text/javascript">
    $('.menu > li').hover(function(){
        $(this).find('.sub-menu').slideToggle(200);
    })
    $('.sub-menu > li').hover(function(){
        $(this).find('.sub-menu2').fadeToggle(200);
    })
    $('.owl-carousel').owlCarousel({
        autoplay: 4000,
        loop:true,
        margin:10,
        nav:true,
        items:1,
        animateOut: 'fadeOut',
        mouseDrag: false,
        dots:true,
        navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>'],
    })
    $(window).scroll(function (event) {
        var scroll = $(window).scrollTop();
        if (scroll > 40) {
            $('.header').css('width', '100%');
            $('.header').css('position', 'fixed');
            $('.header').css('top', '0');
            $('.header').css('left', '0');
        }
        else {
            $('.header').css('width', 'calc(100% - 80px)');
            $('.header').css('position', 'absolute');
            $('.header').css('top', '40px');
            $('.header').css('left', '40px');
        }
    });
    $('#login-btn').click(function(){
        $('#myLoginModal').modal('show', 300);
    })
</script>
</html>