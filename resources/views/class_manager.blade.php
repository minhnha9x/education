<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="js/addClassController.js"></script>
<div id="addclass" class="addbutton hvr-sweep-to-right">Thêm lớp học</div>
<div class="container" ng-app="educationApp" ng-controller="addClassController">
<table id="example" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Mã lớp</th>
            <th>Lịch học</th>
            <th>Trung tâm</th>
            <th>Khóa học</th>
            <th>Sĩ số</th>
            <th>Ngày khai giảng</th>
            <th>Ngày kết thúc</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($all_class as $class)
            <tr>
                <td>{{$class->id}}</td>
                <td>
                    @foreach ($schedule as $s)
                        @if ($s->class == $class->id)
                            {{$s->current_date}}: {{date('H:i', strtotime($s->start_time))}} - {{date('H:i', strtotime($s->end_time))}} (Phòng {{$s->room}})<br>
                        @endif
                    @endforeach
                </td>
                <td>
                    @foreach ($schedule as $s)
                        @if ($s->class == $class->id)
                            {{$s->name}}
                            @break
                        @endif
                    @endforeach
                </td>
                <td>{{$class->course}}</td>
                <td></td>
                <td>{{$class->start_date}}</td>
                <td>{{$class->end_date}}</td>
                <td class="action">
                    <a id='edit' data-name="Sửa khóa học" data-id='{{$class->id}}'><i class="fas fa-edit"></i>Sửa</a><a><i class="fas fa-trash-alt"></i>Xóa</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div id="addClassModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 800px">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                    <form method="POST" role="form">
                        <h2 id="form-title">Add class</h2>
                        <div class="form-sub-w3 col-md-4">
                            <select name="subject" class="checkchange">
                                <option disabled selected hidden>Môn học</option>
                                @foreach ($subjects as $s)
                                    <option value="{{$s->id}}">{{$s->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-4">
                            <select name="course" class="checkchange">
                                <option disabled selected hidden>Khóa học</option>
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-4">
                            <select name="office" class="checkchange">
                                <option disabled selected hidden>Trung tâm</option>
                                @foreach ($offices as $o)
                                    <option value="{{$o->id}}">{{$o->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-sub-w3 flexcenter col-md-6">
                            <span>Ngày khai giảng:</span>
                            <input type="date" value="2018-01-01" placeholder="Ngày khai giảng" name="start_date" class="checkchange">
                        </div>
                        <div class="form-sub-w3 flexcenter col-md-6">
                            <span>Ngày kết thúc:</span>
                            <input type="date" value="2018-01-01" placeholder="Ngày kết thúc" name="end_date" class="checkchange">
                        </div>
                        <div class="form-sub-w3 col-md-12">
                            <p>Chọn ngày học:</p>
                            <div class="checkbox-wrapper">
                                <div class="checkbox" ng-repeat="(key, value) in list_day_in_week">
                                    <label><input type="checkbox" value="<% key %>" ng-model="list_day_in_week[key]" ng-click="log()"><% key %></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <select name="supervisor">
                                <option disabled selected hidden>Quản lí lớp học</option>
                                @foreach ($teachers as $t)
                                    <option value="{{$t->id}}">{{$t->name}}</option>
                                @endforeach
                            </select>
                            <div>
                                <span>Số phòng tìm thấy:</span><span id='room_available'><% text %></span>
                            </div>
                        </div>
                        {!! csrf_field() !!}
                        <div class="submit-w3l col-md-12">
                            <input type="button" disabled name="change" ng-click="getCheckedList(); getRoomAvailableList()" style="float: right;" value="Create Class">
                        </div>
                    </form>
                </div>      
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="scheduleClassModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog schedule-modal" role="document">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                    <form method="POST" role="form">
                        <h2 id="form-title">Create class schedule</h2>
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th>Rooms</th>
                                <th ng-repeat="title in checkedList" style="width: 150px;"><% title %></th>
                            </tr>
                            <tr ng-repeat="(room, days_in_week) in room_available_render">
                                <td>Phòng <% room %></td>
                                <td ng-repeat="(day, slot_in_day) in days_in_week">
                                    <select>
                                        <option selected hidden disabled>Các tiết trống</option>
                                        <option ng-repeat="(key, value) in slot_in_day"><% value %></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Teacher</th>
                                <td ng-repeat="test in checkedList">
                                    <select>
                                        <option selected hidden disabled>Các giáo viên rảnh</option>
                                        <option>Giáo viên A</option>
                                        <option>Giáo viên B</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Teaching Assistant</th>
                                <td ng-repeat="test in checkedList">
                                    <select>
                                        <option selected hidden disabled>Các giáo viên rảnh</option>
                                        <option>Trợ Giảng 1</option>
                                        <option>Trợ Giảng 2</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        {!! csrf_field() !!}
                        <div class="submit-w3l col-md-12">
                            <input type="button" name="back" value='back'>
                            <input type="submit" value="Save schedule">
                        </div>
                    </form>
                </div>      
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<script type="text/javascript">
    $('#addClassModal select[name="subject"]').on('change', function() {
        $('#addClassModal').find('select[name="course"] option:not(:first-child)').remove();
        $.ajax({
            url : "getcoursefromsub" + $(this).val(),
            type : "get",
            dataType:"text",
            success : function (result){
                obj = JSON.parse(result);
                var i;
                for (i = 0; i < obj.length; i++) {
                    $string = '<option value="' + obj[i]['id'] + '">' + obj[i]['name'] + '</option>';
                    $('#addClassModal select[name="course"]').append($string);
                }
            }
        });
    });
    $('#addClassModal input[name="change"]').click(function(){
        $('#addClassModal').modal('hide');
        $('#scheduleClassModal').modal('show', 300);
    });
    $('#scheduleClassModal input[name="back"]').click(function() {
        $('#scheduleClassModal').modal('hide');
        $('#addClassModal').modal('show', 300);
    });
    $('#addclass').click(function(){
        $('#addClassModal').modal('show', 300);
    })
</script>