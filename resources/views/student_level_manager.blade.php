<div ng-controller="StudentLevelController">
    <select class="page-select" ng-model="courseSelected">
        <option value="" disabled hidden selected>--Lựa chọn chứng chỉ--</option>
        <option ng-repeat="x in courseInfo" value="<% x.id %>"><% x.name %></option>
    </select>
    <div id="updateLevelButton" ng-click="updateLevel()" class="addbutton hvr-sweep-to-right" hidden>Cập nhật chứng chỉ</div>
    <div class="loading"></div>
    <table id="studentLevelTable" class="table table-hover" st-table="studentLevelCollection" st-safe-src="studentLevelInfo" hidden>
        <thead>
            <tr>
                <th st-sort="name">Tên học viên</th>
                <th st-sort="mail">Email</th>
                <th>Những chứng chỉ đã có</th>
            </tr>
            <tr>
                <th class="search"><input st-search="name" placeholder="Tìm theo Tên" class="input-sm form-control" type="search"/></th>
                <th class="search"><input st-search="subject" placeholder="Tìm theo Môn học" class="input-sm form-control" type="search"/></th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="x in studentLevelCollection" data-id="<% x.id %>">
                <td><% x.name %></td>
                <td><% x.email %></td>
                <td><% x.course %></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-center">
                    <div st-pagination="" st-items-by-page="10"></div>
                </td>
            </tr>
        </tfoot>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#studentLevelTable tbody').on('click', 'tr', function () {
            $(this).toggleClass('selected');
            if ($('#studentLevelTable tr.selected').length > 0)
                $('#updateLevelButton').show();
            else
                $('#updateLevelButton').hide();
        });
    });
</script>