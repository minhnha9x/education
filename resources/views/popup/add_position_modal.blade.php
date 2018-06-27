<div id="positionModal" class="modal admin-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 650px">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                    <form role="form" class="clearfix" ng-submit="addPosition(edit)">
                        <h2 id="form-title"><% button %></h2>
                        <div class="form-sub-w3 col-md-6">
                            <input type="text" placeholder="Chức vụ" ng-model="positionName" required>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <input type="number" placeholder="Lương cơ bản" ng-model="positionSalary" required>
                        </div>
                        <div class="form-sub-w3 col-md-12" style="display: block">
                            <select required ng-model="positionUnit">
                                <option value="" disabled selected hidden>Đơn vị tính</option>
                                <option value="month">Tháng</option>
                                <option value="lesson">Buổi dạy</option>
                            </select>
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