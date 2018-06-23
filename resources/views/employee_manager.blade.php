<div ng-controller="EmployeeController" id="employee_manager_wrapper">
    <select class="page-select" ng-model="employeeType" ng-change="changeTable()" ng-init="employeeType='0'">
        <option value="0">Tất cả nhân viên</option>
        <option value="1">Nhân viên văn phòng</option>
        <option value="2">Giáo viên</option>
        <option value="3">Trợ giảng</option>
    </select>
    <div class="addbutton hvr-sweep-to-right" ng-click="showEmployeeModal(1, -1)">Thêm nhân viên</div>
    <div class="addbutton hvr-sweep-to-right" ng-click="showWorkerModal(1, -1)">Thêm nhân viên văn phòng</div>
    <div class="addbutton hvr-sweep-to-right" ng-click="showTeacherModal(1, -1)">Thêm giáo viên</div>
    <div class="addbutton hvr-sweep-to-right" ng-click="showTAModal(1, -1)">Thêm trợ giảng</div>

    <div class="loading"></div>

    <table id="employeeTable" class="table table-hover" st-table="employeeCollection" st-safe-src="employeeInfo" hidden>
        <thead>
            <tr>
                <th>Tên nhân viên</th>
                <th>Email</th>
                <th>Ngày sinh</th>
                <th>Địa chỉ</th>
                <th>Số điện thoại</th>
                <th>Hành động</th>
            </tr>
            <tr>
                <th class="search"><input st-search="name" placeholder="Tìm theo Tên" class="input-sm form-control" type="search"/></th>
                <th class="search"><input st-search="mail" placeholder="Tìm theo Email" class="input-sm form-control" type="search"/></th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="x in employeeCollection">
                <td><% x.name %></td>
                <td class="email"><% x.mail %></td>
                <td style="white-space: nowrap;"><% x.birthday | date: "dd/MM/y" %></td>
                <td><% x.address %></td>
                <td><% x.phone %></td>
                <td class="action">
                    <a id='edit' ng-click="showEmployeeModal(2, x.id)"><i class="fas fa-edit"></i>Sửa</a><a ng-click="deleteEmployee(x.id)"><i class="fas fa-trash-alt"></i>Xóa</a>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-center">
                    <div st-pagination="" st-items-by-page="10"></div>
                </td>
            </tr>
        </tfoot>
    </table>

    <table id="workerTable" class="table table-hover" st-table="workerCollection" st-safe-src="workerInfo" hidden>
        <thead>
            <tr>
                <th>Tên nhân viên</th>
                <th>Email</th>
                <th>Trung tâm</th>
                <th>Vị trí</th>
                <th>Kinh nghiệm</th>
                <th>Hành động</th>
            </tr>
            <tr>
                <th class="search"><input st-search="name" placeholder="Tìm theo Tên" class="input-sm form-control" type="search"/></th>
                <th class="search"><input st-search="mail" placeholder="Tìm theo Email" class="input-sm form-control" type="search"/></th>
                <th class="search"><input st-search="office" placeholder="Tìm theo Trung tâm" class="input-sm form-control" type="search"/></th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="x in workerCollection">
                <td><% x.name %></td>
                <td class="email"><% x.mail %></td>
                <td><% x.office %></td>
                <td><% x.position %></td>
                <td><% x.experience %></td>
                <td class="action">
                    <a id='edit' ng-click="showWorkerModal(2, x.id)"><i class="fas fa-edit"></i>Sửa</a><a ng-click="deleteWorker(x.id)"><i class="fas fa-trash-alt"></i>Xóa</a>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-center">
                    <div st-pagination="" st-items-by-page="10"></div>
                </td>
            </tr>
        </tfoot>
    </table>

    <table id="teacherTable" class="table table-hover" st-table="teacherCollection" st-safe-src="teacherInfo" hidden>
        <thead>
            <tr>
                <th>Tên giáo viên</th>
                <th>Email</th>
                <th>Bằng cấp</th>
                <th>Dạy các khóa</th>
                <th>Làm việc tại các trung tâm</th>
                <th>Hành động</th>
            </tr>
            <tr>
                <th class="search"><input st-search="name" placeholder="Tìm theo Tên" class="input-sm form-control" type="search"/></th>
                <th class="search"><input st-search="mail" placeholder="Tìm theo Email" class="input-sm form-control" type="search"/></th>
                <th class="search"></th>
                <th class="search"><input st-search="course" placeholder="Tìm theo Khóa học" class="input-sm form-control" type="search"/></th>
                <th class="search"><input st-search="office" placeholder="Tìm theo Trung tâm" class="input-sm form-control" type="search"/></th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="x in teacherCollection">
                <td style="white-space: nowrap;"><% x.name %></td>
                <td class="email"><% x.mail %></td>
                <td><% x.degree %></td>
                <td><% x.course %></td>
                <td><% x.office %></td>
                <td class="action">
                    <a id='edit' ng-click="showTeacherModal(2, x.id)"><i class="fas fa-edit"></i>Sửa</a><a ng-click="deleteTeacher(x.id)"><i class="fas fa-trash-alt"></i>Xóa</a>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-center">
                    <div st-pagination="" st-items-by-page="10"></div>
                </td>
            </tr>
        </tfoot>
    </table>

    <table id="taTable" class="table table-hover" st-table="taCollection" st-safe-src="TAInfo" hidden>
        <thead>
            <tr>
                <th>Tên trợ giảng</th>
                <th>Email</th>
                <th>Bằng cấp</th>
                <th>Dạy các khóa</th>
                <th>Làm việc tại các trung tâm</th>
                <th>Hành động</th>
            </tr>
            <tr>
                <th class="search"><input st-search="name" placeholder="Tìm theo Tên" class="input-sm form-control" type="search"/></th>
                <th class="search"><input st-search="mail" placeholder="Tìm theo Email" class="input-sm form-control" type="search"/></th>
                <th class="search"></th>
                <th class="search"><input st-search="course" placeholder="Tìm theo Khóa học" class="input-sm form-control" type="search"/></th>
                <th class="search"><input st-search="office" placeholder="Tìm theo Trung tâm" class="input-sm form-control" type="search"/></th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="x in taCollection">
                <td style="white-space: nowrap;"><% x.name %></td>
                <td class="email"><% x.mail %></td>
                <td><% x.degree %></td>
                <td><% x.course %></td>
                <td><% x.office %></td>
                <td class="action">
                    <a id='edit' ng-click="showTAModal(2, x.id)"><i class="fas fa-edit"></i>Sửa</a><a ng-click="deleteTA(x.id)"><i class="fas fa-trash-alt"></i>Xóa</a>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-center">
                    <div st-pagination="" st-items-by-page="10"></div>
                </td>
            </tr>
        </tfoot>
    </table>

    @include('popup.add_teacher_modal')

    @include('popup.add_TA_modal')

    @include('popup.add_employee_modal')

    @include('popup.add_worker_modal')
</div>