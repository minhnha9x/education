<link href="./css/schedulepage.css" rel="stylesheet" type="text/css">

<div class="schedulepage container">
	@include('header', [$title='Schedule Page', $position='normal'])

	<div class="title">
		Lịch học
		<div class="subtitle">
			Để biết lịch học, vui lòng chọn môn học, khoá học, trung tâm gần nơi bạn đang sống.
		</div>
	</div>

	<div class="filter-wrapper">
		<form class="clearfix">
			<div class="form-sub-w3 col-md-3">
	            <select name="subject">
	                <option disabled selected hidden value="">Môn học</option>
	                @foreach ($subjects as $s)
	                    <option value="{{$s->id}}">{{$s->name}}</option>
	                @endforeach
	            </select>
	        </div>
	        <div class="form-sub-w3 col-md-3">
	            <select name="course">
	                <option disabled selected hidden value="">Khóa học</option>
	            </select>
	        </div>
	        <div class="form-sub-w3 col-md-3">
	            <select name="office">
	                <option disabled selected hidden value="">Trung tâm</option>
	                @foreach ($offices as $o)
	                    <option value="{{$o->id}}">{{$o->name}}</option>
	                @endforeach
	            </select>
	        </div>
	        <div class="form-sub-w3 col-md-3">
	        	<input type="button" name="schedule" value="View Schedule">
	        </div>
		</form>
	</div>

	<div id="classregisterModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	    <div class="modal-dialog" role="document" style="width: 750px">
	        <div class="modal-content">
	            <div class="main-agileits">
	                <div class="form-w3-agile clearfix">
	                	<form method="POST" role='form' action="{{url('classregister')}}">
	                		<input type="number" name="class" hidden>
	                		<input type="number" name="course" hidden>
	                		<h2>Thông tin đăng kí</h2>
		                    <div class="form-sub-w3 col-md-12">
		                    	<div class="info">
		                    	</div>
		                    </div>
		                    <div class="form-sub-w3 col-md-5">
	                            <input type="text" placeholder="Mã giảm giá" name="promotion">
	                        </div>
		                    {!! csrf_field() !!}
		                    <div class="submit-w3l col-md-12">
	                            <input type="submit" value="Đăng kí">
	                        </div>
	                	</form>
	                </div>      
	            </div>
	        </div><!-- /.modal-content -->
	    </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</div>

@include('footer')

<script type="text/javascript">
	$('.schedulepage select[name="subject"]').on('change', function() {
        $('.schedulepage').find('select[name="course"] option:not(:first-child)').remove();
        $.ajax({
            url : "getcoursefromsub" + $(this).val(),
            type : "get",
            dataType:"text",
            success : function (result){
                obj = JSON.parse(result);
                var i;
                for (i = 0; i < obj.length; i++) {
                    $string = '<option value="' + obj[i]['id'] + '">' + obj[i]['name'] + '</option>';
                    $('.schedulepage select[name="course"]').append($string);
                }
            }
        });
    });
    $course = '';
	var $listschedule = [];
	$('.schedulepage input[name="schedule"]').click(function() {
		$('.schedulepage table').remove();
		$.ajax({
            url: "getschedule",
            type: "get",
            data: {
				subject : $('select[name="subject"]').val(),
				course : $('select[name="course"]').val(),
				office : $('select[name="office"]').val(),
			},
            dataType:"text",
            success : function (result){
            	obj = JSON.parse(result);
  				console.log(obj);
  				var i;
  				$table = '<table class="table table-bordered table-hover"> <thead> <tr> <th>Mã lớp</th> <th>Môn học</th> <th>Khóa học</th> <th>Lịch học</th> <th>Sĩ số</th> <th>Ngày khai giảng</th> <th>Hành động</th> </tr> </thead> <tbody>';
				for (i = 0; i < obj['class'].length; i++) {
					var j;
					$listschedule[i] = [];
					$schedule = '';
					for (j = 0; j < obj['schedule'].length; j++) {
						if (obj['schedule'][j]['class'] == obj['class'][i]['class'])
							$schedule += obj['schedule'][j]['current_date'] + ': ' + obj['schedule'][j]['start_time'].substr(0, obj['schedule'][0]['start_time'].length-3) + ' - ' + obj['schedule'][j]['end_time'].substr(0, obj['schedule'][0]['end_time'].length-3) + ' (Phòng ' + obj['schedule'][j]['room'] + ')' + '<br>';
						$listschedule[i][j] = $schedule;
					}
					$string = '<tr><td>' + obj['class'][i]['class'] + '</td><td>' + obj['class'][i]['name'] + '</td><td>' + obj['class'][i]['course'] + '</td><td>' + $schedule + '</td><td></td><td>' + obj['class'][i]['start_date'] + '</td><td class="action" data-course="' + i + '" data-id="' + obj['schedule'][i]['course'] + '">Đăng kí</td></tr>';
					$table += $string;
				}
				$table += '</tbody> </table>';
				$('.schedulepage').append($table);
            }
        });
	});
	$('.schedulepage').on('click', 'table .action', function(){
		@if ( Auth::check() )
			$('#classregisterModal .info').empty();
			$('#classregisterModal .info').append('<div class="course">Khóa học: <span>' + obj['class'][$(this).data('course')]['course'] + '</span></div><div class="schedule">Giờ học: <br>' + $listschedule[$(this).data('course')][$listschedule.length] + '</div>');
			$('#classregisterModal input[name="class"]').attr('value', $(this).data('id'));
			//$('#classregisterModal input[name="course"]').attr('value', $courseid);
			$('#classregisterModal').modal('show', 300);
		@else
			$('#classModal').modal('hide');
			$('#myLoginModal').modal('show', 300);
		@endif
		
	});
</script>