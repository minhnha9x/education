<div id="addcourse" class="addbutton hvr-sweep-to-right" data-name="Thêm khóa học">Thêm mã giảm giá</div>
<table id="example" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Mã giảm giá</th>
            <th>% giảm giá</th>
            <th>Khóa học áp dụng</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($promotion as $p)
            <tr>
                <td>{{$p->code}}</td>
                <td>{{$p->benefit}}</td>
                <td>{{$p->name}}</td>
                <td class="action">
                    <a id='edit' data-name="Sửa khóa học" data-id='{{$p->code}}'><i class="fas fa-edit"></i>Sửa</a><a><i class="fas fa-trash-alt"></i>Xóa</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>