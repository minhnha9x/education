<div id="teaching_offset" class="modal profile-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 800px">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                    <form method="POST" role="form" action="{{url('addteachingoffset')}}">
                        <h2 id="form-title">Teaching Offset Register</h2>
                        <div id="review" class="review-wrapper col-md-12">
                        </div>
                        <input type="hidden" name="id">
                        <div class="form-sub-w3 col-md-6">
                        	<span>Chọn ngày dạy bù:</span>
                            <input type="date" value="{{date("Y-m-d")}}" name="date" required class="checkchange">
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <select name="slot" class="checkchange">
                                <option selected disabled hidden>Chọn giờ dạy</option>
                                <option value="1">07:00 - 09:00</option>
                                <option value="2">09:00 - 11:00</option>
                                <option value="3">13:00 - 15:00</option>
                                <option value="4">15:00 - 17:00</option>
                                <option value="5">17:00 - 19:00</option>
                                <option value="6">19:00 - 21:00</option>
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <select name="room" class="checkchange">
                                <option selected disabled hidden>Chọn phòng</option>
                                <option value="1">Test</option>
                            </select>
                        </div>
                        <input type="number" name="room_schedule" hidden>
                        {!! csrf_field() !!}
                        <div class="col-md-12">
                            <input type="submit" value="OK" disabled>
                        </div>
                        <div id="error" class="review-wrapper col-md-12">
                        </div>
                    </form>
                </div>      
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    $('#teaching_offset .checkchange').on('change', function(){
        if ($('#teaching_offset select[name="slot"]').val() != null && $('#teaching_offset select[name="room"]').val() != null)
            $('#teaching_offset input[type="submit"]').removeAttr('disabled');
    });
    $('#menu3 table td button').click(function(){
        console.log($(this).parent().parent().find('.dayoffid').data('id'));
        $('#teaching_offset input[name="id"]').attr('value', $(this).parent().parent().find('.dayoffid').data('id'));
    });
</script>