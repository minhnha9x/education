<link href="./css/subjectpage.css" rel="stylesheet" type="text/css">

<div class="subjectpage container">
	@include('header', [$title='Subject Page', $position='normal'])

	<div class="title">
		Các khóa học {{$subject->name}}
	</div>

	@foreach ($courses as $course)
		<a href="./course_{{$course->id}}">
			<div class="course-wrapper">
				<div class="img" style="background: url('./img/course1.jpg')"></div>
				<div class="info">
					<div class="name">{{$course->name}}</div>
					<div class="desc"></div>
				</div>
			</div>
		</a>
	@endforeach
</div>