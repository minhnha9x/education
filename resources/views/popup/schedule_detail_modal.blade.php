<div id="scheduleDetail" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 800px">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                    <form method="POST" role="form">
                        <h2 id="form-title">Add class</h2>
                        <div class="form-sub-w3 col-md-6">
                            <select name="subject" class="checkchange">
                                <option disabled selected hidden>Môn học</option>
                                <option value="1">A</option>
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <select name="subject" class="checkchange">
                                <option disabled selected hidden>Môn học</option>
                                <option value="1">A</option>
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <select name="subject" class="checkchange">
                                <option disabled selected hidden>Môn học</option>
                                <option value="1">A</option>
                            </select>
                        </div>            
                        <div class="submit-w3l col-md-12">
                            <input type="button" disabled name="change" ng-click="getCheckedList(); getRoomAvailableList()" style="float: right;" value="Create Class">
                        </div>
                    </form>
                </div>      
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->