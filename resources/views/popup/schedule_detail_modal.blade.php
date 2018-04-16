<div id="scheduleDetail" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 800px">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                    <form method="POST" role="form">
                        <h2 id="form-title">Add class</h2>
                        <div class="form-sub-w3 col-md-6">
                            <select name="subject" class="checkchange" ng-model="room_in_cell">
                                <option disabled selected hidden>Phòng học</option>
                                <option value="1">Phong 102 (1/6)</option>
                                <option value="1">Phong 202 (3/6)</option>
                                <option value="1">Phong 305 (1/6)</option>
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <select name="subject" class="checkchange" ng-model="teacher_in_cell">
                                <option disabled selected hidden>Giáo viên</option>
                                <option value="1">Giáo viên A (2/6)</option>
                                <option value="1">Giáo viên B (1/6)</option>
                                <option value="1">Giáo viên C (1/6)</option>
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <select name="subject" class="checkchange" ng-model="ta_in_cell">
                                <option disabled selected hidden>Trợ giảng</option>
                                <option value="1">Trợ giảng 1 (6/6)</option>
                                <option value="1">Trợ giảng 2 (5/6)</option>
                                <option value="1">Trợ giảng 3 (1/6)</option>
                            </select>
                        </div>            
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