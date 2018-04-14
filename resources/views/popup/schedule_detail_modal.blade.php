<div id="scheduleDetail" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 800px">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                    <form method="POST" role="form">
                        <h2 id="form-title">Add class</h2>
                        <div class="form-sub-w3 col-md-6">
                            <select name="subject" class="checkchange">
                                <option disabled selected hidden>Phòng học</option>
                                <option value="1">Phong 102 &#xf243;</option>
                                <option value="1">Phong 202</option>
                                <option value="1">Phong 305</option>
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <select name="subject" class="checkchange">
                                <option disabled selected hidden>Giáo viên</option>
                                <option value="1">Giáo viên A</option>
                                <option value="1">Giáo viên B</option>
                                <option value="1">Giáo viên C</option>
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <select name="subject" class="checkchange">
                                <option disabled selected hidden>Trợ giảng</option>
                                <option value="1">Trợ giảng 1</option>
                                <option value="1">Trợ giảng 2</option>
                                <option value="1">Trợ giảng 3</option>
                            </select>
                        </div>            
                        <div class="submit-w3l col-md-12">
                            <input type="button" name="ok" ng-click="getCheckedList(); getRoomAvailableList()" style="float: right;" value="OK">
                        </div>
                    </form>
                </div>      
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->