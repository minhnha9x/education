<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="js/addClassController.js"></script>
<div class="container" ng-app="educationApp" ng-controller="addClassController">
    <div id="addclass" class="addbutton hvr-sweep-to-right">Thêm lớp học</div>
    <table id="example" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Mã lớp</th>
                <th>Khóa học</th>
                <th>Lịch học</th>
                <th>Trung tâm</th>
                <th>Sĩ số</th>
                <th>Ngày khai giảng</th>
                <th>Ngày kết thúc</th>
                <th>Bảng điểm</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($all_class as $class)
                <tr>
                    <td>{{$class->id}}</td>
                    <td>{{$class->course}}</td>
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
                    <td></td>
                    <td>{{$class->start_date}}</td>
                    <td>{{$class->end_date}}</td>
                    <td><button>Xem bảng điểm</button></td>
                    <td class="action">
                        <a id='edit' data-name="Sửa khóa học" data-id='{{$class->id}}'><i class="fas fa-edit"></i>Sửa</a><a><i class="fas fa-trash-alt"></i>Xóa</a><a>Nhập bảng điểm</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div >
        @include('popup.class_register_modal')
    </div>

    <div >
        @include('popup.class_register_modal_step_2')
    </div>

    <div modal="scheduleDetail">
        @include('popup.schedule_detail_modal')
    </div>
</div>
<script type="text/javascript">
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
    $('#scheduleClassModal table td').click(function() {
        $('#scheduleClassModal').modal('hide');
        $('#scheduleDetail').modal('show', 300);
    })
    $('#scheduleDetail input[name="ok"]').click(function() {
        $('#scheduleDetail').modal('hide');
    })
    $('#scheduleDetail').on('hide.bs.modal', function() {
        $('#scheduleClassModal').modal('show', 300);
    });
</script>