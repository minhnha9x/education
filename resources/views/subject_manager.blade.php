<div ng-controller="SubjectController">
    <div class="addbutton hvr-sweep-to-right" ng-click="showModal(1, -1)">Thêm môn học</div>
    <div class="loading"></div>
    <table id="subjectTable" class="table table-bordered table-hover" hidden>
        <thead>
            <tr>
                <th>Tên môn học</th>
                <th>Mô tả</th>
                <th>Số khóa đã mở</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="x in subjectInfo">
                <td><% x.name %></td>
                <td><% x.description %></td>
                <td><% x.count %></td>
                <td class="action">
                    <a id='edit' ng-click="showModal(2, x.id)"><i class="fas fa-edit"></i>Sửa</a><a ng-click="delete(x.id)"><i class="fas fa-trash-alt" ></i>Xóa</a>
                </td>
            </tr>
        </tbody>
    </table>

    @include('popup.add_subject_modal')
</div>