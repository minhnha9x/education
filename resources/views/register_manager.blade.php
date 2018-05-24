<div ng-controller="RegisterController">
    <div class="loading"></div>
    <table id="registerTable" class="table table-bordered table-hover hidden">
        <thead>
            <tr>
                <th>Tên học viên</th>
                <th>Email</th>
                <th>Lớp đăng kí</th>
                <th>Mã giảm giá</th>
                <th>Khóa học</th>
                <th>Thời gian đăng kí</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="x in registerInfo">
                <td><% x.name %></td>
                <td><% x.mail %></td>
                <td><% x.class %></td>
                <td><% x.promotion %></td>
                <td><% x.course %></td>
                <td><% x.created_date %></td>
                <td class="action">
                    <a ng-click="delete(x.id)"><i class="fas fa-trash-alt"></i>Xóa</a>
                </td>
            </tr>
        </tbody>
    </table>
</div>