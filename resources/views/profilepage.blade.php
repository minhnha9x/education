<link href="./css/profilepage.css" rel="stylesheet" type="text/css">

<div class="profilepage container">
	@include('header', [$title='Profile Page', $position='normal'])

	<div class="title">
		Trang cá nhân
	</div>

	<div class="profile-wrapper col-md-3">
		<div class="avatar" style="background-image: url('{{Auth::user()->avatar}}')">
		</div>
		<div class="name">
			@if ($userInfo->fullname != null)
				{{$userInfo->fullname}}
			@else
				{{$userInfo->name}}
			@endif
		</div>
		<div class="text">
			<p><span>Email: </span>{{$userInfo->email}}</p>
			<p class="clearfix"><span>Phone: </span>{{$userInfo->phone}}</p>
			<p class="address clearfix"><span>Địa chỉ: </span>{{$userInfo->address}}</p>
			<p class="clearfix"><span>Ngày sinh: </span>{{$userInfo->birthday}}</p>
		</div>
		<div class="button">
			Edit Profile
		</div>
	</div>
	@if (Auth::user()->role != 'teacher')
		<div class="tab-wrapper col-md-9">
			<ul class="nav nav-tabs">
	        	<li class="active"><a data-toggle="tab" href="#menu1">Khóa học đã đăng kí</a></li>
	        	<li><a data-toggle="tab" href="#menu2">Lịch học trong tuần</a></li>
	        </ul>
	        <div class="tab-content">
		        <div id="menu1" class="tab-pane in active">
		        	<table class="table table-bordered table-hover">
		        		<tr>
		        			<th>Khóa học</th>
		        			<th>Mã Lớp</th>
		        			<th>Tình trạng</th>
		        			<th>Kết quả</th>
		        		</tr>
		        		@foreach ($user as $u)
		        			<tr>
		        				<td>{{$u->name}}</td>
		        				<td>{{$u->class}}</td>
		        				<td></td>
		        				<td></td>
		        			</tr>
		        		@endforeach
		        	</table>
		        </div>
		        <div id="menu2" class="tab-pane">
		        	<table class="table table-bordered table-hover">
		        		<tr>
		        			<th>Tiết học</th>
		        			<th>Monday</th>
		        			<th>Tuesday</th>
		        			<th>Wednesday</th>
		        			<th>Thursday</th>
		        			<th>Friday</th>
		        			<th>Saturday</th>
		        			<th>Sunday</th>
		        		</tr>
		        		@foreach ($slot as $s)
		        			<tr>
		        				<td>{{substr($s->start_time, 0, strlen($s->start_time) - 3)}} - {{substr($s->end_time, 0, strlen($s->end_time) - 3)}}</td>
		        				@foreach ($week as $w)
		        				@php $check = true; @endphp
		        					@foreach ($schedule as $sc)
			        					@if ($sc->schedule == $s->slot_in_day && $sc->current_date == $w)
			        						<td class="text">
			        							<div class="course">{{$sc->course}}</div>
			        							<strong>{{$sc->name}}</strong>
			        							<div class="course">Phòng {{$sc->room}}</div>
			        						</td>
			        						@php $check = false; @endphp
			        						@break;
			        					@endif
			        				@endforeach
			        				@if ($check)
			        					<td></td>
			        				@endif
		        				@endforeach
		        			</tr>
		        		@endforeach
		        	</table>
		        </div>
		    </div>
		</div>
	@else
		<div class="tab-wrapper col-md-9">
			<ul class="nav nav-tabs">
	        	<li class="active"><a data-toggle="tab" href="#menu2">Lịch dạy trong tuần</a></li>
	        </ul>
	        <div class="tab-content">
	        	<div id="backup_button" class="addbutton hvr-sweep-to-right">Đăng kí dạy thay</div>
		        <div id="menu2" class="tab-pane in active">
		        	<table class="table table-bordered table-hover">
		        		<tr>
		        			<th>Tiết học</th>
		        			<th>Monday</th>
		        			<th>Tuesday</th>
		        			<th>Wednesday</th>
		        			<th>Thursday</th>
		        			<th>Friday</th>
		        			<th>Saturday</th>
		        			<th>Sunday</th>
		        		</tr>
		        		@foreach ($slot as $s)
		        			<tr>
		        				<td>{{substr($s->start_time, 0, strlen($s->start_time) - 3)}} - {{substr($s->end_time, 0, strlen($s->end_time) - 3)}}</td>
		        				@foreach ($week as $w)
			        				<td></td>
		        				@endforeach
		        			</tr>
		        		@endforeach
		        	</table>
		        </div>
		    </div>
		</div>
	@endif
</div>

