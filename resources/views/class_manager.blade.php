<div id="addclass" class="addbutton hvr-sweep-to-right">Thêm lớp học</div>
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
                            <input type="date" placeholder="Ngày khai giảng" name="start_date" class="checkchange">
                        </div>
                        <div class="form-sub-w3 flexcenter col-md-6">
                            <span>Ngày kết thúc:</span>
                            <input type="date" placeholder="Ngày kết thúc" name="end_date" class="checkchange">
                        </div>
                        <div class="form-sub-w3 col-md-12">
                            <p>Chọn ngày học:</p>
                            <div class="checkbox-wrapper">
                                <div class="checkbox">
                                    <label><input type="checkbox" value="Monday" disabled>Monday</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" value="Tuesday" disabled>Tuesday</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" value="Wednesday" disabled>Wednesday</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" value="Thursday" disabled>Thursday</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" value="Friday" disabled>Friday</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" value="Saturday" disabled>Saturday</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" value="Sunday" disabled>Sunday</label>
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
                        </div>
                        {!! csrf_field() !!}
                        <div class="submit-w3l col-md-12">
                            <input type="button" disabled name="change" style="float: right;" value="Create Class">
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
                                <th>Monday</th>
                                <th>Wednesday</th>
                                <th>Friday</th>
                            </tr>
                            <tr>
                                <td>Phòng 1</td>
                                <td>
                                    <select>
                                        <option selected hidden disabled>Các tiết trống</option>
                                        <option>7:00 - 9:00</option>
                                        <option>13:00 - 15:00</option>
                                    </select>
                                </td>
                                <td>
                                    <select>
                                        <option selected hidden disabled>Các tiết trống</option>
                                        <option>7:00 - 9:00</option>
                                        <option>13:00 - 15:00</option>
                                    </select>
                                </td>
                                <td>
                                    <select>
                                        <option selected hidden disabled>Các tiết trống</option>
                                        <option>7:00 - 9:00</option>
                                        <option>13:00 - 15:00</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Phòng 2</td>
                                <td>
                                    <select>
                                        <option selected hidden disabled>Các tiết trống</option>
                                        <option>7:00 - 9:00</option>
                                        <option>13:00 - 15:00</option>
                                    </select>
                                </td>
                                <td>
                                    <select>
                                        <option selected hidden disabled>Các tiết trống</option>
                                        <option>7:00 - 9:00</option>
                                        <option>13:00 - 15:00</option>
                                    </select>
                                </td>
                                <td>
                                    <select>
                                        <option selected hidden disabled>Các tiết trống</option>
                                        <option>7:00 - 9:00</option>
                                        <option>13:00 - 15:00</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Teacher</th>
                                <td>
                                    <select>
                                        <option selected hidden disabled>Các giáo viên rảnh</option>
                                        <option>Giáo viên A</option>
                                        <option>Giáo viên B</option>
                                    </select>
                                </td>
                                <td>
                                    <select>
                                        <option selected hidden disabled>Các giáo viên rảnh</option>
                                        <option>Giáo viên A</option>
                                        <option>Giáo viên B</option>
                                    </select>
                                </td>
                                <td>
                                    <select>
                                        <option selected hidden disabled>Các giáo viên rảnh</option>
                                        <option>Giáo viên A</option>
                                        <option>Giáo viên B</option>
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
    $(document).on('change', '#addClassModal .checkchange', function(e) {
        if ($('#addClassModal select[name="subject"]').val() != null 
            && $('#addClassModal select[name="course"]').val() != null 
            && $('#addClassModal select[name="office"]').val() != null 
            && $('#addClassModal input[name="start_date"]').val() != "" 
            && $('#addClassModal input[name="end_date"]').val() != "") {
            $.ajax({
                url : "postroomlist",
                type : "get",
                data : {
                    "subject": $('#addClassModal select[name="subject"]').val(),
                    "course": $('#addClassModal select[name="course"]').val(),
                    "office": $('#addClassModal select[name="office"]').val(),
                    "start_date": $('#addClassModal input[name="start_date"]').val(),
                    "end_date": $('#addClassModal input[name="end_date"]').val(),
                },
                dataType:"text",
                success : function (result){
                    obj = JSON.parse(result);
                    console.log(result);
                    }
            });
            $('#addClassModal input[name="change"]').prop("disabled", false);
        }
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