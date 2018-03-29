<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB; 
?>

<link href="./css/adminpage.css" rel="stylesheet" type="text/css">

<div class="adminpage">
    @include('header', [$title='Administrator Page', $position='normal'])

    <ul class="tab-menu">
        <li class="active"><a data-toggle="tab" href="#menu1"><div class="arrow-left"></div><img src="./img/course.png">Quản lí khóa học</a></li>
        <li><a data-toggle="tab" href="#menu2"><div class="arrow-left"></div><img src="./img/class.png">Quản lí lớp học</a></li>
        <li><a data-toggle="tab" href="#menu3"><div class="arrow-left"></div><img src="./img/subject.png">Quản lí môn học</a></li>
        <li><a data-toggle="tab" href="#menu4"><div class="arrow-left"></div><img src="./img/office.png">Quản lí trung tâm</a></li>
        <li><a data-toggle="tab" href="#menu5"><div class="arrow-left"></div><img src="./img/room.png">Quản lí phòng học</a></li>
        <li><a data-toggle="tab" href="#menu6"><div class="arrow-left"></div><img src="./img/teacher.png">Quản lí giáo viên</a></li>
        <li><a data-toggle="tab" href="#menu7"><div class="arrow-left"></div><img src="./img/employee.png">Quản lí nhân viên</a></li>
        <li><a data-toggle="tab" href="#menu8"><div class="arrow-left"></div><img src="./img/promotion.png">Quản lí ưu đãi</a></li>
        <li><a data-toggle="tab" href="#menu9"><div class="arrow-left"></div><img src="./img/statistic.png">Thống kê</a></li>
    </ul>

    <div class="tab-content">
        <div id="menu1" class="tab-pane fade in active">
            @include('coursemanager')
        </div>
        <div id="menu2" class="tab-pane fade">
            <h3>Menu 1</h3>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        </div>
        <div id="menu3" class="tab-pane fade">
            @include('subject_manager')
        </div>
        <div id="menu4" class="tab-pane fade">
            <h3>Menu 3</h3>
            <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.tab-content').width($(window).width() - $('.tab-menu').width());
</script>