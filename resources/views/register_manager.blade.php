<div ng-controller="RegisterController">
    <div class="loading"></div>
    <table id="registerTable" class="table table-hover hidden" st-table="displayedCollection" st-safe-src="registerInfo">
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
            <tr>
                <th class="search"><input st-search="name" placeholder="Tìm theo Tên học viên" class="input-sm form-control" type="search"/></th>
                <th class="search"><input st-search="mail" placeholder="Tìm theo Email" class="input-sm form-control" type="search"/></th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="x in displayedCollection">
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
        <tfoot>
            <tr>
                <td colspan="7" class="text-center">
                    <div st-pagination="" st-items-by-page="2" st-displayed-pages="7"></div>
                </td>
            </tr>
        </tfoot>
    </table>
</div>