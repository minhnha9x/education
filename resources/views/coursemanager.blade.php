<div id="addcourse" class="addbutton hvr-sweep-to-right" data-name="Thêm khóa học">Thêm khóa học</div>
<table id="example" class="table table-bordered table-hover">
	<thead>
		<tr>
			<th>Tên khóa học</th>
			<th>Môn học</th>
			<th>Số buổi học</th>
			<th>Số lớp học</th>
			<th>Học phí</th>
			<th>Hành động</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($courses as $course)
		    <tr>
			 	<td>
			 		<a href="./course_{{$course->id}}" target='_blank'>{{$course->name}}</a>
			 	</td>
			 	<td>{{$course->subject}}</td>
			 	<td>{{$course->total_of_period}}</td>
			 	<td>{{$course->count}}</td>
			 	<td>{{number_format($course->price)}} VNĐ</td>
			 	<td class="action">
			 		<a class='edit' data-name="Sửa khóa học" data-id='{{$course->id}}'><i class="fas fa-edit"></i>Sửa</a><a><i class="fas fa-trash-alt"></i>Xóa</a>
			 	</td>
			</tr>
		@endforeach
	</tbody>
</table>
<div id="courseModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                    <form action="{{url('addcourse')}}" method="POST" role="form">
                        <h2 id="form-title"></h2>
                        <div class="form-sub-w3 col-md-6">
                            <input type="text" placeholder="Tên khóa học" name="name">
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <select name="subject">
								<option disabled selected hidden>Môn học</option>
								@foreach ($subjects as $s)
									<option value="{{$s->name}}">{{$s->name}}</option>
								@endforeach
							</select>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <input type="text" placeholder="Học phí" name="price">
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <select name="required">
								<option value="" selected>Khóa học tiên quyết</option>
								@foreach ($courses as $c)
									<option value="{{$c->name}}">{{$c->name}}</option>
								@endforeach
							</select>
                        </div>
                        <div class="form-sub-w3 col-md-12">
                            <textarea rows="5" name="description" placeholder="Mô tả chi tiết"></textarea>
                        </div>
                        {!! csrf_field() !!}
                        <div class="submit-w3l col-md-12">
                            <input type="submit" id='form-button'>
                        </div>
                    </form>
                </div>      
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
	$('.edit').click(function(){
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
		$.ajax({
            url : "getcourse" + $(this).data('id'),
            type : "get",
            dataType:"text",
            success : function (result){
            	obj = JSON.parse(result);
            	$('#courseModal').find('input[name="name"]').val(obj[0]['name']);
				$('#courseModal').find('input[name="price"]').val(obj[0]['price']);
				$('#courseModal').find('option[value="' + obj[0]['subject'] + '"]').attr('selected','selected');
            }
        });
		$('#form-title').text($(this).data('name'));
		$('#form-button').val($(this).data('name'));
		
        $('#courseModal').modal('show', 300);
    })
    $('#addcourse').click(function(){
    	$('#form-title').text($(this).data('name'));
    	$('#form-button').val($(this).data('name'));
    	$('#courseModal').find('input[name="name"]').val("");
		$('#courseModal').find('input[name="price"]').val("");
        $('#courseModal').modal('show', 300);
    })
</script>