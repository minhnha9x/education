<link href="./css/homepage.css" rel="stylesheet" type="text/css">
 
<div class="homepage">
	@include('header', [$title='Education Page', $position='top'])

	<div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.12&appId=1614788861874943&autoLogAppEvents=1';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    
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
                            <div class="title">Tiếng Anh</div>
                            <div class="text">5 khóa học</div>
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
                                <div class="title">Mỹ Thuật</div>
                                <div class="text">2 khóa học</div>
                            </div>
                        </a>
                    </div>
                    <div class="object-wrapper width50">
                        <a href="./subject_3">
                            <div class="object" style="background-image: url('./img/object3.jpg')"></div>
                            <div class="bg1 bg3"></div>
                            <div class="text-wrapper">
                                <div class="title">Âm Nhạc</div>
                                <div class="text">5 khóa học</div>
                            </div>
                        </a>  
                    </div>
                </div>
                <div class="row-wrapper" style="display: flex">
                    <div class="object-wrapper width50 mr20">
                        <a href="./subject_4">
                            <div class="object" style="background-image: url('./img/object4.jpg')"></div>
                            <div class="bg1 bg4"></div>
                            <div class="text-wrapper">
                                <div class="title">Tin Học</div>
                                <div class="text">3 khóa học</div>
                            </div>
                        </a>
                    </div>
                    <div class="object-wrapper width50">
                        <a href="./subject_5">
                            <div class="object" style="background-image: url('./img/object5.jfif')"></div>
                            <div class="bg1 bg5"></div>
                            <div class="text-wrapper">
                                <div class="title">Toán Học</div>
                                <div class="text">1 khóa học</div>
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