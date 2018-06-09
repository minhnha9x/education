<div id="subjectModal" class="modal admin-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 650px">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                    <form role="form" class="clearfix" ng-submit="addSubject(edit, picFile)">
                        <h2 id="form-title"><% button %></h2>
                        <div class="col-md-6" style="padding: 0">
                            <div class="form-sub-w3 col-md-12">
                                <input type="text" placeholder="Tên môn học" ng-model="subjectName" required>
                            </div>
                            <div class="form-sub-w3 col-md-12">
                                <textarea rows="4" placeholder="Mô tả chi tiết" ng-model="subjectDesc" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-6" style="padding: 0">
                            <div class="col-md-12">
                                <img ngf-src="picFile">
                            </div>
                            <div class="form-sub-w3 col-xs-12">
                                <label for="uploadSubjectImg" class="btn">Chọn hình ảnh cho môn học</label>
                                <input id="uploadSubjectImg" type="file" ngf-select ng-model="picFile" name="file" ngf-accept="'image/*'" style="display: none;">
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