<div id="addcourse" class="addbutton hvr-sweep-to-right" data-name="Thêm khóa học">Thêm khóa học</div>
<table id="example" class="table table-bordered table-hover">
	<thead>
		<tr>
			<th>Tên khóa học</th>
			<th>Môn học</th>
			<th>Số lớp học</th>
			<th>Giá</th>
			<th>Ghi chú</th>
			<th>Hành động</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($courses as $course)
		    <tr>
			 	<td>
			 		<a href="./course/{{$course->id}}" target='_blank'>{{$course->name}}</a>
			 	</td>
			 	<td>{{$course->subject}}</td>
			 	<td></td>
			 	<td>{{number_format($course->price)}} VNĐ</td>
			 	<td></td>
			 	<td class="action">
			 		<a id='edit' data-name="Sửa khóa học" data-id='{{$course->id}}'><i class="fas fa-edit"></i>Sửa</a><a><i class="fas fa-trash-alt"></i>Xóa</a>
			 	</td>
			</tr>
		@endforeach
	</tbody>
</table>
<div id="editModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="main-agileits">
                <div class="form-w3-agile clearfix">
                    <form action="{{url('login')}}" method="POST" role="form">
                        <h2 id="form-title"></h2>
                        <div class="form-sub-w3 col-md-6">
                            <input type="text" placeholder="Tên khóa học" name="name">
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <select name="cars">
								<option disabled selected hidden>Môn học</option>
								<option value="Tiếng Anh">Tiếng Anh</option>
								<option value="Mỹ Thuật">Mỹ Thuật</option>
								<option value="Toán học">Toán học</option>
								<option value="Toán học">Tin học</option>
							</select>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <input type="text" placeholder="Giá" name="price">
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <select name="cars">
								<option value="" selected>Khóa học tiên quyết</option>
								<option value="Tiếng anh trẻ em">Tiếng anh trẻ em</option>
								<option value="Tiếng anh TOEIC">Tiếng anh TOEIC</option>
								<option value="Tiếng anh giao tiếp">Tiếng anh giao tiếp</option>
							</select>
                        </div>
                        <div class="form-sub-w3 col-md-12">
                            <textarea rows="5"></textarea>
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
	$('#edit').click(function(){
		var selector = $(this).parent().parent();
		$('#form-title').text($(this).data('name'));
		$('#form-button').val($(this).data('name'));
		$('#editModal').find('input[name="name"]').val(selector.find('td:nth-child(1) a').text());
		$('#editModal').find('input[name="price"]').val(selector.find('td:nth-child(4)').text());
        $('#editModal').modal('show', 300);
    })
    $('#addcourse').click(function(){
    	$('#form-title').text($(this).data('name'));
    	$('#form-button').val($(this).data('name'));
    	$('#editModal').find('input[name="name"]').val("");
		$('#editModal').find('input[name="price"]').val("");
        $('#editModal').modal('show', 300);
    })
</script>