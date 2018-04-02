@php
    $courses = DB::table('course')
    ->select('course.*', 'subject.name as subject', 'subject.id as subjectid', 'course2.name as certificate_required', DB::raw('count(class.id) as count'))
    ->leftjoin('subject', 'course.subject', '=', 'subject.id')
    ->leftjoin('course as course2', 'course.certificate_required', '=', 'course2.id')
    ->leftjoin('class', 'class.course', '=', 'course.id')
    ->groupBy('course.id')
    ->get();

    $subjects = DB::table('subject')
    ->select('subject.*', DB::raw('count(course.id) as count'))
    ->leftjoin('course', 'course.subject', 'subject.id')
    ->groupBy('subject.id')
    ->get();

    $offices = DB::table('office')
    ->get();
@endphp

<head>
    <title>{{ $title }}</title>
    <link href="./css/header.css" rel="stylesheet" type="text/css">
    <link href="./css/font.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="./css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="./css/owl.carousel.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/fontawesome.css" crossorigin="anonymous">
    <script src="./js/jquery-3.3.1.min.js"></script>
    <script src="./js/owl.carousel.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/png" href="./img/favicon.png"/>
</head>

    <div class="header">
        <a href="./"><img src="./img/logo.png"></a>
        <ul class='menu'>
            <li>
                Khóa học
                <i class="fas fa-angle-down"></i>
                <ul class="sub-menu">
                    @foreach ($subjects as $s)
                        <li>
                            <a href="./subject_{{$s->id}}">{{$s->name}}<i class="fas fa-angle-right"></i></a>
                            <ul class='sub-menu2'>
                                @foreach ($courses as $c)
                                    @if ($c->subjectid == $s->id)
                                        <li><a href="">{{$c->name}}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </li>
            <li>
                Trung Tâm
                <i class="fas fa-angle-down"></i>
                <ul class="sub-menu">
                    @foreach ($offices as $o)
                        <li><a href="">{{$o->name}}</a></li>
                    @endforeach
                </ul>
            </li>
            <li><a href="">Về chúng tôi</a></li>
            <li><a href="">Liên hệ</a></li>
                @if( Auth::check() ) 
                	<div class="acc-wrapper">
                		<div class="avatar" style="background-image: url('{{ Auth::user()->avatar }}')"></div>
	                    <div class="loged">
	                      {{ Auth::user()->name }}
	                    </div>
	                    <i class="fas fa-angle-down"></i>
	                    <ul>
	                    	<li><a href="">Profile</a></li>
	                    	@if ( Auth::user()->role == "admin")
	                    		<li><a href="{{url('admin')}}">Admin Page</a></li>
	                    	@endif
	                    	<li onclick="location.href = './logout'">Log Out</li>
	                    </ul>
                	</div>
                @else
                    <div class="login" id="login-btn">
                        <i class="fas fa-unlock-alt"></i>Login
                    </div>
                @endif
        </ul>
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
                                <input type="text" id="email" placeholder="Email" name="email" value="{{old('email')}}">
                                <div class="icon-w3">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                </div>
                                @if($errors->has('email'))
                                    <p style="color:red">{{$errors->first('email')}}</p>
                                 @endif
                            </div>
                            <div class="form-sub-w3">
                                <input type="password" id="password" placeholder="Password" name="password">
                                <div class="icon-w3">
                                    <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                                </div>
                                @if($errors->has('password'))
                                    <p style="color:red">{{$errors->first('password')}}</p>
                                @endif
                            </div>
                            {!! csrf_field() !!}
                            <div class="clearfix">
                                <p class="p-bottom-w3ls">Forgot Password?<button id="login_lost_btn" type="button">Click here</button></p>
                                <p class="p-bottom-w3ls1">New User?<button id="login_register_btn" type="button">Register here</button></p>
                            </div>
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
    <script type="text/javascript">
        $('.menu > li').hover(function(){
            $(this).find('.sub-menu').slideToggle(200);
        })
        $('.sub-menu > li').hover(function(){
            $(this).find('.sub-menu2').fadeToggle(200);
        })
        $('.acc-wrapper').hover(function(){
            $(this).find('ul').fadeToggle(200);
        })
        @if ($position == 'top')
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
        @else
            $('.header').css('width', '100%');
            $('.header').css('position', 'fixed');
            $('.header').css('top', '0');
            $('.header').css('left', '0');
        @endif
        $('#login-btn').click(function(){
            $('#myLoginModal').modal('show', 300);
        })
        @if($errors->has('email') || $errors->has('password') || $errors->has('errorlogin'))
        {
            $('#myLoginModal').modal('show', 300);
        }
        @endif
    </script>