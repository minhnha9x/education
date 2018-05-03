<script src="js/salaryController.js"></script>
<div class="container" ng-app="educationApp2" ng-controller="salaryController">
    <select name="month">
        <option value="0">January</option>
        <option value="1">February</option>
        <option value="2">March</option>
        <option value="3">April</option>
        <option value="4">May</option>
        <option value="5">June</option>
        <option value="6">July</option>
        <option value="7">August</option>
        <option value="8">September</option>
        <option value="9">October</option>
        <option value="10">November</option>
        <option value="11">December</option>
    </select>
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
            {{-- @foreach ($salary as $s)
                <tr>
                    <td>{{$s->id}}</td>
                    <td>{{$s->name}}</td>
                    <td></td>
                    <td></td>
                    <td>{{number_format($s->salary)}} VNĐ</td>
                </tr>
            @endforeach --}}
            <% test %>
            <tr ng-repeat="t in salary">
                <td><% t.id %></td>
            </tr>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    $('select[name="month"] option[value="' + new Date().getMonth() + '"]').attr('selected', 'selected');
</script>