<div ng-controller="RoomController">
    <div class="addbutton hvr-sweep-to-right" ng-click="showModal(1, -1)">Thêm phòng học</div>
    <div class="loading"></div>
    <table id="roomTable" class="table table-hover" st-table="roomCollection" st-safe-src="roomInfo" hidden>
        <thead>
            <tr>
                <th st-sort="id">Mã phòng</th>
                <th st-sort="office">Thuộc trung tâm</th>
                <th st-sort="max_student">Sức chứa</th>
                <th>Dành cho các khóa</th>
                <th>Hành động</th>
            </tr>
            <tr>
                <th class="search"></th>
                <th class="search"><input st-search="office" placeholder="Tìm theo Trung tâm" class="input-sm form-control" type="search"/></th>
                <th class="search"></th>
                <th class="search"><input st-search="course" placeholder="Tìm theo Khóa" class="input-sm form-control" type="search"/></th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="x in roomCollection">
                <td><% x.id %></td>
                <td><% x.office %></td>
                <td><% x.max_student %></td>
                <td><% x.course %></td>
                <td class="action">
                    <a id='edit' ng-click="showModal(2, x.id)"><i class="fas fa-edit"></i>Sửa</a><a ng-click="delete(x.id)"><i class="fas fa-trash-alt"></i>Xóa</a>
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

    @include('popup.add_room_modal')
</div>