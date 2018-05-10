<div id="courseModal" class="modal admin-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 650px">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                    <form role="form" class="clearfix" ng-submit="addCourse(edit)">
                        <h2 id="form-title"><% button %></h2>
                        <div class="form-sub-w3 col-md-6">
                            <input type="text" placeholder="Tên khóa học" ng-model="courseName" required>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <select name="subject" required ng-model="subjectName" ng-change="updateCourseList(subjectName)">
                                <option value="" disabled selected hidden>Môn học</option>
                                <option ng-repeat="x in subjectInfo" value="<% x.id %>"><% x.name %></option>
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <input type="number" placeholder="Học phí" ng-model="coursePrice" required>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <input type="number" placeholder="Tổng số buổi học" ng-model="total_of_period" required>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <select name="required" ng-model="certificate_required">
                                <option value="" selected>Khóa học tiên quyết</option>
                                <option ng-repeat="x in courseList" value="<% x.id %>"><% x.name %></option>
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-12">
                            <textarea rows="4" ng-model="courseDesc" placeholder="Mô tả chi tiết" required></textarea>
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
</div><!-- /.modal -->