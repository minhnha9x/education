<div id="scheduleClassModal" class="modal admin-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog schedule-modal" role="document">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                    <form method="POST" role="form">
                        <h2 id="form-title">Create class schedule</h2>
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th>Schedule</th>
                                <th ng-repeat="key in checkedList " style="width: 150px;"><% key %></th>
                            </tr>
                            <tr ng-repeat="(key, value) in slot_in_day">
                                <th><% value %></th>
                                <td ng-repeat="key2 in checkedList">
                                    <a id="<% key %>_<% key2 %>" href="" ng-click="showModal(key, key2)"><img ng-src="<% getSrc(key, key2) %>"></a>
                                </td> 
                            </tr>
                        </table>
                        {!! csrf_field() !!}
                        <div class="submit-w3l col-md-12">
                            <input type="button" name="back" ng-click="backAddClass()" value='back'>
                            <input type="submit" value="Save schedule">
                        </div>
                    </form>
                </div>      
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

