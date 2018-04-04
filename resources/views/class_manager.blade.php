<div id="addcourse" class="addbutton hvr-sweep-to-right" data-name="Thêm khóa học">Thêm lớp học</div>
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