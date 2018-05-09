<div id="subjectModal" class="modal admin-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 650px">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                    <form role="form" class="clearfix" ng-submit="addSubject(edit)">
                        <h2 id="form-title"><% button %></h2>
                        <div class="form-sub-w3 col-md-6">
                            <input type="text" placeholder="Tên môn học" ng-model="subjectName">
                        </div>
                        <div class="form-sub-w3 col-md-12">
                            <textarea rows="4" placeholder="Mô tả chi tiết" ng-model="subjectDesc"></textarea>
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