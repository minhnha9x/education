<div ng-controller="CourseController">
    <div class="col-xs-12" style="padding: 0;">
        <div class="addbutton hvr-sweep-to-right" ng-click="showModal(1, -1)">Thêm khóa học</div>
    </div>
    <table id="courseTable" class="table table-bordered bordered table-striped table-condensed datatable">
        <thead>
            <tr>
                <th>Tên khóa học</th>
                <th>Môn học</th>
                <th>Số buổi học</th>
                <th>Số lớp học</th>
                <th>Học phí</th>
                <th>Môn tiên quyết</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="x in courseInfo" on-finish-render="test()">
                <td><% x.name %></td>
                <td><% x.subject %></td>
                <td><% x.total_of_period %></td>
                <td><% x.count %></td>
                <td><% x.price | number: 0 %> VNĐ</td>
                <td><% x.certificate_required %></td>
                <td class="action">
                    <a class='edit' ng-click="showModal(2, x.id)"><i class="fas fa-edit"></i>Sửa</a><a ng-click="delete(x.id)"><i class="fas fa-trash-alt"></i>Xóa</a>
                </td>
            </tr>
        </tbody>
    </table>

    @include('popup.add_course_modal')
</div>