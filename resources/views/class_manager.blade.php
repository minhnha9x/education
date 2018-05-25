<div class="" ng-controller="ClassController">
    <div ng-click="addClass()" class="addbutton hvr-sweep-to-right">Thêm lớp học</div>
    <table id="class_table" class="table table-bordered table-hover">
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
                    <td><a ng-click="showScore({{$class->id}})"><i class="fas fa-eye"></i></a></td>
                    <td class="action">
                        <a id='edit' data-name="Sửa khóa học" data-id='{{$class->id}}'>
                            <i class="fas fa-edit"></i>Sửa
                        </a>
                        <a ng-click="deleteClass({{$class->id}})">
                            <i class="fas fa-trash-alt"></i>Xóa
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @include('popup.add_class_modal')

    @include('popup.add_class_modal_step_2')

    @include('popup.schedule_detail_modal')

    @include('popup.score_modal')
</div>

<script type="text/javascript">
    $('#scheduleDetail input[name="ok"]').click(function() {
        $('#scheduleDetail').modal('hide');
    })
    $('#scheduleDetail').on('hide.bs.modal', function() {
        $('#scheduleClassModal').modal('show', 300);
    });
</script>