<div ng-controller="EmployeeController" id="employee_manager_wrapper">
    <select class="page-select" ng-model="employeeType" ng-change="changeTable()">
        <option value="1">Nhân viên văn phòng</option>
        <option value="2">Giáo viên</option>
        <option value="3">Trợ giảng</option>
    </select>
    <div class="addbutton hvr-sweep-to-right" ng-click="showEmployeeModal(1, -1)">Thêm nhân viên</div>
    <div class="addbutton hvr-sweep-to-right" ng-click="showTeacherModal(1, -1)">Thêm giáo viên</div>
    <div class="addbutton hvr-sweep-to-right" ng-click="showTAModal(1, -1)">Thêm trợ giảng</div>

    <table id="employeeTable" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Mã nhân viên</th>
                <th>Tên nhân viên</th>
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
                    <a id='edit' ng-click="showEmployeeModal(2, x.id)"><i class="fas fa-edit"></i>Sửa</a><a ng-click="deleteEmployee(x.id)"><i class="fas fa-trash-alt"></i>Xóa</a>
                </td>
            </tr>
        </tbody>
    </table>

    <table id="teacherTable" class="table table-bordered table-hover" hidden>
        <thead>
            <tr>
                <th>Mã giáo viên</th>
                <th>Tên giáo viên</th>
                <th>Email</th>
                <th>Bằng cấp</th>
                <th>Dạy các khóa</th>
                <th>Làm việc tại các trung tâm</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="x in teacherInfo">
                <td><% x.id %></td>
                <td><% x.name %></td>
                <td class="email"><% x.mail %></td>
                <td><% x.degree %></td>
                <td><% x.course %></td>
                <td><% x.office %></td>
                <td class="action">
                    <a id='edit' ng-click="showTeacherModal(2, x.id)"><i class="fas fa-edit"></i>Sửa</a><a ng-click="deleteTeacher(x.id)"><i class="fas fa-trash-alt"></i>Xóa</a>
                </td>
            </tr>
        </tbody>
    </table>

    @include('popup.add_teacher_modal')

    @include('popup.add_employee_modal')
</div>