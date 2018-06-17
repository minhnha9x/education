<link href="./css/homepage.css" rel="stylesheet" type="text/css">
 
<div class="homepage" ng-app="educationApp" ng-controller="HomepageController">
	@include('header', [$title='Trang Chủ'])

	<div class="my-flipster">
		<ul>
			@foreach ($subject as $s)
				<li data-id="{{$s->id}}">
					<div class="img" style="background-image: url('{{$s->img}}')"></div>
					<div class="info">
						<div class="name">
							{{$s->name}}
						</div>
						<div class="course">
							{{$s->count}} khóa học
						</div>
					</div>
				</li>
			@endforeach
		</ul>
	</div>

	<div class="subject-wrapper container">
		@foreach ($subject as $s)
			<div class="subject hidden" id="{{$s->id}}">
				@foreach ($course as $c)
					@if ($c->subjectid == $s->id)
						<div class="col-md-4">
							<div class="course-wrapper hvr-bob" ng-click="showModal({{$c->id}})">
								<div class="img" style="background-image: url('{{$c->img_url}}')"></div>
								<div class="info">
									<div class="name">
										{{$c->name}}
									</div>
									<div class="price">
										<img src="./img/subject.png"><span>Số buổi học: {{$c->total_of_period}}</span>
										<span style="float: right;"><img src="./img/salary.png"><span>Học phí: {{number_format($c->price)}} VNĐ</span></span>
									</div>
									<div class="price">
										<img src="./img/course.png">Khóa học tiên quyết: @if ($c->certificate_required != null)
											{{$c->certificate_required}}
										@else
											Không có
										@endif
									</div>
									<div class="desc">
										{{$c->description}}
									</div>
								</div>
							</div>
						</div>
					@endif
				@endforeach
			</div>
		@endforeach
	</div>

	<div class="education-info">
		<div class="title">
			Tại sao nên học tại Trung tâm Home Education
		</div>
		<div class="container">
			<div class="col-md-3 box-wrapper">
				<div class="box" style="background-color: #4BBADC">
					<div class="text-wrapper">
						<div class="big-text">50+</div>
						<div class="text">Giáo viên trình độ cao</div>
					</div>
				</div>
			</div>
			<div class="col-md-3 box-wrapper">
				<div class="box" style="background-color: #F08A8F">
					<div class="text-wrapper">
						<div class="big-text">10</div>
						<div class="text">Năm kinh nghiệm và<br>chuyên môn</div>
					</div>
				</div>
			</div>
			<div class="col-md-3 box-wrapper">
				<div class="box" style="background-color: #F2C152">
					<div class="text-wrapper">
						<div class="big-text">4</div>
						<div class="text">Chi nhánh trung tâm<br>tại Hồ Chí Minh</div>
					</div>
				</div>
			</div>
			<div class="col-md-3 box-wrapper">
				<div class="box" style="background-color: #61B46B">
					<div class="text-wrapper">
						<div class="big-text">5.000</div>
						<div class="text">Học viên đã học<br>tại Education</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	@include('popup.class_list_modal')
	@include('popup.class_register_modal', [$check = true])

	@include('footer')
</div>

<script src="js/myApp.js"></script>
<script src="js/HomepageController.js"></script>

<script type="text/javascript">
	$('.my-flipster').flipster({
		start: 1,
		scrollwheel: false,
		keyboard: false,
		onItemSwitch: function(currentItem) {
			$current = currentItem.dataset.id;
			$('.subject-wrapper').find('.subject').addClass('hidden');
			$('.subject-wrapper').find('#' + $current).removeClass('hidden');
		},
	});
	$('.subject-wrapper').find('#' + $('.my-flipster .flipster__item--current').data('id')).removeClass('hidden');

	$('.education-info .box .text-wrapper').each(function() {
	   $(this).css('top', ($(this).parent().parent().height() - $(this).height()) / 2);
	});
</script>