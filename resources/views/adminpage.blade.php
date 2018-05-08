<link href="./css/adminpage.css" rel="stylesheet" type="text/css">

<div class="adminpage">
    @include('header', [$title='Administrator Page', $position='normal'])

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#menu1"><div class="arrow-left"></div><img src="./img/course.png">Quản lí khóa học</a></li>
        <li><a data-toggle="tab" href="#menu2"><div class="arrow-left"></div><img src="./img/class.png">Quản lí lớp học</a></li>
        <li><a data-toggle="tab" href="#menu3"><div class="arrow-left"></div><img src="./img/subject.png">Quản lí môn học</a></li>
        <li><a data-toggle="tab" href="#menu4"><div class="arrow-left"></div><img src="./img/office.png">Quản lí trung tâm</a></li>
        <li><a data-toggle="tab" href="#menu5"><div class="arrow-left"></div><img src="./img/room.png">Quản lí phòng học</a></li>
        <li><a data-toggle="tab" href="#menu6"><div class="arrow-left"></div><img src="./img/teacher.png">Quản lí giáo viên</a></li>
        <li><a data-toggle="tab" href="#menu7"><div class="arrow-left"></div><img src="./img/employee.png">Quản lí nhân viên</a></li>
        <li><a data-toggle="tab" href="#menu8"><div class="arrow-left"></div><img src="./img/salary.png">Quản lí lương</a></li>
        <li><a data-toggle="tab" href="#menu9"><div class="arrow-left"></div><img src="./img/promotion.png">Quản lí ưu đãi</a></li>
        <li><a data-toggle="tab" href="#menu10"><div class="arrow-left"></div><img src="./img/statistic.png">Thống kê</a></li>
    </ul>

    <div class="tab-content" ng-app="educationApp">
        <div id="menu1" class="tab-pane in active">
            @include('course_manager')
        </div>
        <div id="menu2" class="tab-pane">
            @include('class_manager')
        </div>
        <div id="menu3" class="tab-pane">
            @include('subject_manager')
        </div>
        <div id="menu4" class="tab-pane">
            @include('office_manager')
        </div>
        <div id="menu5" class="tab-pane">
            @include('room_manager')
        </div>
        <div id="menu6" class="tab-pane">
            @include('teacher_manager')
        </div>
        <div id="menu7" class="tab-pane">
            @include('employee_manager')
        </div>
        <div id="menu8" class="tab-pane">
            @include('salary_manager')
        </div>
        <div id="menu9" class="tab-pane">
            @include('promotion_manager')
        </div>
        <div id="menu10" class="tab-pane">
            @include('statistics_manager')
        </div>
    </div>
</div>
<script src="js/myApp.js"></script>
<script src="js/salaryController.js"></script>
<script src="js/ClassController.js"></script>
<script type="text/javascript">
    $('.tab-content').width($(window).width() - $('.tab-menu').width());
</script>