<div class="container" ng-controller="SalaryController">
    <div class="addbutton hvr-sweep-to-right" ng-click="showModal(1, -1)">Thêm chức vụ</div>
    <div class="loading"></div>
    <table id="positionTable" class="table table-hover" st-table="positionCollection" st-safe-src="positionInfo" hidden style="margin-bottom: 40px;">
        <thead>
            <tr>
                <th st-sort="name">Chức vụ</th>
                <th st-sort="salary">Lương cơ bản</th>
                <th st-sort="unit">Đơn vị tính</th>
                <th>Hành động</th>
            </tr>
            <tr>
                <th class="search"><input st-search="name" placeholder="Tìm theo Tên" class="input-sm form-control" type="search"/></th>
                <th class="search"><input st-search="subject" placeholder="Tìm theo Lương" class="input-sm form-control" type="search"/></th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="x in positionCollection">
                <td><% x.name %></td>
                <td><% x.salary | number: 0 %> VNĐ</td>
                <td><% x.unit %></td>
                <td class="action">
                    <a class='edit' ng-click="showModal(2, x.id)"><i class="fas fa-edit"></i>Sửa</a>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-center">
                    <div st-pagination="" st-items-by-page="10"></div>
                </td>
            </tr>
        </tfoot>
    </table>
    <div>
        <select class="page-select" name="month" ng-model="monthSelected">
            <option value="" disabled hidden selected>--Tháng--</option>
            <option value="1">Tháng một</option>
            <option value="2">Tháng hai</option>
            <option value="3">Tháng ba</option>
            <option value="4">Tháng tư</option>
            <option value="5">Tháng năm</option>
            <option value="6">Tháng sáu</option>
            <option value="7">Tháng bảy</option>
            <option value="8">Tháng tám</option>
            <option value="9">Tháng chín</option>
            <option value="10">Tháng mười</option>
            <option value="11">Tháng mười một</option>
            <option value="12">Tháng mười hai</option>
        </select>
        <select class="page-select" name="year" ng-model="yearSelected">
            <option value="" disabled hidden selected>--Năm--</option>
            <option value="2018">2018</option>
            <option value="2017">2017</option>
        </select>
        <div class="addbutton" style="float: none; display: inline-block;" ng-click='update()'>Xem bảng lương</div>
    </div>
    <div>
        <table id="salaryTable" class="table table-hover" st-table="salaryCollection" st-safe-src="salaryInfo" hidden>
            <thead>
                <tr>
                    <th>Tên nhân viên</th>
                    <th>Email</th>
                    <th>Chức vụ</th>
                    <th>Mức lương</th>
                    <th>Lương</th>
                </tr>
                <tr>
                    <th class="search"><input st-search="name" placeholder="Tìm theo Tên" class="input-sm form-control" type="search"/></th>
                    <th class="search"><input st-search="mail" placeholder="Tìm theo Email" class="input-sm form-control" type="search"/></th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="obj in salaryCollection">
                    <td><% obj.name %></td>
                    <td class="email"><% obj.mail %></td>
                    <td><% obj.position %></td>
                    <td><% obj.rate_salary %></td>
                    <td><% obj.salary | number: 0 %> VNĐ</td>
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
    </div>
    @include('popup.add_position_modal')
</div>