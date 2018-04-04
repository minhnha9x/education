@php
	$schedule = DB::table('room_schedule')
    ->leftjoin('schedule', 'room_schedule.schedule', 'schedule.id')
    ->get();
@endphp

<link href="./css/subjectpage.css" rel="stylesheet" type="text/css">

<div class="subjectpage container">
	@include('header', [$title='Subject Page', $position='normal'])

	<div class="title">
		Các khóa học {{$subject->name}}
	</div>

	@php
		$i = 0;
	@endphp
	
	@foreach ($courses as $course)
		<div class="course-wrapper @if ($i % 2 == 1) right @endif" data-id="{{$course->id}}">
			<div class="img" style="background: url('{{$course->img_url}}')"></div>
			<div class="info">
				<div class="name">{{$course->name}}</div>
				<div class="desc">{{$course->description}}</div>
				<div class="price">{{number_format($course->price)}} VNĐ</div>
			</div>
		</div>
		@php
		$i = $i + 1;
		@endphp
	@endforeach
	<div id="classModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	    <div class="modal-dialog" role="document">
	        <div class="modal-content">
	            <div class="main-agileits">
	                <div class="form-w3-agile clearfix">
	                    <h2 id="form-title">Danh sách lớp học</h2>
	                    <table id="example" class="table table-bordered table-hover">
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
	            </div>
	        </div><!-- /.modal-content -->
	    </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<div id="classregisterModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	    <div class="modal-dialog" role="document" style="width: 650px">
	        <div class="modal-content">
	            <div class="main-agileits">
	                <div class="form-w3-agile clearfix">
	                	<form method="POST" role='form' action="">
	                		<h2 id="form-title">Đăng kí học</h2>
		                    <div class="form-sub-w3 col-md-6">
			                    <select name="subject">
		                            <option disabled selected hidden>Môn học</option>
		                            @foreach ($subjects as $s)
		                                <option value="{{$s->id}}">{{$s->name}}</option>
		                            @endforeach
		                        </select>
		                    </div>
		                    <div class="form-sub-w3 col-md-6">
		                        <select name="course">
		                            <option disabled selected hidden>Khóa học</option>
		                            @foreach ($courses as $c)
		                                <option value="{{$c->id}}">{{$c->name}}</option>
		                            @endforeach
		                        </select>
		                    </div>
		                    <div class="form-sub-w3 col-md-6">
		                        <select name="office">
		                            <option value="" selected>Trung tâm</option>
		                            @foreach ($offices as $o)
		                                <option value="{{$o->id}}">{{$o->name}}</option>
		                            @endforeach
		                        </select>
		                    </div>
		                    <div class="form-sub-w3 col-md-6">
		                        <select name="class">
		                            <option value="" selected>Lớp học</option>
		                            @foreach ($classes as $c)
		                                <option value="{{$c->id}}">{{$c->id}}</option>
		                            @endforeach
		                        </select>
		                    </div>
		                    <div class="submit-w3l col-md-12">
		                    	<input type="button" name="back" value='back'>
	                            <input type="submit" id='form-button' value="Đăng kí">
	                        </div>
	                	</form>
	                </div>      
	            </div>
	        </div><!-- /.modal-content -->
	    </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</div>

<script type="text/javascript">
	$('.course-wrapper').click(function() {
		$('#classModal tbody').empty();
		$.ajax({
            url : "getclassfromcourse" + $(this).data('id'),
            type : "get",
            dataType:"text",
            success : function (result){
            	obj = JSON.parse(result);
            	console.log(obj);
  				var i;
				for (i = 0; i < obj['courses'].length; i++) {
					var j;
					$schedule = '';
					for (j = 0; j < obj['schedule'].length; j++) {
						if (obj['schedule'][j]['class'] == obj['courses'][i]['id'])
							$schedule += obj['schedule'][j]['current_date'] + ': ' + obj['schedule'][j]['start_time'].substr(0, obj['schedule'][0]['start_time'].length-3) + ' - ' + obj['schedule'][j]['end_time'].substr(0, obj['schedule'][0]['end_time'].length-3) + ' (Phòng ' + obj['schedule'][j]['room'] + ' - ' + obj['schedule'][j]['name'] + ')' + '<br>';
					}
					$string = '<tr><td>' + obj['courses'][i]['id'] + '</td><td>' + $schedule + '</td><td></td><td>' + obj['courses'][i]['start_date'] + '</td><td class="action" data-id="' + obj['courses'][i]['id'] + '">Đăng kí</td></tr>';
					$('#classModal tbody').append($string);
				}
            }
        });
		$('#classModal').modal('show', 300);
	});
	$('#classModal table').on('click', '.action', function(){
		$('#classregisterModal select[name="subject"] option[value="' + {{$subject->id}} + '"]').attr('selected','selected');
		$('#classregisterModal select[name="course"] option[value="' + obj['courses'][0]['course'] + '"]').attr('selected','selected');
		$('#classregisterModal select[name="office"] option[value="' + obj['schedule'][0]['office'] + '"]').attr('selected','selected');
		$('#classregisterModal select[name="class"] option[value="' + $(this).data('id') + '"]').attr('selected','selected');
		$('#classModal').modal('hide');
		$('#classregisterModal').modal('show', 300);
	});
	$('#classregisterModal input[name="back"]').click(function() {
		$('#classregisterModal').modal('hide');
		$('#classModal').modal('show', 300);
	});
</script>

@include('footer')