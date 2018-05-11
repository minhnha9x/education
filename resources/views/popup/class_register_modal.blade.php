<div id="addClassModal" class="modal admin-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 800px">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                    <form method="POST" role="form">
                        <h2 id="form-title">Add class</h2>
                        <div class="form-sub-w3 col-md-4">
                            <select name="subject" class="checkchange" ng-model="subjectSelected" ng-change="subjectUpdated()">
                                <option value="" disabled selected hidden>Môn học</option>
                                @foreach ($subjects as $s)
                                    <option value="{{$s->id}}">{{$s->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-4">
                            <select name="course" ng-model="courseSelected" ng-change="courseUpdated()">
                                <option value="" disabled selected hidden>Khóa Học</option>
                                <option ng-repeat="course in courseList" value="<% course.id %>"><% course.name %></option>
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-4">
                            <select name="office" ng-model="officeSelected" ng-change="officeUpdated()">
                                <option value="" disabled selected hidden>Chi Nhánh</option>
                                <option ng-repeat="office in officeList" value="<% office.id %>"><% office.name %></option>
                            </select>
                        </div>
                        <div class="form-sub-w3 flexcenter col-md-6">
                            <span>Ngày khai giảng:</span>
                            <input type="date" ng-model="startDate" ng-change="updateStartDate()">
                        </div>
                        <div class="form-sub-w3 flexcenter col-md-6">
                            <span>Ngày kết thúc:</span>
                            <input type="date" disabled ng-model="endDate">
                        </div>
                        <div class="form-sub-w3 col-md-12" style="display: inline-block;">
                            <p>Chọn ngày học:</p>
                            <div class="checkbox-wrapper">
                                <div class="checkbox" ng-repeat="(key, value) in list_day_in_week">
                                    <label><input type="checkbox" value="<% key %>" ng-model="list_day_in_week[key]"><% key %></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <select name="supervisor">
                                <option disabled selected hidden>Quản lí lớp học</option>
                                @foreach ($teachers as $t)
                                    <option value="{{$t->id}}">{{$t->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-12" style="display: inline-block;">
                            <span>Số phòng tìm thấy: </span><span id='room_available'><% text %></span>
                        </div>
                        {!! csrf_field() !!}
                        <div class="submit-w3l col-md-12">
                            <input type="button" disabled name="change" ng-click="getCheckedList(); getRoomAvailable(); getTeacherAvailable()" style="float: right;" value="Create Class">
                        </div>
                    </form>
                </div>      
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->