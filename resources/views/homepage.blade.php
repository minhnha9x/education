<link href="./css/homepage.css" rel="stylesheet" type="text/css">
 
<div class="homepage">
	@include('header', [$title='Education Page', $position='top'])
    
    <div class="slider">
        <div class="owl-carousel owl-theme">
            <div class="item" style="background-image: url('./img/banner1.jpg')"></div>
            <div class="item" style="background-image: url('./img/banner2.jpg')"></div>
            <div class="item" style="background-image: url('./img/banner3.jpg')"></div>
        </div>
    </div>
    <div class="course-wrapper">
        <div class="title col-xs-12">
            <div class="border-wrapper">
                <div class="border"></div>
            </div>
            Danh sách môn học
        </div>
        <div class="container">
            <div class="col-md-6 p10">
                <div class="object-wrapper">
                    <a href="./subject_1">
                        <div class="object" style="background-image: url('./img/object1.jpg')"></div>
                        <div class="bg1"></div>
                        <div class="text-wrapper">
                            <div class="title">English</div>
                            <div class="text">3 khóa học</div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-6 p10">
                <div class="row-wrapper" style="display: flex">
                    <div class="object-wrapper width50 mr20">
                        <a href="./subject_2">
                            <div class="object" style="background-image: url('./img/object2.jpg')"></div>
                            <div class="bg1 bg2"></div>
                            <div class="text-wrapper">
                                <div class="title">Maths</div>
                                <div class="text">2 khóa học</div>
                            </div>
                        </a>
                    </div>
                    <div class="object-wrapper width50">
                        <a href="./subject_3">
                            <div class="object" style="background-image: url('./img/object3.jpg')"></div>
                            <div class="bg1 bg3"></div>
                            <div class="text-wrapper">
                                <div class="title">Fine Art</div>
                                <div class="text">1 khóa học</div>
                            </div>
                        </a>  
                    </div>
                </div>
                <div class="row-wrapper" style="display: flex">
                    <div class="object-wrapper width50 mr20">
                        <a>
                            <div class="object" style="background-image: url('./img/object4.jpg')"></div>
                            <div class="bg1 bg4"></div>
                            <div class="text-wrapper">
                                <div class="title">IT</div>
                                <div class="text">0 khóa học</div>
                            </div>
                        </a>
                    </div>
                    <div class="object-wrapper width50">
                        <a href="./subject_4">
                            <div class="object" style="background-image: url('./img/object5.jpg')"></div>
                            <div class="bg1 bg5"></div>
                            <div class="text-wrapper">
                                <div class="title">Music</div>
                                <div class="text">3 khóa học</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
</div>

<script type="text/javascript">
    $('.owl-carousel').owlCarousel({
        autoplay: 4000,
        loop:true,
        margin:10,
        nav:true,
        items:1,
        animateOut: 'fadeOut',
        mouseDrag: false,
        dots:true,
        navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>'],
    })
</script>