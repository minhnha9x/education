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
		<form>
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

	<table class="table table-bordered table-hover">
	    <thead>
	        <tr>
	            <th>Mã lớp</th>
	            <th>Lịch học</th>
	            <th>Sĩ số</th>
	            <th>Ngày khai giảng</th>
	            <th>Hành động</th>
	        </tr>
	    </thead>
	    <tbody>
	        
	    </tbody>
	</table>
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
		$('.schedulepage tbody').empty();
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
				for (i = 0; i < obj['class'].length; i++) {
					var j;
					$listschedule[i] = [];
					$schedule = '';
					for (j = 0; j < obj['schedule'].length; j++) {
						if (obj['schedule'][j]['class'] == obj['class'][i]['id'])
							$schedule += obj['schedule'][j]['current_date'] + ': ' + obj['schedule'][j]['start_time'].substr(0, obj['schedule'][0]['start_time'].length-3) + ' - ' + obj['schedule'][j]['end_time'].substr(0, obj['schedule'][0]['end_time'].length-3) + ' (Phòng ' + obj['schedule'][j]['room'] + ')' + '<br>';
						$listschedule[i][j] = $schedule;
					}
					$string = '<tr><td>' + obj['class'][i]['id'] + '</td><td>' + $schedule + '</td><td></td><td>' + obj['class'][i]['start_date'] + '</td><td class="action" data-course="' + i + '" data-id="' + obj['class'][i]['id'] + '">Đăng kí</td></tr>';
					$('.schedulepage tbody').append($string);
				}
            }
        });
		$('#classModal').modal('show', 300);
	});
</script>