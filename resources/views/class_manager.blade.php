<div class="" ng-controller="ClassController">
    <div ng-click="addClass()" class="addbutton hvr-sweep-to-right">Thêm lớp học</div>
    <div class="loading"></div>
    <table id="classTable" class="table table-bordered table-hover" hidden>
        <thead>
            <tr>
                <th>Mã lớp</th>
                <th>Khóa học</th>
                <th>Lịch học</th>
                <th>Trung tâm</th>
                <th>Sĩ số</th>
                <th>Ngày khai giảng</th>
                <th>Ngày kết thúc</th>
                <th>Bảng điểm</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="x in classInfo">
                <td><% x.id %></td>
                <td><% x.course %></td>
                <td>
                    <div ng-repeat="y in scheduleInfo" ng-if="(y.class == x.id)" style="white-space: nowrap;">
                        <% y.current_date %>: <% date('H:i', strtotime(y.start_time)) %> - <% date('H:i', strtotime(y.end_time)) %> (Phòng <% y.room %>)
                    </div>
                </td>
                <td><% x.office %></td>
                <td style="white-space: nowrap;"><% x.count %> / <% x.max_student %></td>
                <td><% x.start_date | date: "dd/MM/y" %></td>
                <td><% x.end_date | date: "dd/MM/y" %></td>
                <td><a ng-click="showScore(x.id)"><i class="fas fa-eye"></i></a></td>
                <td class="action">
                    <a id='edit' data-name="Sửa khóa học" data-id='<% x.id %>'>
                        <i class="fas fa-edit"></i>Sửa
                    </a>
                    <a ng-click="deleteClass(x.id)">
                        <i class="fas fa-trash-alt"></i>Xóa
                    </a>
                </td>
            </tr>
        </tbody>
    </table>

    @include('popup.add_class_modal')

    @include('popup.add_class_modal_step_2')

    @include('popup.schedule_detail_modal')

    @include('popup.score_modal')
</div>

<script type="text/javascript">
    $('#scheduleDetail input[name="ok"]').click(function() {
        $('#scheduleDetail').modal('hide');
    })
    $('#scheduleDetail').on('hide.bs.modal', function() {
        $('#scheduleClassModal').modal('show', 300);
    });
</script>