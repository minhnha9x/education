<div id="addcourse" class="addbutton hvr-sweep-to-right" data-name="Thêm khóa học">Thêm khóa học</div>
<table id="example" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên môn học</th>
            <th>Mô tả</th>
            <th>Số khóa đã mở</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($subjects as $subject)
            <tr>
                <script>
                    console.log(<?= json_encode($subject); ?>);
                </script>
                <td>{{$subject->id}}</td>
                <td>{{$subject->name}}</td>
                <td>{{$subject->description}}</td>
                <td>{{$subject->count}}</td>
                <td class="action">
                    <a id='edit' data-name="Sửa khóa học" data-id='{{$subject->id}}'><i class="fas fa-edit"></i>Sửa</a><a><i class="fas fa-trash-alt"></i>Xóa</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>