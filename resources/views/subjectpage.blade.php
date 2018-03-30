<link href="./css/subjectpage.css" rel="stylesheet" type="text/css">

<div class="subjectpage container">
	@include('header', [$title='Subject Page', $position='normal'])

	<div class="title">
		Các khóa học {{$subject->name}}
	</div>

	@php
		$i = 0;
	@endphp
	
	@foreach ($courses as $course)
		<div class="course-wrapper @if ($i % 2 == 1) right @endif" data-id="{{$course->id}}">
			<div class="img" style="background: url('{{$course->img_url}}')"></div>
			<div class="info">
				<div class="name">{{$course->name}}</div>
				<div class="desc">{{$course->description}}</div>
				<div class="price">{{number_format($course->price)}} VNĐ</div>
			</div>
		</div>
		@php
		$i = $i + 1;
		@endphp
	@endforeach
	<div id="classModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                    <h2 id="form-title">Danh sách lớp học</h2>
                    <table id="example" class="table table-bordered table-hover">
					    <thead>
					        <tr>
					            <th>Mã lớp</th>
					            <th>Ngày bắt đầu</th>
					            <th>Ngày kết thúc</th>
					            <th>Sĩ số</th>
					            <th>Hành động</th>
					        </tr>
					    </thead>
					    <tbody>
					        
					    </tbody>
					</table>
                </div>      
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>

<script type="text/javascript">
	$('.course-wrapper').click(function() {
		$('#classModal tbody').empty();
		$.ajax({
            url : "getclassfromcourse" + $(this).data('id'),
            type : "get",
            dataType:"text",
            success : function (result){
            	obj = JSON.parse(result);
  				console.log(obj);
  				var i;
				for (i = 0; i < obj.length; i++) {
					$string = '<tr><td>' + obj[i]['id'] + '</td><td>' + obj[i]['start_date'] + '</td><td>' + obj[i]['end_date'] +'</td><td></td><td class="action"><a href="./classregister">Đăng kí</a></td></tr>';
					$('#classModal tbody').append($string);
				}
            }
        });
		$('#classModal').modal('show', 300);
	});
</script>

@include('footer')