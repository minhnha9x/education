<div id="addcourse" class="addbutton hvr-sweep-to-right" data-name="Thêm khóa học">Thêm khóa học</div>
<table id="example" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Tên khóa học</th>
            <th>Môn học</th>
            <th>Số buổi học</th>
            <th>Số lớp học</th>
            <th>Học phí</th>
            <th>Môn tiên quyết</th>
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
                <td>{{$course->certificate_required}}</td>
                <td class="action">
                    <a class='edit' data-name="Sửa khóa học" data-id='{{$course->id}}'><i class="fas fa-edit"></i>Sửa</a><a href="{{url('deletecourse') . $course->id}}" onclick="return confirm('Are you sure you want to delete this course?');"><i class="fas fa-trash-alt"></i>Xóa</a>
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
                    <form method="POST" role="form">
                        <h2 id="form-title"></h2>
                        <div class="form-sub-w3 col-md-6">
                            <input type="text" placeholder="Tên khóa học" name="name">
                            <input type="hidden" type="text" name="id">
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <select name="subject">
                                <option disabled selected hidden>Môn học</option>
                                @foreach ($subjects as $s)
                                    <option value="{{$s->id}}">{{$s->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <input type="number" placeholder="Học phí" name="price">
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <input type="number" placeholder="Tổng số buổi học" name="total_of_period">
                        </div>
                        <div class="form-sub-w3 col-md-6">
                            <select name="required">
                                <option value="" selected>Khóa học tiên quyết</option>
                            </select>
                        </div>
                        <div class="form-sub-w3 col-md-12">
                            <textarea rows="4" name="description" placeholder="Mô tả chi tiết"></textarea>
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
        $('#courseModal form').attr('action', '{{url('updatecourse')}}');
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
                //console.log(obj);
                $('#courseModal input[name="id"]').val(obj[0]['id']);
                $('#courseModal input[name="name"]').val(obj[0]['name']);
                $('#courseModal input[name="price"]').val(obj[0]['price']);
                $('#courseModal input[name="total_of_period"]').val(obj[0]['total_of_period']);
                $('#courseModal textarea[name="description"]').val(obj[0]['description']);
                $('#courseModal select[name="subject"] option[value="' + obj[0]['subjectid'] + '"]').attr('selected','selected');

                $('#courseModal').find('select[name="required"] option:not(:first-child)').remove();
                $.ajax({
                    url : "getcoursefromsub" + obj[0]['subjectid'],
                    type : "get",
                    dataType:"text",
                    success : function (result){
                        obj1 = JSON.parse(result);
                        var i;
                        for (i = 0; i < obj1.length; i++) {
                            $string = '<option value="' + obj1[i]['id'] + '">' + obj1[i]['name'] + '</option>';
                            $('#courseModal select[name="required"]').append($string);
                        }
                        $('#courseModal select[name="required"] option[value="' + obj[0]['certificate_required'] + '"]').attr('selected','selected');
                    },
                });
            }
        });
        $('#form-title').text($(this).data('name'));
        $('#form-button').val($(this).data('name'));
        
        $('#courseModal').modal('show', 300);
    })
    $('#courseModal select[name="subject"]').on('change', function() {
        $('#courseModal').find('select[name="required"] option:not(:first-child)').remove();
        $.ajax({
            url : "getcoursefromsub" + $(this).val(),
            type : "get",
            dataType:"text",
            success : function (result){
                obj = JSON.parse(result);
                var i;
                for (i = 0; i < obj.length; i++) {
                    $string = '<option value="' + obj[i]['id'] + '">' + obj[i]['name'] + '</option>';
                    $('#courseModal select[name="required"]').append($string);
                }
            }
        });
    });
    $('#addcourse').click(function(){
        $('#courseModal form').attr('action', '{{url('addcourse')}}');
        $('#form-title').text($(this).data('name'));
        $('#form-button').val($(this).data('name'));
        $('#courseModal input[name="name"]').val("");
        $('#courseModal input[name="price"]').val("");
        $('#courseModal input[name="total_of_period"]').val("");
        $('#courseModal textarea[name="description"]').val("");
        $('#courseModal').modal('show', 300);
    })
</script>