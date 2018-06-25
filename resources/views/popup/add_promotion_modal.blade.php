<div id="promotionModal" class="modal admin-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 650px">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                    <form role="form" class="clearfix" ng-submit="addPromotion(edit)">
                        <h2 id="form-title"><% button %></h2>
                        <div class="form-sub-w3 col-md-6">
                            <input type="text" placeholder="Mã giảm giá" ng-model="promotionCode" required>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <input type="number" placeholder="% giảm giá" ng-model="promotionBenefit" required>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <span>Bắt đầu:</span>
                            <input type="date" ng-model="start_date" required>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <span>Kết thúc:</span>
                            <input type="date" ng-model="end_date" required>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <input type="number" placeholder="Giới hạn" ng-model="limited" required>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <select required ng-model="courseName">
                                <option value="" disabled selected hidden>Khóa học áp dụng</option>
                                <option ng-repeat="x in courseInfo" value="<% x.id %>"><% x.name %></option>
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