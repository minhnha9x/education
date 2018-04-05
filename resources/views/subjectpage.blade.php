@php
	$schedule = DB::table('room_schedule')
    ->leftjoin('schedule', 'room_schedule.schedule', 'schedule.id')
    ->get();
@endphp

<link href="./css/subjectpage.css" rel="stylesheet" type="text/css">

<div class="subjectpage container">
	@include('header', [$title='Subject Page', $position='normal'])

	@if (Session::has('msg'))
		<div class="alert alert-success fade in alert-dismissible" style="margin-top:18px;">
	    	<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
		    <strong>Success!</strong> {{Session::get("msg")}}
		</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger fade in alert-dismissible" style="margin-top:18px;">
	    	<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
		    <strong>Error!</strong> {{Session::get("error")}}
		</div>
	@endif

	<div class="title">
		Các khóa học {{$subject->name}}
	</div>

	@php
		$i = 0;
	@endphp
	
	@foreach ($courses as $course)
		<div class="course-wrapper @if ($i % 2 == 1) right @endif" data-id="{{$course->id}}" data-name="{{$course->name}}">
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
	$course = '';
	var $listschedule = [];
	$('.course-wrapper').click(function() {
		$('#classModal tbody').empty();
		$course = $(this).data('name');
		$courseid = $(this).data('id');
		$.ajax({
            url : "getclassfromcourse" + $(this).data('id'),
            type : "get",
            dataType:"text",
            success : function (result){
            	obj = JSON.parse(result);
  				var i;
				for (i = 0; i < obj['courses'].length; i++) {
					var j;
					$listschedule[i] = [];
					$schedule = '';
					for (j = 0; j < obj['schedule'].length; j++) {
						if (obj['schedule'][j]['class'] == obj['courses'][i]['id'])
							$schedule += obj['schedule'][j]['current_date'] + ': ' + obj['schedule'][j]['start_time'].substr(0, obj['schedule'][0]['start_time'].length-3) + ' - ' + obj['schedule'][j]['end_time'].substr(0, obj['schedule'][0]['end_time'].length-3) + ' (Phòng ' + obj['schedule'][j]['room'] + ' - ' + obj['schedule'][j]['name'] + ')' + '<br>';
						$listschedule[i][j] = $schedule;
					}
					$string = '<tr><td>' + obj['courses'][i]['id'] + '</td><td>' + $schedule + '</td><td></td><td>' + obj['courses'][i]['start_date'] + '</td><td class="action" data-course="' + i + '" data-id="' + obj['courses'][i]['id'] + '">Đăng kí</td></tr>';
					$('#classModal tbody').append($string);
				}
            }
        });
		$('#classModal').modal('show', 300);
	});
	$('#classModal table').on('click', '.action', function(){
		@if ( Auth::check() )
			$('#classregisterModal .info').empty();
			$('#classregisterModal .info').append('<div class="course">Khóa học: <span>' + $course + '</span></div><div class="schedule">Giờ học: <br>' + $listschedule[$courseid - 1][$(this).data('id')] + '</div>');
			$('#classregisterModal input[name="class"]').attr('value', $(this).data('id'));
			$('#classregisterModal input[name="course"]').attr('value', $courseid);
			$('#classModal').modal('hide');
			$('#classregisterModal').modal('show', 300);
		@else
			$('#classModal').modal('hide');
			$('#myLoginModal').modal('show', 300);
		@endif
	});
	$('#classregisterModal input[name="back"]').click(function() {
		$('#classregisterModal').modal('hide');
		$('#classModal').modal('show', 300);
	});
</script>

@include('footer')