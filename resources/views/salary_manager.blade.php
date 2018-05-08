<div class="container" ng-controller="salaryController">
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
        <table id="example" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Mã nhân viên</th>
                    <th>Tên nhân viên</th>
                    <th>Chức vụ</th>
                    <th>Mức lương</th>
                    <th>Lương</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="obj in salaryInfo">
                    <td><% obj.id %></td>
                    <td><% obj.name %></td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td><% obj.salary %></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>