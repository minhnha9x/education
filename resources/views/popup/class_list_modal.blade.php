<div id="classInfoModal" class="modal homepage-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 1000px;">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                    <h2 class="col-xs-12">Khóa học <% courseInfo['name'] %></h2>
                    <div class="col-md-6 col-wrapper">
                        <div class="img" style="background-image: url(<% courseInfo['img_url'] %>)"></div>
                    </div>
                    <div class="col-md-6 col-wrapper">
                        <div class="info">Số buổi học: <% courseInfo['total_of_period'] %></div>
                        <div class="info">Học phí: <% courseInfo['price'] | number: 0 %> VNĐ</div>
                        <div class="info" ng-show="courseInfo['certificate_required'] != null">Khóa học tiên quyết: <% courseInfo['certificate_required'] %></div>
                        <div class="info">Mô tả khóa học: <% courseInfo['description'] %></div>
                    </div>
                    <h3 class="col-xs-12">Danh sách lớp học</h2>
                    <table id="example" class="table table-bordered table-hover col-xs-12">
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
                                <td>
                                    <span ng-repeat="y in countInfo" ng-if="y.id == x.id">
                                        <% y.count %> / <% x.max_student %>
                                    </span>
                                </td>
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