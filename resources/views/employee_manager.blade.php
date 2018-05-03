<div id="addcourse" class="addbutton hvr-sweep-to-right" data-name="Thêm khóa học">Thêm nhân viên</div>
<table id="example" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Mã nhân viên</th>
            <th>Tên</th>
            <th>Địa chỉ</th>
            <th>Số điện thoại</th>
            <th>Email</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($employees as $e)
            <tr>
                <td>{{$e->id}}</td>
                <td>{{$e->name}}</td>
                <td>{{$e->address}}</td>
                <td>{{$e->phone}}</td>
                <td class="email">{{$e->mail}}</td>
                <td class="action">
                    <a id='edit' data-name="Sửa khóa học" data-id='{{$e->id}}'><i class="fas fa-edit"></i>Sửa</a><a><i class="fas fa-trash-alt"></i>Xóa</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>