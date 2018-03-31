<div id="addcourse" class="addbutton hvr-sweep-to-right" data-name="Thêm khóa học">Thêm phòng học</div>
<table id="example" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Mã phòng</th>
            <th>Thuộc trung tâm</th>
            <th>Sức chứa</th>
            <th>Dành cho các khóa</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rooms as $room)
            <tr>
                <script>
                    console.log(<?= json_encode($room); ?>);
                </script>
                <td>{{$room->id}}</td>
                <td>{{$room->office}}</td>
                <td>{{$room->max_student}}</td>
                <td>{{$room->course}}</td>
                <td class="action">
                    <a id='edit' data-name="Sửa khóa học" data-id='{{$room->id}}'><i class="fas fa-edit"></i>Sửa</a><a><i class="fas fa-trash-alt"></i>Xóa</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>