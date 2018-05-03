<div id="teaching_offset" class="modal profile-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 800px">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                    <form method="POST" role="form" action="{{url('addteachingoffset')}}">
                        <h2 id="form-title">Teaching Offset Register</h2>
                        <div id="review" class="review-wrapper col-md-12">
                        </div>
                        <input type="number" name="id" hidden>
                        <input type="number" name="room_schedule" hidden>
                        <input type="date" name="date" hidden>
                        <div class="form-sub-w3 col-md-6">
                            <select name="week" class="checkchange">
                                <option selected disabled hidden>Chọn tuần dạy bù</option>
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <select name="day" class="checkchange">
                                <option selected disabled hidden>Chọn ngày trong tuần</option>
                            </select>
                        </div>
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
    $weekday = <?= json_encode($week); ?>;
    $('#teaching_offset .checkchange').on('change', function(){
        if ($('#teaching_offset select[name="week"]').val() != null && $('#teaching_offset select[name="day"]').val() != null) {
            for (var i = 1; i <= _.size($weekday); i++)
            {
                if ($weekday[i] == $('#teaching_offset select[name="day"] option:selected').val())
                {
                    $temp = i;
                    break;
                }
            }
            $date = $test[$c]['firstweekdays'];
            for (var i = 2; i < $test[$c]['totalweek'] - 1; i++)
                $date += 7;
            $date += $temp -1;
            $start_time.setDate($start_time.getDate() + $date);

            var day = ("0" + $start_time.getDate()).slice(-2);
            var month = ("0" + ($start_time.getMonth() + 1)).slice(-2);

            var today = $start_time.getFullYear()+"-"+(month)+"-"+(day) ;

            $('#teaching_offset input[name="date"]').val(today);
            $('#teaching_offset input[type="submit"]').removeAttr('disabled');
        }
    });
</script>