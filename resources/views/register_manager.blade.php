<div ng-controller="RegisterController">
    <div id="updateFeeButton" ng-click="updateFee()" class="addbutton hvr-sweep-to-right" hidden>Cập nhật tình trạng học phí</div>
    <div class="loading"></div>
    <table id="registerTable" class="table table-hover" st-table="registerCollection" st-safe-src="registerInfo" hidden>
        <thead>
            <tr>
                <th>Tên học viên</th>
                <th>Email</th>
                <th>Lớp đăng kí</th>
                <th>Mã giảm giá</th>
                <th>Khóa học</th>
                <th>Thời gian đăng kí</th>
                <th>Học phí</th>
                <th>Hành động</th>
            </tr>
            <tr>
                <th class="search"><input st-search="name" placeholder="Tìm theo Tên học viên" class="input-sm form-control" type="search"/></th>
                <th class="search"><input st-search="mail" placeholder="Tìm theo Email" class="input-sm form-control" type="search"/></th>
                <th class="search"><input st-search="class" placeholder="Tìm theo Lớp" class="input-sm form-control" type="search"/></th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="x in registerCollection" data-id="<% x.id %>">
                <td><% x.name %></td>
                <td><% x.mail %></td>
                <td><% x.class %></td>
                <td><% x.promotion %></td>
                <td><% x.course %></td>
                <td><% x.created_date | date: "dd/MM/y (hh:mm:ss)" %></td>
                <td>
                    <img src="./img/checked.png" ng-show="x.fee_status">
                    <img src="./img/uncheck.png" ng-show="!x.fee_status">
                </td>
                <td class="action">
                    <a ng-click="delete(x.id)"><i class="fas fa-trash-alt"></i>Xóa</a>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="8" class="text-center">
                    <div st-pagination="" st-items-by-page="10"></div>
                </td>
            </tr>
        </tfoot>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#registerTable tbody').on('click', 'tr', function () {
            $(this).toggleClass('selected');
            if ($('#registerTable tr.selected').length > 0)
                $('#updateFeeButton').show();
            else
                $('#updateFeeButton').hide();
        });
    });
</script>