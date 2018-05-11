<div id="scheduleDetail" class="modal admin-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 800px">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                    <form method="POST" role="form">
                        <h2 id="form-title">Add class</h2>
                        <div class="form-sub-w3 col-md-6">
                            <select name="subject" class="checkchange" ng-model="room_in_cell">
                                <option value="" disabled selected hidden>Phòng học</option>
                                <option ng-repeat="room_info in tempRoomList" value="<% room_info %>">Phòng <% room_info %></option>
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <select name="subject" class="checkchange" ng-model="teacher_in_cell">
                                <option value="" disabled selected hidden>Giáo viên</option>
                                <option ng-repeat="teacher_info in tempTeacherList" value="<% teacher_info[0] %>"><% teacher_info[1] %></option>
                            </select>
                        </div>
<!--                         <div disabled class="form-sub-w3 col-md-6">
                            <select name="subject" class="checkchange" ng-model="ta_in_cell">
                                <option value="" disabled hidden>Trợ giảng</option>
                                <option selected value="1">Trợ giảng 1 (6/6)</option>
                                <option value="1">Trợ giảng 2 (5/6)</option>
                                <option value="1">Trợ giảng 3 (1/6)</option>
                            </select>
                        </div>    -->
                        <div class="submit-w3l col-md-12">
                            <input type="button" ng-click="unSelected()" style="float: left;" value="Reset">
                            <input type="button" name="ok" ng-click="setSelected()" style="float: right;" value="OK">
                        </div>
                    </form>
                </div>      
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->