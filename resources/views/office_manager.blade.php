<div ng-controller="OfficeController">
    <div class="addbutton hvr-sweep-to-right" ng-click="showModal(1, -1)">Thêm Trung tâm</div>
    <div class="loading"></div>
    <table id="officeTable" class="table table-bordered table-hover" hidden>
        <thead>
            <tr>
                <th>Tên trung tâm</th>
                <th>Địa chỉ</th>
                <th>Số điện thoại</th>
                <th>Email</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="x in officeInfo">
                <td><% x.name %></td>
                <td><% x.address %></td>
                <td><% x.phone %></td>
                <td><% x.mail %></td>
                <td class="action">
                    <a id='edit' ng-click="showModal(2, x.id)"><i class="fas fa-edit"></i>Sửa</a><a ng-click="delete(x.id)"><i class="fas fa-trash-alt"></i>Xóa</a>
                </td>
            </tr>
        </tbody>
    </table>

    @include('popup.add_office_modal')
</div>