<div class="container" ng-controller="SalaryController">
    <div>
        <select class="page-select" name="month" ng-model="monthSelected">
            <option value="" disabled hidden selected>--Month--</option>
            <option value="1">January</option>
            <option value="2">February</option>
            <option value="3">March</option>
            <option value="4">April</option>
            <option value="5">May</option>
            <option value="6">June</option>
            <option value="7">July</option>
            <option value="8">August</option>
            <option value="9">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
        </select>
        <select class="page-select" name="year" ng-model="yearSelected">
            <option value="" disabled hidden selected>--Year--</option>
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
</div>