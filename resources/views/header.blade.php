<head>
    <title>{{ $title }}</title>
    <link href="./css/header.css" rel="stylesheet" type="text/css">
    <link href="./css/font.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="./css/bootstrap.css" rel="stylesheet" crossorigin="anonymous">
    <link href="./css/jquery.flipster.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.0.8/css/fontawesome.css" rel="stylesheet" crossorigin="anonymous">
    <link href="./css/datatables.min.css" rel="stylesheet" type="text/css"/>
 
    <script type="text/javascript" src="./js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="./js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./js/jquery.canvasjs.min.js"></script>
    <script type="text/javascript" src="./js/jquery.flipster.min.js"></script>
    <script type="text/javascript" src="./js/datatables.min.js"></script>
    <script type="text/javascript" src="./js/underscore-min.js"></script>
    <script type="text/javascript" src="./js/jquery.toaster.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <script type="text/javascript" src="./js/ng-file-upload.min.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/png" href="./img/favicon.png"/>
</head>

    <div class="header">
        <a href="./"><img src="./img/logo.png"></a>
        <ul class='menu'>
            <li><a href="./schedule">Lịch học</a></li>
            <li><a href="./office">Trung tâm đào tạo</a></li>
                @if( Auth::check() ) 
                    <div class="acc-wrapper">
                        <div class="avatar" style="background-image: url('{{ Auth::user()->avatar }}')"></div>
                        <div class="loged">
                          @if (Auth::user()->role != 'teacher')
                            {{Auth::user()->name}}
                        @else
                            {{$userInfo->name}}
                        @endif
                        </div>
                        <i class="fas fa-angle-down"></i>
                        <ul>
                            @if ( Auth::user()->role != "admin")
                                <li><a href="{{url('profile')}}">Profile</a></li>
                            @endif
                            @if ( Auth::user()->role == "admin")
                                <li><a href="{{url('admin')}}">Admin Page</a></li>
                            @endif
                            <li onclick="location.href = './logout'" class="padli">Log Out</li>
                        </ul>
                    </div>
                @else
                    <div class="login" id="login-btn">
                        <i class="fas fa-unlock-alt"></i>Account
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
    $('#login-btn').click(function(){
        $('#myLoginModal').modal('show', 300);
    })
    @if($errors->has('email') || $errors->has('password') || $errors->has('errorlogin'))
    {
        $('#myLoginModal').modal('show', 300);
    }
    @endif
</script>