<div id="teaching_backup" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 800px">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                    <form method="POST" role="form" action="{{url('addteacherbackup')}}">
                        <h2 id="form-title">Teaching Backup Register</h2>
                        <input type="text" name="room_schedule" hidden>
                        <div class="form-sub-w3 col-md-6">
                            <select name="course" class="checkchange">
                                <option disabled selected hidden>Khóa học</option>
                                @foreach ($courses as $c)
                                	<option value="{{$c->id}}">{{$c->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <select name="class" class="checkchange">
                                <option disabled selected hidden>Lớp</option>
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                        	<span>Ngày cần dạy thay:</span>
                            <input type="date" name="date" min="{{date("Y-m-d")}}" placeholder="Ngày nghỉ"  class="checkchange">
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <select name="teacher" required>
                                <option disabled selected hidden>Giáo viên dạy thay</option>
                            </select>
                        </div>
                        <div class="review-wrapper col-md-12">
                        	<p id="review"></p>
                        </div>
                        {!! csrf_field() !!}
                        <div class="submit-w3l col-md-12">
                            <input type="submit" name="ok" ng-click="setSelected()" value="OK">
                        </div>
                    </form>
                </div>      
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@include('footer')

<script type="text/javascript">
	$schedule = <?= json_encode($schedule); ?>;
	$temp = ["Sunday",  "Monday", "Tuesday", "Wednesday", "Thursday", "Friday",  "Saturday"];
	$('#backup_button').click(function() {
		$('#teaching_backup').modal('show', 300);
	});
	$('#teaching_backup select[name="course"]').on('change', function() {
        $('#teaching_backup').find('select[name="class"] option:not(:first-child)').remove();
        $.ajax({
            url : "getclassfromcourse_" + $(this).val(),
            type : "get",
            dataType:"text",
            success : function (result){
                obj = JSON.parse(result);
                console.log(obj);
                var i;
                for (i = 0; i < obj.length; i++) {
                    $string = '<option value="' + obj[i]['id'] + '">' + obj[i]['id'] + '</option>';
                    $('#teaching_backup select[name="class"]').append($string);
                }
            }
        });
    });
    $('#teaching_backup .checkchange').on('change', function() {
    	$('#teaching_backup').find('select[name="teacher"] option:not(:first-child)').remove();
    	$check = true;
    	$office = $course = $slot = '';
    	$formattedDate = new Date($('#teaching_backup input[name="date"]').val());
		$d = $formattedDate.getDate();
		$m = $formattedDate.getMonth() + 1;
		$y = $formattedDate.getFullYear();

		$formatdate = $m + "/" + $d + "/" + $y;
    	$('#teaching_backup .checkchange').each(function() {
    		if ($(this).val() == null || $(this).val() == "")
    			$check = false;
    	});
    	if ($check) {
    		for (var i = 0; i < $schedule.length; i++) {
	        	$date = new Date($('#teaching_backup input[name="date"]').val()).getDay();
	        	if ($schedule[i]['class'] == $('#teaching_backup select[name="class"]').val() && $temp[$date] == $schedule[i]['current_date'])
	        	{
	        		$office = $schedule[i]['office'];
	        		$office2 = $schedule[i]['name'];
	        		$slot = $schedule[i]['slot_in_day'];
	        		$course = $schedule[i]['course'];
	        		$course2 = $schedule[i]['course2'];
	        		$start = $schedule[i]['start_time'];
	        		$end = $schedule[i]['end_time'];
	        		$room = $schedule[i]['room'];
	        		$class = $schedule[i]['class'];
	        		console.log($schedule[i]['room_schedule']);
	        		$('#teaching_backup input[name="room_schedule"]').attr('value', $schedule[i]['room_schedule']);
	        		break;
	        	}
	        }
    		$.ajax({
	            url : "getlistfreeteacher",
	            type : "get",
	            dataType:"text",
	            data : {
	            	date: $formatdate,
	            	office: $office,
	            	slot: $slot,
	            	course: $course,
	            },
	            success : function (result){
	                obj = JSON.parse(result);
	                console.log(obj);
	                if (obj.length == 0)
	                {
	                	$('#review').empty();
				    	$string = '<div class="alert alert-danger fade in alert-dismissible" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Error! </strong>Không có giáo viên dạy thay phù hợp</div>';
						$('#review').append($string);
	                }
	                else {
	                	$('#review').empty();
	                	var i;
		                for (i = 0; i < obj.length; i++) {
		                    $string = '<option value="' + obj[i]['id'] + '">' + obj[i]['name'] + '</option>';
		                    $('#teaching_backup select[name="teacher"]').append($string);
		                }
	                }
	            }
	        });
	    }
    });
    $('#teaching_backup select[name="teacher"]').on('change', function() {
    	$('#review').empty();
    	$string = 'Review thông tin dạy thay: <br>Ngày: ' + $d + "/" + $m + "/" + $y + '<br>Khóa học: ' + $course2 + ' - Lớp ' + $class + '<br>' + $office2 + '<br>Thời gian: ' + $start + ' - ' + $end + '<br>Phòng ' + $room + '<br>Giáo viên dạy thay: ' + $(this).find('option:selected').text();
		$('#review').append($string);
    });
</script>