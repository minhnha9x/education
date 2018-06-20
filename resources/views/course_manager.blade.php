<div ng-controller="CourseController">
    <div class="addbutton hvr-sweep-to-right" ng-click="showModal(1, -1)">Thêm khóa học</div>
    <table id="courseTable" class="table table-hover" st-table="courseCollection" st-safe-src="courseInfo">
        <thead>
            <tr>
                <th>Tên khóa học</th>
                <th>Môn học</th>
                <th>Số buổi học</th>
                <th>Số lớp học</th>
                <th>Số trợ giảng mỗi lớp</th>
                <th>Học phí</th>
                <th>Môn tiên quyết</th>
                <th>Hành động</th>
            </tr>
            <tr>
                <th class="search"><input st-search="name" placeholder="Tìm theo Tên" class="input-sm form-control" type="search"/></th>
                <th class="search"><input st-search="subject" placeholder="Tìm theo Môn học" class="input-sm form-control" type="search"/></th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="x in courseCollection">
                <td><% x.name %></td>
                <td><% x.subject %></td>
                <td><% x.total_of_period %></td>
                <td><% x.count %></td>
                <td><% x.teaching_assistant %></td>
                <td><% x.price | number: 0 %> VNĐ</td>
                <td><% x.certificate_required %></td>
                <td class="action">
                    <a class='edit' ng-click="showModal(2, x.id)"><i class="fas fa-edit"></i>Sửa</a><a ng-click="delete(x.id)"><i class="fas fa-trash-alt"></i>Xóa</a>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7" class="text-center">
                    <div st-pagination="" st-items-by-page="10"></div>
                </td>
            </tr>
        </tfoot>
    </table>

    @include('popup.add_course_modal')
</div>