<link href="./css/adminpage.css" rel="stylesheet" type="text/css">

<div class="adminpage" ng-app="educationApp">
    @include('header', [$title='Trang Quản trị'])

    <ul class="nav nav-tabs" ng-controller="MenuController">
        <li class="active" ng-click="loadData(0)"><a data-toggle="tab" href="#menu0"><div class="arrow-left"></div><img src="./img/register.png">Quản lý học viên</a></li>
        <li ng-click="loadData(10)"><a data-toggle="tab" href="#menu10"><div class="arrow-left"></div><img src="./img/student_level.png">Quản lý chứng chỉ</a></li>
        <li ng-click="loadData(1)"><a data-toggle="tab" href="#menu1"><div class="arrow-left"></div><img src="./img/course.png">Quản lý khóa học</a></li>
        <li ng-click="loadData(2)"><a data-toggle="tab" href="#menu2"><div class="arrow-left"></div><img src="./img/class.png">Quản lý lớp học</a></li>
        <li ng-click="loadData(3)"><a data-toggle="tab" href="#menu3"><div class="arrow-left"></div><img src="./img/subject.png">Quản lý môn học</a></li>
        <li ng-click="loadData(4)"><a data-toggle="tab" href="#menu4"><div class="arrow-left"></div><img src="./img/office.png">Quản lý trung tâm</a></li>
        <li ng-click="loadData(5)"><a data-toggle="tab" href="#menu5"><div class="arrow-left"></div><img src="./img/room.png">Quản lý phòng học</a></li>
        <li ng-click="loadData(6)"><a data-toggle="tab" href="#menu6"><div class="arrow-left"></div><img src="./img/employee.png">Quản lý nhân viên</a></li>
        <li ng-click="loadData(7)"><a data-toggle="tab" href="#menu7"><div class="arrow-left"></div><img src="./img/salary.png">Quản lý lương</a></li>
        <li ng-click="loadData(8)"><a data-toggle="tab" href="#menu8"><div class="arrow-left"></div><img src="./img/promotion.png">Quản lý mã ưu đãi</a></li>
        <li ng-click="loadData(9)"><a data-toggle="tab" href="#menu9"><div class="arrow-left"></div><img src="./img/statistic.png">Thống kê</a></li>
    </ul>

    <div class="tab-content">
        <div id="menu0" class="tab-pane in active">
            @include('register_manager')
        </div>
        <div id="menu1" class="tab-pane">
            @include('course_manager')
        </div>
        <div id="menu10" class="tab-pane">
            @include('student_level_manager')
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
            @include('employee_manager')
        </div>
        <div id="menu7" class="tab-pane">
            @include('salary_manager')
        </div>
        <div id="menu8" class="tab-pane">
            @include('promotion_manager')
        </div>
        <div id="menu9" class="tab-pane">
            @include('statistics_manager')
        </div>
    </div>
</div>
<script src="js/myApp.js"></script>
<script src="js/MenuController.js"></script>
<script src="js/StudentLevelController.js"></script>
<script src="js/SalaryController.js"></script>
<script src="js/RegisterController.js"></script>
<script src="js/ClassController.js"></script>
<script src="js/SubjectController.js"></script>
<script src="js/RoomController.js"></script>
<script src="js/CourseController.js"></script>
<script src="js/OfficeController.js"></script>
<script src="js/EmployeeController.js"></script>
<script src="js/PromotionController.js"></script>
<script src="js/StatisticController.js"></script>
<script type="text/javascript">
    $('.tab-content').width($(window).width() - $('.tab-menu').width());
</script>