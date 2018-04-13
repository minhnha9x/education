<link href="./css/profilepage.css" rel="stylesheet" type="text/css">

<div class="profilepage container">
	@include('header', [$title='Profile Page', $position='normal'])

	<div class="title">
		Trang cá nhân
	</div>
	<script>
        console.log(<?= json_encode($schedule); ?>);
    </script>
	<div class="profile-wrapper col-md-3">
		<div class="avatar" style="background-image: url('{{Auth::user()->avatar}}')">
		</div>
		<div class="name">
			{{Auth::user()->name}}
		</div>
		<div class="text">
			<p><span>Email: </span>{{Auth::user()->email}}</p>
			<p><span>Phone: </span>{{Auth::user()->phone}}</p>
			<p class="address"><span>Địa chỉ: </span>{{Auth::user()->address}}</p>
			<p><span>Ngày sinh: </span>{{Auth::user()->birthday}}</p>
		</div>
		<div class="button">
			Edit Profile
		</div>
	</div>
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
</div>

@include('footer')

<script type="text/javascript">
</script>