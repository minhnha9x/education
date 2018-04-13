<div id="scheduleClassModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog schedule-modal" role="document">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                    <form method="POST" role="form">
                        <h2 id="form-title">Create class schedule</h2>
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th>Rooms</th>
                                <th ng-repeat="(key, value) in list_day_in_week" style="width: 150px;"><% key %></th>
                            </tr>
                            <tr ng-repeat="(key, value) in slot_in_day">
                                <th><% value %></th>
                                <td ng-repeat="(key, value) in list_day_in_week">
                                    <a href="" ng-click="showModal()">&#10060;</a>
                                </td> 
                            </tr>
                        </table>
                        {!! csrf_field() !!}
                        <div class="submit-w3l col-md-12">
                            <input type="button" name="back" value='back'>
                            <input type="submit" value="Save schedule">
                        </div>
                    </form>
                </div>      
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

