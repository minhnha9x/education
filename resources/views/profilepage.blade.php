<link href="./css/profilepage.css" rel="stylesheet" type="text/css">

<div class="profilepage container">
	@include('header', [$title='Profile Page', $position='normal'])

	<div class="title">
		Trang cá nhân
	</div>

	<div class="profile-wrapper col-md-12" id='11'>
		<div class="col-md-2">
			<div class="avatar" style="background-image: url('{{Auth::user()->avatar}}')">
			</div>
			<div class="name">
				@if ($userInfo->fullname != null)
					{{$userInfo->fullname}}
				@else
					{{$userInfo->name}}
				@endif
			</div>
		</div>
		<div class="col-md-10">
			<div class="text">
				<p><span>Email: </span>{{$userInfo->email}}</p>
				@if (Auth::user()->role == 'teacher')
					<p class="clearfix"><span>Phone: </span>{{$userInfo->phone}}</p>
					<p class="clearfix"><span>Địa chỉ: </span>{{$userInfo->address}}</p>
					<p class="clearfix"><span>Ngày sinh: </span>{{$userInfo->birthday}}</p>
				@endif
			</div>
			@if (Auth::user()->role == 'teacher')
				<div class="button">
					Edit Profile
				</div>
			@endif
		</div>
	</div>
	@if (Auth::user()->role != 'teacher')
		<div class="tab-wrapper col-md-12">
			<ul class="nav nav-tabs">
	        	<li class="active"><a data-toggle="tab" href="#menu1">Khóa học đã đăng kí</a></li>
	        	<li><a data-toggle="tab" href="#menu2">Lịch học trong tuần</a></li>
	        </ul>
	        <div class="tab-content">
		        <div id="menu1" class="tab-pane in active">
		        	<table class="table table-bordered table-hover">
		        		<tr>
		        			<th>Khóa học</th>
		        			<th>Lớp</th>
		        			<th>Tuần học</th>
		        			<th>Kết quả</th>
		        		</tr>
		        		@foreach ($user as $u)
		        			<tr>
		        				<td>{{$u->name}}</td>
		        				<td>{{$u->class}}</td>
		        				<td>
		        					@for ($i = 1; $i <= $test[$u->class]['totalweek']; $i++)
        								@if ($i == $test[$u->class]['currentweek'])
        									<span style="color:red">{{$i}}</span>
        								@else
        									{{$i}}
        								@endif
        							@endfor
		        				</td>
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
		<div class="tab-wrapper col-md-12">
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#menu1">Lịch dạy</a></li>
	        	<li><a data-toggle="tab" href="#menu2">Lịch dạy trong tuần</a></li>
	        	<li><a data-toggle="tab" href="#menu3">Nghỉ dạy</a></li>
	        	<li><a data-toggle="tab" href="#menu4">Dạy bù</a></li>
	        	<li><a data-toggle="tab" href="#menu5">Tình hình giảng dạy</a></li>
	        </ul>
	        <div class="tab-content">
	        	<div id="menu1" class="tab-pane in active">
	        		<table class="table table-bordered table-hover">
	        			<thead>
		        			<tr>
		        				<th>Lớp</th>
		        				<th>Khóa học</th>
		        				<th>Trung tâm</th>
		        				<th>Ngày bắt đầu</th>
		        				<th>Tuần học</th>
		        			</tr>
	        			</thead>
	        			<tbody>
	        				@foreach ($class as $c)
	        					<tr>
	        						<td>{{$c->class}}</td>
	        						<td>{{$c->course}}</td>
	        						<td>{{$c->name}}</td>
	        						<td>{{$c->start_date}}</td>
	        						<td>
	        							@for ($i = 1; $i <= $test[$c->class]['totalweek']; $i++)
	        								@if ($i == $test[$c->class]['currentweek'])
	        									<span style="color:red">{{$i}}</span>
	        								@else
	        									{{$i}}
	        								@endif
	        							@endfor
	        						</td>
	        					</tr>
	        				@endforeach
	        			</tbody>
	        		</table>
	        	</div>
		        <div id="menu2" class="tab-pane">
		        	<table class="table table-bordered table-hover" id="tschedule">
		        		<thead>
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
		        		</thead>
		        		<tbody>
		        		<?php $c = 1; ?>
		        		@foreach ($slot as $s)
		        			<tr>
		        				<td>{{substr($s->start_time, 0, strlen($s->start_time) - 3)}} - {{substr($s->end_time, 0, strlen($s->end_time) - 3)}}</td>
		        				<?php $d = 1; ?>
		        				@foreach ($week as $w)
		        					@php $check = true; @endphp
		        					@foreach ($tschedule as $t)
			        					@if ($t->schedule == $s->slot_in_day && $t->current_date == $w)
			        						<td class="text" id="{{$c}}{{$d}}" data-slot="{{$c}}" data-date="{{$d}}" data-class="{{$t->class}}">
			        							<div class="course">{{$t->course}}</div>
			        							<strong>{{$t->name}}</strong>
			        							<div class="course">Phòng {{$t->room}}</div>
			        						</td>
			        						@php $check = false; @endphp
			        						@break;
			        					@endif
			        				@endforeach
			        				@if ($check)
			        					<td id="{{$c}}{{$d}}" data-slot="{{$c}}" data-date="{{$d}}"></td>
			        				@endif
			        				<?php $d += 1; ?>
		        				@endforeach
		        			</tr>
		        			<?php $c += 1; ?>
		        		@endforeach
		        		</tbody>
		        	</table>
		        </div>
		        <script>
                    console.log(<?= json_encode($teaching_offset); ?>);
                    console.log(<?= json_encode($teacher_dayoff_count); ?>);
                </script>
		        <div id="menu3" class="tab-pane">
	        		<table class="table table-bordered table-hover">
	        			<thead>
		        			<tr>
		        				<th>Lớp</th>
		        				<th>Khóa học</th>
		        				<th>Trung tâm</th>
		        				<th>Thứ</th>
		        				<th>Giờ học</th>
		        				<th>Ngày nghỉ dạy</th>
		        				<th>Người dạy thay</th>
		        				<th>Tình trạng dạy bù</th>
		        			</tr>
	        			</thead>
	        			<tbody>
	        				@foreach ($teacher_dayoff as $t)
	        					<tr>
	        						<td>{{$t->class}}</td>
	        						<td>{{$t->course}}</td>
	        						<td>{{$t->office}}</td>
	        						<td>{{$t->current_date}}</td>
	        						<td>{{$t->start_time}} - {{$t->end_time}}</td>
	        						<td class="dayoffid" data-id="{{$t->id}}">{{$t->date}}</td>
        							@if ($t->backup_teacher == null)
        								@php $check = false; @endphp
        								@foreach ($teaching_offset as $t2)
        									@if ($t2->teacher_dayoff == $t->id)
        										@php $check = true; @endphp
        										@break;
        									@endif
        								@endforeach
        								@if ($check)
        									<td></td>
        									<td>
        										<img src="./img/check.png">
        									</td>
        								@else
        									<td><img src="./img/cross.png"></td>
        									<td>
        										<a>Đăng kí dạy bù</a>
        									</td>
        								@endif
        							@else
        								<td>{{$t->name}}</td>
        								<td></td>
        							@endif
	        					</tr>
	        				@endforeach
	        			</tbody>
	        		</table>
	        	</div>
	        	<div id="menu4" class="tab-pane">
	        		<table class="table table-bordered table-hover">
	        			<thead>
		        			<tr>
		        				<th>Lớp</th>
		        				<th>Khóa học</th>
		        				<th>Trung tâm</th>
		        				<th>Ngày nghỉ dạy</th>
		        				<th>Ngày dạy bù</th>
		        				<th>Giờ dạy bù</th>
		        				<th>Phòng</th>
		        			</tr>
		        		</thead>
		        		<tbody>
		        			@foreach ($teaching_offset as $t)
		        				<tr>
		        					<td>{{$t->class}}</td>
		        					<td>{{$t->course}}</td>
		        					<td>{{$t->office}}</td>
		        					<td>{{$t->dayoff}}</td>
		        					<td>{{$t->date}}</td>
		        					<td>{{$t->start_time}} - {{$t->end_time}}</td>
		        					<td>{{$t->room}}</td>
		        				</tr>
		        			@endforeach
		        		</tbody>
	        		</table>
	        	</div>
	        	<div id="menu5" class="tab-pane">
	        		<table class="table table-bordered table-hover">
	        			<thead>
		        			<tr>
		        				<th>Lớp</th>
		        				<th>Khóa học</th>
		        				<th>Số buổi nghỉ dạy</th>
		        				<th>Nghỉ dạy đã bù</th>
		        				<th>Còn thiếu</th>
		        			</tr>
		        		</thead>
		        		<tbody>
		        			@foreach ($class as $c)
		        				<tr>
		        					<td>{{$c->class}}</td>
			        				<td>{{$c->course}}</td>
			        				<td>{{$teacher_dayoff_count[$c->id]}}</td>
			        				<td>{{$teaching_offset_count[$c->id]}}</td>
			        				<td>{{$teacher_dayoff_count[$c->id] - $teaching_offset_count[$c->id]}} buổi</td>
		        				</tr>
		        			@endforeach
		        		</tbody>
	        		</table>
	        	</div>
		    </div>
		</div>
	@endif
</div>

@include('popup.teacher_dayoff_modal')

@include('popup.teaching_offset_modal')

{{-- @include('footer') --}}

<script type="text/javascript">
	$('#tschedule').DataTable({
		lengthChange: false,
		info: false,
		ordering: false,
		searching: false,
		paging: false,
	});
	$('#menu3 table a').click(function(){
		$('#teaching_offset').modal('show', 300);
	});
</script>