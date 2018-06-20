<link href="./css/profilepage.css" rel="stylesheet" type="text/css">
<div class="profilepage" ng-app="educationApp" ng-controller="ProfileController">
    <div class="container">
        @include('header', [$title='Trang Cá Nhân'])
        <div>
            <div class="title">
                Trang cá nhân
            </div>

            <div class="profile-wrapper col-md-6">
                <div>
                    <div class="avatar-wrapper">
                        <div class="avatar" style="background-image: url('{{Auth::user()->avatar}}')">
                        </div>
                        <div>
                            <div class="button" ngf-select="upload($file)">Đổi ảnh đại diện</div>
                        </div>
                    </div>
                    <div class="text-wrapper">
                        <div class="text">
                            <p><span>Name: </span>{{$userInfo->name}}</p>
                            <p><span>Email: </span>{{$userInfo->email}}</p>
                            @if (Auth::user()->role == 'teacher')
                                <p class="clearfix"><span>Phone: </span>{{$userInfo->phone}}</p>
                                <p class="clearfix"><span>Địa chỉ: </span>{{$userInfo->address}}</p>
                                <p class="clearfix"><span>Ngày sinh: </span>{{$userInfo->birthday}}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="button-wrapper">
                    @if (Auth::user()->role == 'teacher')
                        <div id="edit-info" class="button">
                            Cập nhật thông tin
                        </div>
                    @endif
                    <div id="edit-password" class="button">
                        Đổi mật khẩu
                    </div>
                </div>
            </div>
            @if (Auth::user()->role != 'teacher')
                <div class="tab-wrapper col-md-12">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#menu1">Khóa học đã đăng kí</a></li>
                        <li><a data-toggle="tab" href="#menu2">Lịch học trong tuần</a></li>
                        <li><a data-toggle="tab" href="#menu3">Ngày nghỉ</a></li>
                        <li><a data-toggle="tab" href="#menu4">Học bù</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="menu1" class="tab-pane in active">
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th>Khóa học</th>
                                    <th>Lớp</th>
                                    <th>Tuần học</th>
                                    <th>Kết quả</th>
                                </tr>
                                @foreach ($user as $u)
                                    <tr>
                                        <td>{{$u->name}}</td>
                                        <td>{{$u->class}}</td>
                                        <td>
                                            @for ($i = 1; $i <= $week[$u->class]['totalweek']; $i++)
                                                @if ($i == $week[$u->class]['currentweek'])
                                                    <span style="color:red">{{$i}}</span>
                                                @else
                                                    {{$i}}
                                                @endif
                                            @endfor
                                        </td>
                                        <td ng-click="ishown[{{$u->class}}]=!ishown[{{$u->class}}]" ng-init="ishown[{{$u->class}}]=true">
                                            <i class="fas fa-minus-square" ng-show="!ishown[{{$u->class}}]"></i>
                                            <i class="fas fa-plus-square" ng-show="ishown[{{$u->class}}]"></i>
                                        </td>
                                    </tr>
                                    @if ($result->has($u->class))
                                    <tr>
                                        <td colspan="5" ng-show="!ishown[{{$u->class}}]">
                                            <div style="text-align: left;">
                                                <p>
                                                    <span style="font-weight: bold;">Điểm Thi: </span>{{$result[$u->class]->score}}
                                                </p>
                                                <p>
                                                    <span style="font-weight: bold;">Nhận xét giáo viên: </span>{{$result[$u->class]->teacher_feedback}}
                                                </p>
                                                <p>
                                                    <span style="font-weight: bold;">Nhận xét giám thị: </span>{{$result[$u->class]->supervisor_feedback}}
                                                </p>
                                                <p>
                                                    <span style="font-weight: bold;">Kết quả: </span><b ng-style="{'color': ('{{$result[$u->class]->result}}'=='Pass') ? 'blue' : 'red'}">{{$result[$u->class]->result}}</b>
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td colspan="5" ng-show="!ishown[{{$u->class}}]">
                                            <div style="text-align: left;">
                                                <p>
                                                    <span style="font-weight: bold;">Điểm Thi: </span>
                                                </p>
                                                <p>
                                                    <span style="font-weight: bold;">Nhận xét giáo viên: </span>
                                                </p>
                                                <p>
                                                    <span style="font-weight: bold;">Nhận xét giám thị: </span>
                                                </p>
                                                <p>
                                                    <span style="font-weight: bold;">Kết quả: </span>
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            </table>
                        </div>
                        <div id="menu2" class="tab-pane">
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th>Tiết học</th>
                                    <th>Monday</th>
                                    <th>Tuesday</th>
                                    <th>Wednesday</th>
                                    <th>Thursday</th>
                                    <th>Friday</th>
                                    <th>Saturday</th>
                                    <th>Sunday</th>
                                </tr>
                                @foreach ($slot as $s)
                                    <tr>
                                        <td>{{substr($s->start_time, 0, strlen($s->start_time) - 3)}} - {{substr($s->end_time, 0, strlen($s->end_time) - 3)}}</td>
                                        @foreach ($weekday as $w)
                                            @php $check = true; @endphp
                                            @foreach ($schedule as $sc)
                                                @if ($sc->schedule == $s->slot_in_day && $sc->current_date == $w)
                                                    <td class="text">
                                                        <div class="course">Lớp {{$sc->class}}</div>
                                                        <div class="course">{{$sc->course}}</div>
                                                        <strong>{{$sc->name}}</strong>
                                                        <div class="course">Phòng {{$sc->room}}</div>
                                                    </td>
                                                    @php $check = false; @endphp
                                                    @break;
                                                @endif
                                            @endforeach
                                            @if ($check)
                                                <td></td>
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div id="menu3" class="tab-pane">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Lớp</th>
                                        <th>Khóa học</th>
                                        <th>Trung tâm</th>
                                        <th>Thứ</th>
                                        <th>Giờ học</th>
                                        <th>Ngày nghỉ dạy</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($teacher_dayoff as $t)
                                        <tr>
                                            <td>{{$t->class}}</td>
                                            <td>{{$t->course}}</td>
                                            <td>{{$t->office}}</td>
                                            <td>{{$t->current_date}}</td>
                                            <td>{{$t->start_time}} - {{$t->end_time}}</td>
                                            <td class="dayoffid" data-id="{{$t->id}}" data-schedule="{{$t->room_schedule}}">{{$t->date}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div id="menu4" class="tab-pane">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Lớp</th>
                                        <th>Khóa học</th>
                                        <th>Trung tâm</th>
                                        <th>Ngày nghỉ dạy</th>
                                        <th>Ngày dạy bù</th>
                                        <th>Giờ dạy bù</th>
                                        <th>Phòng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($teaching_offset as $t)
                                        <tr>
                                            <td>{{$t->class}}</td>
                                            <td>{{$t->course}}</td>
                                            <td>{{$t->office}}</td>
                                            <td>{{$t->dayoff}}</td>
                                            <td>{{$t->date}}</td>
                                            <td>{{$t->start_time}} - {{$t->end_time}}</td>
                                            <td>{{$t->room}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="tab-wrapper col-md-12">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#menu1">Lịch dạy</a></li>
                        <li><a data-toggle="tab" href="#menu2">Lịch dạy trong tuần</a></li>
                        <li><a data-toggle="tab" href="#menu3">Nghỉ dạy</a></li>
                        <li><a data-toggle="tab" href="#menu4">Dạy bù</a></li>
                        <li><a data-toggle="tab" href="#menu5">Dạy thay</a></li>
                        <li><a data-toggle="tab" href="#menu6">Tình hình giảng dạy</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="menu1" class="tab-pane in active">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Lớp</th>
                                        <th>Vị trí</th>
                                        <th style="white-space: nowrap;">Khóa học</th>
                                        <th>Trung tâm</th>
                                        <th style="white-space: nowrap;">Ngày bắt đầu</th>
                                        <th>Tuần học</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($class as $c)
                                        <tr>
                                            <td>{{$c->class}}</td>
                                            <td style="white-space: nowrap;">Giáo viên</td>
                                            <td>{{$c->course}}</td>
                                            <td>{{$c->name}}</td>
                                            <td>{{ date('d/m/Y', strtotime($c->start_date)) }}</td>
                                            <td>
                                                @for ($i = 1; $i <= $week[$c->class]['totalweek']; $i++)
                                                    @if ($i == $week[$c->class]['currentweek'])
                                                        <span style="color:red">{{$i}}</span>
                                                    @else
                                                        {{$i}}
                                                    @endif
                                                @endfor
                                            </td>
                                        </tr>
                                    @endforeach
                                    @foreach ($class2 as $c)
                                        <tr>
                                            <td>{{$c->class}}</td>
                                            <td style="white-space: nowrap;">Trợ giảng</td>
                                            <td>{{$c->course}}</td>
                                            <td>{{$c->name}}</td>
                                            <td>{{ date('d/m/Y', strtotime($c->start_date)) }}</td>
                                            <td>
                                                @for ($i = 1; $i <= $week2[$c->class]['totalweek']; $i++)
                                                    @if ($i == $week2[$c->class]['currentweek'])
                                                        <span style="color:red">{{$i}}</span>
                                                    @else
                                                        {{$i}}
                                                    @endif
                                                @endfor
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div id="menu2" class="tab-pane">
                            <table class="table table-bordered table-hover" id="tschedule">
                                <thead>
                                    <tr>
                                        <th>Tiết học</th>
                                        <th>Monday</th>
                                        <th>Tuesday</th>
                                        <th>Wednesday</th>
                                        <th>Thursday</th>
                                        <th>Friday</th>
                                        <th>Saturday</th>
                                        <th>Sunday</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $c = 1; ?>
                                @foreach ($slot as $s)
                                    <tr>
                                        <td>{{substr($s->start_time, 0, strlen($s->start_time) - 3)}} - {{substr($s->end_time, 0, strlen($s->end_time) - 3)}}</td>
                                        <?php $d = 1; ?>
                                        @foreach ($weekday as $w)
                                            @php $check = true; @endphp
                                            @foreach ($tschedule as $t)
                                                @if ($t->schedule == $s->slot_in_day && $t->current_date == $w)
                                                    <td class="text" id="{{$c}}{{$d}}" data-class="{{$t->class}}" ng-click="showDayoffModal({{Auth::user()->teacher}}, {{$c}}, {{$d}}, 1)">
                                                        <div class="course">Lớp {{$t->class}}</div>
                                                        <div class="course">{{$t->course}}</div>
                                                        <strong>{{$t->name}}</strong>
                                                        <div class="course">Phòng {{$t->room}}</div>
                                                    </td>
                                                    @php $check = false; @endphp
                                                    @break;
                                                @endif
                                            @endforeach

                                            @if ($check)
                                                @php $check2 = true; @endphp
                                                @foreach ($taschedule as $ta)
                                                    @if ($ta->schedule == $s->slot_in_day && $ta->current_date == $w)
                                                        <td class="text" id="{{$c}}{{$d}}" data-class="{{$ta->class}}" ng-click="showDayoffModal({{Auth::user()->teacher}}, {{$c}}, {{$d}}, 2)">
                                                            <div class="course">Lớp {{$ta->class}}</div>
                                                            <div class="course">{{$ta->course}}</div>
                                                            <strong>{{$ta->name}}</strong>
                                                            <div class="course">Phòng {{$ta->room}}</div>
                                                            <div class="course">(Trợ giảng)</div>
                                                        </td>
                                                        @php $check2 = false; @endphp
                                                        @break;
                                                    @endif
                                                @endforeach

                                                @if ($check2)
                                                    <td></td>
                                                @endif
                                            @endif
                                            <?php $d += 1; ?>
                                        @endforeach
                                    </tr>
                                    <?php $c += 1; ?>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div id="menu3" class="tab-pane">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Lớp</th>
                                        <th>Khóa học</th>
                                        <th>Trung tâm</th>
                                        <th>Thứ</th>
                                        <th>Giờ học</th>
                                        <th>Ngày nghỉ dạy</th>
                                        <th>Người dạy thay</th>
                                        <th>Tình trạng dạy bù</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($teacher_dayoff as $t)
                                        <tr>
                                            <td>{{$t->class}}</td>
                                            <td>{{$t->course}}</td>
                                            <td>{{$t->office}}</td>
                                            <td>{{$t->current_date}}</td>
                                            <td>{{substr($t->start_time, 0, strlen($t->start_time) - 3)}} - {{substr($t->end_time, 0, strlen($t->end_time) - 3)}}</td>
                                            <td class="dayoffid" data-id="{{$t->id}}" data-schedule="{{$t->room_schedule}}">{{ date('d/m/Y', strtotime($t->start_date)) }}</td>
                                            @if ($t->backup_teacher == null)
                                                @php $check = false; @endphp
                                                @foreach ($teaching_offset as $t2)
                                                    @if ($t2->teacher_dayoff == $t->id)
                                                        @php $check = true; @endphp
                                                        @break;
                                                    @endif
                                                @endforeach
                                                @if ($check)
                                                    <td></td>
                                                    <td>
                                                        <img src="./img/checked.png">
                                                    </td>
                                                @else
                                                    <td><img src="./img/invalid.png"></td>
                                                    <td data-id="{{$t->class}}">
                                                        <a>Đăng kí dạy bù</a>
                                                    </td>
                                                @endif
                                            @else
                                                <td>{{$t->name}}</td>
                                                <td></td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    @foreach ($ta_dayoff as $t)
                                        <tr>
                                            <td>{{$t->class}}</td>
                                            <td>{{$t->course}}</td>
                                            <td>{{$t->office}}</td>
                                            <td>{{$t->current_date}}</td>
                                            <td>{{substr($t->start_time, 0, strlen($t->start_time) - 3)}} - {{substr($t->end_time, 0, strlen($t->end_time) - 3)}}</td>
                                            <td class="dayoffid" data-id="{{$t->id}}" data-schedule="{{$t->room_schedule}}">{{ date('d/m/Y', strtotime($t->start_date)) }}</td>
                                            @if ($t->backup_ta == null)
                                                <td><img src="./img/invalid.png"></td>
                                                <td><img src="./img/invalid.png"></td>
                                            @else
                                                <td>{{$t->name}}</td>
                                                <td></td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div id="menu4" class="tab-pane">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Lớp</th>
                                        <th>Khóa học</th>
                                        <th>Trung tâm</th>
                                        <th>Ngày nghỉ dạy</th>
                                        <th>Ngày dạy bù</th>
                                        <th>Giờ dạy bù</th>
                                        <th>Phòng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($teaching_offset as $t)
                                        <tr>
                                            <td>{{$t->class}}</td>
                                            <td>{{$t->course}}</td>
                                            <td>{{$t->office}}</td>
                                            <td>{{ date('d/m/Y', strtotime($t->dayoff)) }}</td>
                                            <td>{{ date('d/m/Y', strtotime($t->date)) }}</td>
                                            <td>{{substr($t->start_time, 0, strlen($t->start_time) - 3)}} - {{substr($t->end_time, 0, strlen($t->end_time) - 3)}}</td>
                                            <td>{{$t->room}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <script type="text/javascript">
                            console.log(<?= json_encode($tschedule); ?>)
                        </script>
                        <div id="menu5" class="tab-pane">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Lớp</th>
                                        <th>Khóa học</th>
                                        <th>Trung tâm</th>
                                        <th>Giáo viên nghỉ dạy</th>
                                        <th>Ngày dạy thay</th>
                                        <th>Giờ dạy thay</th>
                                        <th>Phòng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($teacher_backup as $t)
                                        <tr>
                                            <td>{{$t->class}}</td>
                                            <td>{{$t->course}}</td>
                                            <td>{{$t->office}}</td>
                                            <td>{{$t->teacher_off}}</td>
                                            <td>{{$t->date}}</td>
                                            <td>{{substr($t->start_time, 0, strlen($t->start_time) - 3)}} - {{substr($t->end_time, 0, strlen($t->end_time) - 3)}}</td>
                                            <td>{{$t->room}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div id="menu6" class="tab-pane">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Lớp</th>
                                        <th>Khóa học</th>
                                        <th>Số buổi nghỉ dạy</th>
                                        <th>Nghỉ dạy đã bù</th>
                                        <th>Còn thiếu</th>
                                        <th>Điểm số</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($class as $c)
                                        <tr>
                                            <td>{{$c->class}}</td>
                                            <td>{{$c->course}}</td>
                                            <td>{{$teacher_dayoff_count[$c->id]}}</td>
                                            <td>{{$teaching_offset_count[$c->id]}}</td>
                                            <td>{{$teacher_dayoff_count[$c->id] - $teaching_offset_count[$c->id]}} buổi</td>
                                            <td ng-click="ishown[{{$c->class}}]=!ishown[{{$c->class}}]; expandScore({{$c->class}}, ishown[{{$c->class}}])" ng-init="ishown[{{$c->class}}]=false">
                                                <i class="fas fa-minus-square" ng-show="ishown[{{$c->class}}]"></i>
                                                <i class="fas fa-plus-square" ng-show="!ishown[{{$c->class}}]"></i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" ng-show="ishown[{{$c->class}}]">
                                                <div style="text-align: left;">
                                                    <table class="table table-bordered table-hover">
                                                        <tr>
                                                            <th>Mã số</th>
                                                            <th>Tên học viên</th>
                                                            <th>Điểm</th>
                                                            <th>Nhận xét giáo viên</th>
                                                        </tr>
                                                        <tr ng-repeat="memberScore in scopeList[{{$c->class}}]">
                                                            <td><% memberScore.id %></td>
                                                            <td><% memberScore.name %></td>
                                                            <td><input type="number" ng-model="memberScore.score"></td>
                                                            <td><textarea style="resize:none" rows="4" cols="40" name="comment" ng-model="memberScore.teacher_feedback"></textarea></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div>
                                                    <button class="my-button left" ng-click="updateScore({{$c->class}})" ng-disabled="scopeList[{{$c->class}}].status" >Update</button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @include('popup.teacher_dayoff_modal')

        @include('popup.teaching_offset_modal')

        @include('popup.update_profile_modal')

        @include('popup.update_password_modal')
    </div>
</div>

@include('footer')

{{-- @include('footer') --}}
<script src="js/myApp.js"></script>
<script src="js/ProfileController.js"></script>

<script type="text/javascript">
    $week = <?= json_encode($week); ?>;
    $('.button-wrapper #edit-info').click(function(){
        $('#update_profile').modal('show', 300)
    });
    $('.button-wrapper #edit-password').click(function(){
        $('#update_password').modal('show', 300)
    });

    $('#menu3 table a').click(function(){
        $c = $(this).parent().data('id');
        $string = '<option value="' + eval($week[$c]['totalweek'] - 1) + '">Tuần ' + eval($week[$c]['totalweek'] - 1) + '</option><option value="' + $week[$c]['totalweek'] + '">Tuần ' + $week[$c]['totalweek'] + '</option>';
        $('#teaching_offset select[name="week"]').append($string);

        $string ="";
        for (var i = 0; i < $tschedule.length; i++)
        {
            if ($tschedule[i]['class'] == $c)
            {
                $start_time = new Date($tschedule[i]['start_date']);
                $string += '<option value="' + $tschedule[i]['current_date'] + '">' + $tschedule[i]['current_date'] + '</option>';
            }
        }
        $('#teaching_offset select[name="day"]').append($string);

        $('#teaching_offset input[name="id"]').attr('value', $(this).parent().parent().find('.dayoffid').data('id'));
        $('#teaching_offset input[name="room_schedule"]').attr('value', $(this).parent().parent().find('.dayoffid').data('schedule'));
        
        $('#teaching_offset').modal('show', 300);
    });
</script>