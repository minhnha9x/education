<div id="addcourse" class="addbutton hvr-sweep-to-right" data-name="Thêm khóa học">Thêm Trung tâm</div>
<table id="example" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Mã trung tâm</th>
            <th>Tên trung tâm</th>
            <th>Địa chỉ</th>
            <th>Số điện thoại</th>
            <th>Email</th>
            <th>Vị trí</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($offices as $office)
            <tr>
                <script>
                    //console.log(<?= json_encode($office); ?>);
                </script>
                <td>{{$office->id}}</td>
                <td>{{$office->name}}</td>
                <td>{{$office->address}}</td>
                <td>{{$office->phone}}</td>
                <td>{{$office->mail}}</td>
                <td>
                    <a target="_blank" href="{{$office->location}}">Google Map</a>
                </td>
                <td class="action">
                    <a id='edit' data-name="Sửa khóa học" data-id='{{$office->id}}'><i class="fas fa-edit"></i>Sửa</a><a><i class="fas fa-trash-alt"></i>Xóa</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>