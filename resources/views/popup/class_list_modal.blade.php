<div id="classInfoModal" class="modal homepage-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 1000px;">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                    <h2 id="form-title">Danh sách lớp học</h2>
                    <table id="example" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Mã lớp</th>
                                <th>Trung tâm</th>
                                <th>Lịch học</th>
                                <th>Giáo viên</th>
                                <th>Sĩ số hiện tại</th>
                                <th>Ngày khai giảng</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="x in scheduleClassInfo">
                                <td><% x.id %></td>
                                <td><% x.office %></td>
                                <td style="white-space: nowrap;">
                                    <span ng-repeat="y in scheduleInfo" ng-if="y.class == x.id">
                                        <% y.current_date | strReplace:'Monday': 'Thứ Hai' | strReplace: 'Tuesday': 'Thứ Ba' | strReplace: 'Wednesday': 'Thứ Tư' | strReplace: 'Thursday': 'Thứ Năm' | strReplace: 'Friday': 'Thứ Sáu' | strReplace: 'Saturday': 'Thứ Bảy' | strReplace: 'Sunday': 'Chủ Nhật' %>: <% y.start_time | limitTo: 5 %> - <% y.end_time | limitTo: 5 %> (Phòng <% y.room %>)<br>
                                    </span>
                                </td>
                                <td>
                                    <span ng-repeat="y in teacherInfo" ng-if="y.class == x.id" style="white-space: nowrap;">
                                        <div class="img" style="background-image: url('<% y.avatar %>'); position: relative;">
                                            <div class="speech">
                                                <div class="img" style="background-image: url('<% y.avatar %>'); position: relative;"></div>
                                                <div class="info"><% y.name %></div>
                                                <div class="info"><% y.degree %></div>
                                            </div>
                                        </div>
                                    </span>
                                </td>
                                <td><% x.count %> / <% x.max_student %></td>
                                <td><% x.start_date | date: "dd/MM/y" %></td>
                                @if (Auth::check())
                                    <td class="action">
                                        <a ng-click="modalRegisterShow(x.id)">Đăng kí</a>
                                    </td>
                                @else
                                    <td class="action">
                                        <a ng-click="modalLoginShow()">Đăng kí</a>
                                    </td>
                                @endif
                                    
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->