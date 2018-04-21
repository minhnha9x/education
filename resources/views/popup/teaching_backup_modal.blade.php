<div id="teaching_backup" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 800px">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                    <form method="POST" role="form" action="{{url('addteacherbackup')}}">
                        <h2 id="form-title">Teaching Backup Register</h2>
                        <div id="review" class="review-wrapper col-md-12">
                        </div>
                        <div class="form-sub-w3 col-md-5">
                        	<select name="week">
                                <option disabled selected hidden>Chọn tuần học</option>
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-5">
                            <select name="teacher">
                                <option disabled selected hidden>Giáo viên dạy thay</option>
                            </select>
                        </div>
                        <input type="number" name="room_schedule" hidden>
                        {!! csrf_field() !!}
                        <div class="submit-w3l col-md-2">
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
    $schedule = <?= json_encode($schedule); ?>;
    $tschedule = <?= json_encode($tschedule); ?>;
    $slottemp = <?= json_encode($slot); ?>;
    $temp = {"Monday" : 1, "Tuesday" : 2, "Wednesday" : 3, "Thursday" : 4, "Friday" : 5,  "Saturday" : 6, "Sunday" : 7};
    $('#tschedule td').click(function() {
        $slot = $(this).data('slot');
        $date = $(this).data('date');
        $check = false;
        for (var i = 0; i < $tschedule.length; i++) {
            if ($temp[$tschedule[i]['current_date']] == $date && $tschedule[i]['schedule'] == $slot)
            {
                $today = new Date();

                $formattedDate = new Date($tschedule[i]['start_date']);
                $sd = $formattedDate.getDate();
                $sm = $formattedDate.getMonth() + 1;
                $sy = $formattedDate.getFullYear();

                $firstweekdays = ($formattedDate.getDay() == 0 ? 1 : 7 - $formattedDate.getDay() + 1);

                $diff = new Date($today - $formattedDate);
                $currentweek = Math.floor($diff/1000/60/60/24/7) + 1;

                $formattedDate2 = new Date($tschedule[i]['end_date']);

                $diff2 = new Date($formattedDate2 - $formattedDate);
                $diff2 = $diff2/1000/60/60/24;

                $lastweekdays = ($diff2 - $firstweekdays) % 7 ;

                $totalweek = 1 + Math.floor(($diff2 - $firstweekdays) / 7 ) + ($lastweekdays == 0 ? 0 : 1);

                $office = $tschedule[i]['name'];
                $officeid = $tschedule[i]['office'];
                $course = $tschedule[i]['course'];
                $courseid = $tschedule[i]['courseid'];
                $room = $tschedule[i]['room'];
                $class = $tschedule[i]['class'];
                $date = $tschedule[i]['current_date'];
                $check = true;

                $('#teaching_backup input[name="room_schedule"]').attr('value', $tschedule[i]['room_schedule']);
                break;
            }
        }
        if ($check) {
            $('#review').empty();
            $newdate = new Date($today);
            $newdate.setDate($newdate.getDate()  - ($today.getDay() == 0 ? 6 : $today.getDay() - 1));
            $newdate2 = new Date($newdate);
            $newdate2.setDate($newdate2.getDate() + 6);
            $string = 'Thông tin buổi học:<br>Khóa học: ' + $course + ' - Lớp ' + $class + '<br>Tuần: ' + $currentweek + ' (' + $newdate.toLocaleDateString("en-GB") + ' - ' + $newdate2.toLocaleDateString("en-GB") + ')' + '<br>Thời gian: ' + $date + ' (' + $slottemp[$slot]['start_time'] + ' - ' + $slottemp[$slot]['end_time'] + ')<br>' + 'Địa điểm: Phòng ' + $room + ' (' + $office + ')';
            $('#review').append($string);
            $('#teaching_backup').find('select[name="week"] option:not(:first-child)').remove();
            $('#teaching_backup').find('select[name="teacher"] option:not(:first-child)').remove();
            for (var i = 1; i <= $totalweek; i ++) {
                if (i == 1) {
                    $newdate = new Date($formattedDate);
                    $newdate2 = new Date($formattedDate);
                    $newdate2.setDate($newdate.getDate() + $firstweekdays - 1);
                    $newdate3 = new Date($formattedDate);
                    $newdate3.setDate($newdate.getDate()  - (7 - $firstweekdays) + $temp[$date] - 1);
                }
                else if (i != $totalweek) {
                        $newdate = new Date($newdate2);
                        $newdate.setDate($newdate.getDate() + 1);
                        $newdate2 = new Date($newdate);
                        $newdate2.setDate($newdate2.getDate() + 6);
                        $newdate3 = new Date($newdate);
                        $newdate3.setDate($newdate.getDate() + $temp[$date] - 1);
                    }
                    else {
                        $newdate = new Date($newdate2);
                        $newdate.setDate($newdate.getDate() + 1);
                        $newdate2 = new Date($newdate);
                        $newdate2.setDate($newdate2.getDate() + $lastweekdays);
                        $newdate3 = new Date($newdate);
                        $newdate3.setDate($newdate.getDate() + $temp[$date] - 1);
                    }
                if ($today <= $newdate3)
                {
                    $string = '<option value="' + $newdate3.toLocaleDateString("en-US") + '">Tuần ' + i + ' (' + $newdate.toLocaleDateString("en-GB") + ' - ' + $newdate2.toLocaleDateString("en-GB") + ')</option>';
                    $('#teaching_backup select[name="week"]').append($string);
                }
            }
            $('#teaching_backup').modal('show', 300);
        }
    });
    $('#teaching_backup select[name="week"]').on('change', function() {
        $.ajax({
            url : "getlistfreeteacher",
            type : "get",
            dataType:"text",
            data : {
                date: $(this).val(),
                office: $officeid,
                slot: $slot,
                course: $courseid,
            },
            success : function (result){
                obj = JSON.parse(result);
                console.log(obj);
                if (obj.length == 0)
                {
                    $('#error').empty();
                    $string = '<div class="alert alert-danger fade in alert-dismissible" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Error! </strong>Không có giáo viên dạy thay phù hợp</div>';
                    $('#error').append($string);
                }
                else {
                    var i;
                    $('#teaching_backup').find('select[name="teacher"] option:not(:first-child)').remove();
                    for (i = 0; i < obj.length; i++) {
                        $string = '<option value="' + obj[i]['id'] + '">' + obj[i]['name'] + '</option>';
                        $('#teaching_backup select[name="teacher"]').append($string);
                    }
                }
            }
        });
    });
    $('#teaching_backup select[name="teacher"]').on('change', function(){
        $('#teaching_backup input[type="submit"]').removeAttr('disabled');
    });
</script>