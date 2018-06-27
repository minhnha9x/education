<div class="" ng-controller="ClassController">
    <div ng-click="addClass()" class="addbutton hvr-sweep-to-right">Thêm lớp học</div>
    <div class="loading"></div>
    <table id="classTable" class="table table-hover" st-table="classCollection" st-safe-src="classInfo" hidden>
        <thead>
            <tr>
                <th st-sort="id">Mã lớp</th>
                <th st-sort="course">Khóa học</th>
                <th>Lịch học</th>
                <th st-sort="office">Trung tâm</th>
                <th st-sort="count">Sĩ số</th>
                <th st-sort="start_date">Ngày khai giảng</th>
                <th st-sort="end_date">Ngày kết thúc</th>
                <th>Bảng điểm</th>
                <th>Hành động</th>
            </tr>
            <tr>
                <th class="search"><input st-search="id" placeholder="Tìm theo Mã lớp" class="input-sm form-control" type="search"/></th>
                <th class="search"><input st-search="course" placeholder="Tìm theo Khóa học" class="input-sm form-control" type="search"/></th>
                <th class="search"></th>
                <th class="search"><input st-search="office" placeholder="Tìm theo Trung tâm" class="input-sm form-control" type="search"/></th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="x in classCollection">
                <td><% x.id %></td>
                <td><% x.course %></td>
                <td>
                    <div ng-repeat="y in scheduleInfo" ng-if="(y.class == x.id)" style="white-space: nowrap;">
                        <% y.current_date | strReplace:'Monday': 'Thứ Hai' | strReplace: 'Tuesday': 'Thứ Ba' | strReplace: 'Wednesday': 'Thứ Tư' | strReplace: 'Thursday': 'Thứ Năm' | strReplace: 'Friday': 'Thứ Sáu' | strReplace: 'Saturday': 'Thứ Bảy' | strReplace: 'Sunday': 'Chủ Nhật' %>: <% y.start_time | limitTo: 5 %> - <% y.end_time | limitTo: 5 %> (Phòng <% y.room %>)
                    </div>
                </td>
                <td><% x.office %></td>
                <td style="white-space: nowrap;">
                    <span ng-repeat="y in countInfo" ng-if="y.id == x.id">
                        <% y.count %> / <% x.max_student %>
                    </span>
                </td>
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
        <tfoot>
            <tr>
                <td colspan="9" class="text-center">
                    <div st-pagination="" st-items-by-page="10"></div>
                </td>
            </tr>
        </tfoot>
    </table>

    @include('popup.add_class_modal')

    @include('popup.add_class_modal_step_2')

    @include('popup.add_class_modal_step_3')

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