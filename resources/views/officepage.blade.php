<link href="./css/officepage.css" rel="stylesheet" type="text/css">

<div class="officepage container">
    @include('header', [$title='Trung Tâm Đào Tạo'])

    <div class="title">
        Trung Tâm Đào Tạo
    </div>

    @foreach ($offices as $o)
        <div class="office-wrapper clearfix">
            <div class="info col-md-6">
                <div class="name">
                    <img src="./img/map-marker.svg">
                    {{$o->name}}
                </div>
                <div class="address">
                    <div>{{$o->address}}<br></div>
                    <div><i class="fas fa-phone"></i>{{$o->phone}}<br></div>
                    <div><i class="fas fa-envelope"></i>{{$o->mail}}<br></div>
                </div>
            </div>
            <div class="col-md-6">
                <a target="_blank" href="{{$o->location}}">Google Map</a>
            </div>
        </div>
    @endforeach
</div>

@include('footer')