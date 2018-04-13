<div id="addClassModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 800px">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                    <form method="POST" role="form">
                        <h2 id="form-title">Add class</h2>
                        <div class="form-sub-w3 col-md-4">
                            <select name="subject" class="checkchange">
                                <option disabled selected hidden>Môn học</option>
                                @foreach ($subjects as $s)
                                    <option value="{{$s->id}}">{{$s->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-4">
                            <select name="course" ng-model="courseSelected" ng-change="courseUpdated()">
                                <option ng-repeat="(id, name) in courseList" value="<% id %>"><% name %></option>
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-4">
                            <select name="office" ng-model="officeSelected" ng-change="officeUpdated()">
                                <option ng-repeat="office in officeList" value="<% office.id %>"><% office.name %></option>
                            </select>
                        </div>
                        <div class="form-sub-w3 flexcenter col-md-6">
                            <span>Ngày khai giảng:</span>
                            <input type="date" value="{{date("Y-m-d")}}" placeholder="Ngày khai giảng" name="start_date" class="checkchange">
                        </div>
                        <div class="form-sub-w3 flexcenter col-md-6">
                            <span>Ngày kết thúc:</span>
                            <input type="date" value="{{date("Y-m-d")}}" placeholder="Ngày kết thúc" name="end_date" class="checkchange">
                        </div>
                        <div class="form-sub-w3 col-md-12">
                            <p>Chọn ngày học:</p>
                            <div class="checkbox-wrapper">
                                <div class="checkbox" ng-repeat="(key, value) in list_day_in_week">
                                    <label><input type="checkbox" value="<% key %>" ng-model="list_day_in_week[key]" ng-click="log()"><% key %></label>
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
                            <div>
                                <span>Số phòng tìm thấy: </span><span id='room_available'><% text %></span>
                            </div>
                        </div>
                        {!! csrf_field() !!}
                        <div class="submit-w3l col-md-12">
                            <input type="button" disabled name="change" ng-click="getCheckedList(); getRoomAvailableList()" style="float: right;" value="Create Class">
                        </div>
                    </form>
                </div>      
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->