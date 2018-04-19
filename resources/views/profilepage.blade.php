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
			@if (Auth::user()->fullname != null)
				{{Auth::user()->fullname}}
			@else
				{{Auth::user()->name}}
			@endif
		</div>
		<div class="text">
			<p><span>Email: </span>{{Auth::user()->email}}</p>
			<p class="clearfix"><span>Phone: </span>{{Auth::user()->phone}}</p>
			<p class="address clearfix"><span>Địa chỉ: </span>{{Auth::user()->address}}</p>
			<p class="clearfix"><span>Ngày sinh: </span>{{Auth::user()->birthday}}</p>
		</div>
		<div class="button">
			Edit Profile
		</div>
	</div>
	@if (Auth::user()->role == 'member')
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
                    <form method="POST" role="form">
                        <h2 id="form-title">Teaching Backup Register</h2>
                        <div class="form-sub-w3 col-md-6">
                            <select name="course">
                                <option disabled selected hidden>Khóa học</option>
                                @foreach ($courses as $c)
                                	<option value="{{$c->id}}">{{$c->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <select name="class">
                                <option disabled selected hidden>Lớp</option>
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                        	<span>Ngày cần dạy thay:</span>
                            <input type="date" name="date" value="{{date("Y-m-d")}}" placeholder="Ngày nghỉ">
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <select name="teacher">
                                <option disabled selected hidden>Giáo viên dạy thay</option>
                                <option value="1">Trợ giảng 1 (6/6)</option>
                                <option value="1">Trợ giảng 2 (5/6)</option>
                                <option value="1">Trợ giảng 3 (1/6)</option>
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-12">
                        	<p id="review"></p>
                        </div>
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
    $('#teaching_backup select[name="class"]').on('change', function() {
        for (var i = 0; i < $schedule.length; i++) {
        	$date = new Date($('#teaching_backup input[name="date"]').val()).getDay();
        	if ($schedule[i]['class'] == $(this).val() && $temp[$date] == $schedule[i]['current_date'])
        	{
        		$string = 'Review thông tin dạy thay: <br>Ngày ' + $('#teaching_backup input[name="date"]').val() + '<br>' + $schedule[i]['name'] + '<br>Thời gian: ' + $schedule[i]['start_time'] + ' - ' + $schedule[i]['end_time'] + '<br>Phòng ' + $schedule[i]['room'];
				$('#review').append($string);
        	}
        }
    });
    $('#teaching_backup input[name="date"]').on('change', function() {
        for (var i = 0; i < $schedule.length; i++) {
        	$date = new Date($(this).val()).getDay();
        	if ($schedule[i]['class'] == $('#teaching_backup select[name="class"]').val() && $temp[$date] == $schedule[i]['current_date'])
        	{
        		$string = 'Review thông tin dạy thay: <br>Ngày ' + $(this).val() + '<br>Thời gian' + $schedule[i]['start_time'] + ' - ' + $schedule[i]['end_time'] + '<br>Phòng ' + $schedule[i]['room'];
				$('#review').append($string);
        	}
        }
    });
</script>