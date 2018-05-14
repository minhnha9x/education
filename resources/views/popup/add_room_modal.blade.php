<div id="roomModal" class="modal admin-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 650px">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                    <form role="form" class="clearfix" ng-submit="addRoom(edit)">
                        <h2 id="form-title"><% button %></h2>
                        <div class="form-sub-w3 col-md-6">
                            <select required ng-model="officeName">
                                <option value="" disabled selected hidden>Trung tâm</option>
                                <option ng-repeat="x in officeInfo" value="<% x.id %>"><% x.name %></option>
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <input type="number" placeholder="Sức chứa" ng-model="roomLimit" required>
                        </div>
                        <div class="form-sub-w3 col-md-12" style="display: block">
                            <p>Chọn những khóa học phù hợp:</p>
                            <div class="checkbox-wrapper" style="display: block">
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
</div><!-- /.modal -->