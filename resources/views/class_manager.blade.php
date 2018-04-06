<div id="addclass" class="addbutton hvr-sweep-to-right">Thêm lớp học</div>
<table id="example" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Mã lớp</th>
            <th>Lịch học</th>
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
                            {{$s->current_date}}: {{date('H:i', strtotime($s->start_time))}} - {{date('H:i', strtotime($s->end_time))}} (Phòng {{$s->room}} - {{$s->name}})<br>
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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                    <form method="POST" role="form">
                        <h2 id="form-title">Add class</h2>
                        <div class="form-sub-w3 col-md-6">
                            <select name="subject">
                                <option disabled selected hidden>Môn học</option>
                                @foreach ($subjects as $s)
                                    <option value="{{$s->id}}">{{$s->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <select name="course">
                                <option disabled selected hidden>Khóa học</option>
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <select name="office">
                                <option disabled selected hidden>Trung tâm</option>
                                @foreach ($offices as $o)
                                    <option value="{{$o->id}}">{{$o->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <select name="days" multiple="multiple">
                                <option value="1">Monday</option>
                                <option value="2">Tuesday</option>
                                <option value="3">Wednesday</option>
                                <option value="4">Thursday</option>
                                <option value="5">Friday</option>
                                <option value="6">Saturday</option>
                                <option value="7">Sunday</option>
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <input type="date" placeholder="Ngày khai giảng" name="start_date">
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <input type="date" placeholder="Ngày kết thúc" name="end_date">
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
                            <input type="submit" value="Add Class">
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
    $('#addclass').click(function(){
        $('#addClassModal').modal('show', 300);
    })
    $('#addClassModal select[name="days"]').multiselect({
        nonSelectedText: 'Ngày học'
    });
</script>