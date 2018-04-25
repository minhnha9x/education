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
    <link href="./css/bootstrap.css" rel="stylesheet" crossorigin="anonymous">
    <link href="./css/owl.carousel.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.0.8/css/fontawesome.css" rel="stylesheet" crossorigin="anonymous">
    <link href="./css/datatables.min.css" rel="stylesheet" type="text/css"/>
 
    <script type="text/javascript" src="./js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="./js/owl.carousel.min.js"></script>
    <script type="text/javascript" src="./js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./js/jquery.canvasjs.min.js"></script>
    <script type="text/javascript" src="./js/datatables.min.js"></script>

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
            <li><a href="./schedule">Lịch học</a></li>
            <li><a href="">Liên hệ</a></li>
                @if( Auth::check() ) 
                	<div class="acc-wrapper">
                		<div class="avatar" style="background-image: url('{{ Auth::user()->avatar }}')"></div>
	                    <div class="loged">
	                      @if (Auth::user()->fullname != null)
                            {{Auth::user()->fullname}}
                        @else
                            {{Auth::user()->name}}
                        @endif
	                    </div>
	                    <i class="fas fa-angle-down"></i>
	                    <ul>
	                    	<li><a href="{{url('profile')}}">Profile</a></li>
	                    	@if ( Auth::user()->role == "admin")
	                    		<li><a href="{{url('admin')}}">Admin Page</a></li>
	                    	@endif
	                    	<li onclick="location.href = './logout'" class="padli">Log Out</li>
	                    </ul>
                	</div>
                @else
                    <div class="login" id="login-btn">
                        <i class="fas fa-unlock-alt"></i>Login
                    </div>
                @endif
        </ul>
    </div>

@include('popup.login_modal')

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