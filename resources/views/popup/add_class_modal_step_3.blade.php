<div id="scheduleDetail" class="modal admin-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 800px">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                    <form method="POST" role="form">
                        <h2 id="form-title">Thông tin buổi học</h2>
                        <div class="form-sub-w3 col-md-6">
                            <select name="subject" class="checkchange" ng-model="room_in_cell">
                                <option value="" disabled selected hidden>Phòng học</option>
                                <option ng-repeat="room_info in tempRoomList" value="<% room_info %>">Phòng <% room_info %></option>
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <select name="teaching" class="checkchange" ng-model="teacher_in_cell" ng-change="updateTempTeachingList('main', teacher_in_cell)">
                                <option value="" disabled selected hidden>Giáo viên</option>
                                <option ng-repeat="teacher_info in tempTeacherList" value="<% teacher_info[0] %>"><% teacher_info[1] %></option>
                            </select>
                        </div>
                        <div ng-repeat="TA in TAList track by $index" class="form-sub-w3 col-md-6">
                            <select name="teaching" class="checkchange" ng-model="TAList[$index].TASelected" ng-change="updateTempTeachingList('ta_'+$index, TAList[$index].TASelected)">
                                <option value="" disabled hidden>Trợ giảng <% $index + 1 %></option>
                                <option ng-repeat="ta_info in tempTAList" value="<% ta_info[0] %>"><% ta_info[1] %></option>
                            </select>
                        </div>   
                        <div class="submit-w3l col-md-12">
                            <input type="button" ng-click="unSelected()" style="float: left;" value="Nhập lại">
                            <input type="button" name="ok" ng-click="setSelected()" style="float: right;" value="Lưu">
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->