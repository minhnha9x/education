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
			{{Auth::user()->name}}
		</div>
		<div class="text">
			<strong>Email: </strong>{{Auth::user()->email}}<br>
			<strong>Phone: </strong>{{Auth::user()->phone}}
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
	        				<td></td>
	        				<td></td>
	        				<td></td>
	        				<td></td>
	        				<td></td>
	        				<td></td>
	        				<td></td>
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