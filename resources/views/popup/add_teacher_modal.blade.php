<div id="teacherModal" class="modal admin-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 650px">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                    <form role="form" class="clearfix" ng-submit="addTeacher(editTeacher)">
                        <h2 id="form-title"><% button %></h2>
                        <div class="form-sub-w3 col-md-6">
                            <select ng-model="teacherNameSelected" ng-show="showSelect" ng-required="showSelect">
                                <option value="" selected disabled hidden>Tên giáo viên</option>
                                <option ng-repeat="x in listEmployeeInfo" value="<% x.id %>"><% x.name %> (<% x.mail %>)</option>
                            </select>
                            <input type="text" ng-model="teacherName" disabled ng-show="!showSelect">
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <input type="text" placeholder="Bằng cấp" ng-model="teacherDegree" required>
                        </div>
                        <div class="form-sub-w3 col-md-12" style="display: block">
                            <p>Dạy những trung tâm:</p>
                            <div class="checkbox-wrapper office-wrapper" style="display: block">
                                <div class="checkbox" ng-repeat="x in officeInfo" style="margin-bottom: 0">
                                    <label><input type="checkbox" value="<% x.id %>"><% x.name %></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-sub-w3 col-md-12" style="display: block">
                            <p>Dạy những khóa học:</p>
                            <div class="checkbox-wrapper course-wrapper" style="display: block">
                                <div class="checkbox" ng-repeat="x in courseInfo" style="margin-bottom: 0">
                                    <label><input type="checkbox" value="<% x.id %>"><% x.name %></label>
                                </div>
                            </div>
                        </div>
                        {!! csrf_field() !!}
                        <div class="submit-w3l col-md-12">
                            <input type="submit" value="<% button %>">
                        </div>
                    </form>
                </div>      
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>