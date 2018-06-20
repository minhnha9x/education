<div id="workerModal" class="modal admin-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 650px">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                    <form role="form" class="clearfix" ng-submit="addWorker(editWorker)">
                        <h2 id="form-title"><% button %></h2>
                        <div class="form-sub-w3 col-md-6">
                            <select ng-model="workerNameSelected" ng-show="showSelect" ng-required="showSelect">
                                <option value="" selected disabled hidden>Tên nhân viên</option>
                                <option ng-repeat="x in listEmployeeInfo" value="<% x.id %>"><% x.name %> (<% x.mail %>)</option>
                            </select>
                            <input type="text" ng-model="workerName" disabled ng-show="!showSelect">
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <select ng-model="workerOffice" required>
                                <option value="" selected disabled hidden>Trung tâm</option>
                                <option ng-repeat="x in officeInfo" value="<% x.id %>"><% x.name %></option>
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <select ng-model="workerPosition" required>
                                <option value="" selected disabled hidden>Vị trí</option>
                                <option ng-repeat="x in positionInfo" value="<% x.id %>"><% x.name %></option>
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <input type="number" ng-model="workerExperience" required placeholder="Số năm kinh nghiệm">
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