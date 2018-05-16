<div ng-controller="EmployeeController">
    <div class="addbutton hvr-sweep-to-right" ng-click="showModal(1, -1)">Thêm nhân viên</div>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Mã nhân viên</th>
                <th>Tên</th>
                <th>Ngày sinh</th>
                <th>Địa chỉ</th>
                <th>Số điện thoại</th>
                <th>Email</th>
                <th>Trung tâm</th>
                <th>Chức vụ</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="x in employeeInfo">
                <td><% x.id %></td>
                <td><% x.name %></td>
                <td><% x.birthday %></td>
                <td><% x.address %></td>
                <td><% x.phone %></td>
                <td class="email"><% x.mail %></td>
                <td><% x.office %></td>
                <td><% x.position %></td>
                <td class="action">
                    <a id='edit' ng-click="showModal(2, x.id)"><i class="fas fa-edit"></i>Sửa</a><a ng-click="delete(x.id)"><i class="fas fa-trash-alt"></i>Xóa</a>
                </td>
            </tr>
        </tbody>
    </table>

    @include('popup.add_employee_modal')
</div>