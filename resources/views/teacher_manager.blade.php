<div id="addcourse" class="addbutton hvr-sweep-to-right" data-name="Thêm khóa học">Thêm giáo viên</div>
<table id="example" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Mã giáo viên</th>
            <th>Tên giáo viên</th>
            <th>Bằng cấp</th>
            <th>Dạy các khóa</th>
            <th>Làm việc tại các trung tâm</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($teachers as $teacher)
            <tr>
                {{-- <script>
                    console.log(<?= json_encode($teacher); ?>);
                </script> --}}
                <td>{{$teacher->id}}</td>
                <td>{{$teacher->name}}</td>
                <td>{{$teacher->degree}}</td>
                <td>{{$teacher->course}}</td>
                <td>{{$teacher->office}}</td>
                <td class="action">
                    <a id='edit' data-name="Sửa khóa học" data-id='{{$teacher->id}}'><i class="fas fa-edit"></i>Sửa</a><a><i class="fas fa-trash-alt"></i>Xóa</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>