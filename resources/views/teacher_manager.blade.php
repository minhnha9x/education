<div ng-controller="TeacherController">
    <div class="addbutton hvr-sweep-to-right" ng-click="showModal(1, -1)">Thêm giáo viên</div>
    <table class="table table-bordered table-hover">
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
            <tr ng-repeat="x in teacherInfo">
                <td><% x.id %></td>
                <td><% x.name %></td>
                <td><% x.degree %></td>
                <td><% x.course %></td>
                <td><% x.office %></td>
                <td class="action">
                    <a id='edit' ng-click="showModal(2, x.id)"><i class="fas fa-edit"></i>Sửa</a><a ng-click="showModal(2, x.id)"><i class="fas fa-trash-alt"></i>Xóa</a>
                </td>
            </tr>
        </tbody>
    </table>

    @include('popup.add_teacher_modal')
</div>