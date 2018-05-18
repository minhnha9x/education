<link href="./css/homepage.css" rel="stylesheet" type="text/css">
 
<div class="homepage" ng-app="educationApp" ng-controller="HomepageController">
	@include('header', [$title='Education Page'])

    <div class="my-flipster">
        <ul>
            @foreach ($subject as $s)
                <li data-id="{{$s->id}}">
                    <div class="img" style="background-image: url('{{$s->img}}')"></div>
                    <div class="name">
                        {{$s->name}}
                    </div>
                    <div class="course">
                        {{$s->count}} khóa học
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
                        <div class="course-wrapper col-md-4" ng-click="showModal({{$c->id}})">
                            <div class="img" style="background-image: url('{{$c->img_url}}')"></div>
                            <div class="info">
                                <div class="name">
                                    {{$c->name}}
                                </div>
                                <div class="price">
                                    <img src="./img/subject.png"><span>Số buổi học: {{$c->total_of_period}}</span>
                                    <span style="float: right;"><img src="./img/salary.png"><span>Học phí: {{number_format($c->price)}} VNĐ</span></span>
                                </div>
                                <div class="desc">
                                    {{$c->description}}
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endforeach
    </div>

    @include('popup.class_list_modal')
    @include('popup.class_register_modal', [$check = true])

    @include('footer')
</div>

<script src="js/myApp.js"></script>
<script src="js/HomepageController.js"></script>

<script type="text/javascript">
    $('.my-flipster').flipster({
        scrollwheel: false,
        keyboard: false,
        onItemSwitch: function(currentItem) {
            $current = currentItem.dataset.id;
            $('.subject-wrapper').find('.subject').addClass('hidden');
            $('.subject-wrapper').find('#' + $current).removeClass('hidden');
        },
    });
    $('.subject-wrapper').find('#' + $('.my-flipster .flipster__item--current').data('id')).removeClass('hidden');
</script>