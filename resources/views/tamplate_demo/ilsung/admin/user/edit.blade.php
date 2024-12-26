@extends('smart-ver2.admin.admin-layout')

@section('content')
    <div class="container">
        <div class="card my-4 created">
            <div class="card-header">
                <h3>CHỈNH SỬA BÀI VIẾT</h3>
            </div>
            <div class="card-footer">
                <div class="" id="buttom-tieu-chuan">
                    <button type="button" id="updated" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
            <div class="card-body">
                <div class="admin">
                    <form action="" method="POST" enctype="multipart/form-data" id="create-post">
                        @csrf
                        <div class="form-group">
                            <label class="form-check-label" for="title-creat">Tiêu đề bài viết</label>
                            <input type="text" name="title" id="title-creat" class="form-control">
                        </div>
                        <div class="row mb-3 form-group">
                            <div class="col-6">
                                <div class="row form-group">
                                    <div class="form-group mb-3 col-6">
                                        <label for="chuyen-muc">CHUYÊN MỤC</label>
                                        <select class="form-select" id="chuyen-muc">
                                            <option value="SMART" selected>SMART</option>
                                            <option>STUDY</option>
                                            <option>MIND</option>
                                            <option>ACTION</option>
                                            <option>RELATIONSHIP</option>
                                            <option>TARGET</option>
                                            <option>SÁCH</option>
                                            <option>CHÍNH SÁCH</option>
                                            <option>QUY ĐỊNH</option>
                                            <option>KHEN THƯỞNG</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3 col-6">
                                        <label for="team_group">Team</label>
                                        <select class="form-select" id="team_group">
                                            <option value="SEVT" selected>SEVT</option>
                                            <option>CNC T</option>
                                            <option>Glass T</option>
                                            <option>Production T</option>
                                            <option>R&D T</option>
                                            <option>QC T</option>
                                            <option>Other T</option>
                                        </select>

                                    </div>
                                    <div class="form-group mb-3 col-6">
                                        <label for="date_created">Thời gian</label>
                                        <select class="form-select" id="date_created">
                                            <option value="1">Tháng 1</option>
                                            <option value="2">Tháng 2</option>
                                            <option value="3">Tháng 3</option>
                                            <option value="4">Tháng 4</option>
                                            <option value="5">Tháng 5</option>
                                            <option value="6">Tháng 6</option>
                                            <option value="7">Tháng 7</option>
                                            <option value="8">Tháng 8</option>
                                            <option value="9">Tháng 9</option>
                                            <option value="10">Tháng 10</option>
                                            <option value="11">Tháng 11</option>
                                            <option value="12">Tháng 12</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3 col-6">
                                        <label for="stt">STT</label>
                                        <select class="form-select" id="stt">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3 col-6">
                                        <label for="post_show">Hiển thị bài viết</label>
                                        <select class="form-select" id="post_show">
                                            <option value="0">Ẩn</option>
                                            <option value="1" selected>Hiện</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3 col-6">
                                        <label for="locale">Ngôn ngữ</label>
                                        <select class="form-select" id="locale">
                                            <option value="vi" selected>Tiếng việt</option>
                                            <option value="ko">Korean</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-check-label" for="image-title">Ảnh title</label>
                                    <textarea id="image-title" class="form-control text-mce"></textarea>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="form-check-label" for="content">Nội Dung</label>
                            <textarea id="content" class="form-control text-mce"></textarea>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection

@section('admin-js')
    <script>
        $(document).ready(function() {
            var month_search;
            var table;
            var url =
                "{{ route('admin.edit.post', ['table' => ':table', 'month_search' => ':month_search']) }}";
            var post_id = @json($id);
            edit_show(post_id)

            function edit_show(id) {
                console.log(post_id);
                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.post.show') }}",
                    dataType: 'json',
                    data: {
                        posts_id: post_id,
                    },
                    success: function(response) {
                        console.log(response.post);
                        if (response.status == 404) {
                            $('#success_message').addClass(
                                'alert alert-success');
                        } else {
                            $('#create-post').val(response.post.id);
                            $('#title-creat').val(response.post.title);
                            $('#team_group').val(response.post.team);
                            $('#date_created').val(response.post.month);
                            $('#chuyen-muc').val(response.post.chuyen_muc);
                            $('#post_show').val(response.post.post_show);
                            $('#stt').val(response.post.STT);
                            $('#locale').val(response.post.locale);


                            tinymce.init({
                                selector: '#content',
                                // relative_urls: false,
                                plugins: 'image link autolink autoresize advlist lists table',
                                toolbar: 'undo redo | styles | bold italic  underline strikethrough |alignleft aligncenter alignright alignjustify |table media image| bullist numlist outdent indent',
                                file_picker_callback: function(callback, value, meta) {
                                    let x = window.innerWidth || document.documentElement
                                        .clientWidth || document
                                        .getElementsByTagName('body')[0].clientWidth;
                                    let y = window.innerHeight || document.documentElement
                                        .clientHeight || document
                                        .getElementsByTagName('body')[0].clientHeight;

                                    let type = 'image' === meta.filetype ? 'Images' :
                                        'Files',
                                        url = 'laravel-filemanager?editor=tinymce5&type=' +
                                        type;

                                    tinymce.activeEditor.windowManager.openUrl({
                                        url: url,
                                        title: 'Filemanager',
                                        width: x * 0.8,
                                        height: y * 0.8,
                                        onMessage: (api, message) => {
                                            callback(message.content);
                                        }
                                    });

                                },
                                setup: function(editor) {
                                    editor.on('init', function() {
                                        editor.setContent(response.post
                                            .content);
                                    });
                                }
                            });


                            tinymce.init({
                                selector: '#image-title',
                                // relative_urls: false,
                                height: 300,
                                plugins: 'image link autolink advlist lists table',
                                toolbar: 'image',
                                file_picker_callback: function(callback, value, meta) {
                                    let x = window.innerWidth || document.documentElement
                                        .clientWidth || document
                                        .getElementsByTagName('body')[0].clientWidth;
                                    let y = window.innerHeight || document.documentElement
                                        .clientHeight || document
                                        .getElementsByTagName('body')[0].clientHeight;

                                    let type = 'image' === meta.filetype ? 'Images' :
                                        'Files',
                                        url = 'laravel-filemanager?editor=tinymce5&type=' +
                                        type;

                                    tinymce.activeEditor.windowManager.openUrl({
                                        url: url,
                                        title: 'Filemanager',
                                        width: x * 0.8,
                                        height: y * 0.8,
                                        onMessage: (api, message) => {
                                            callback(message.content);
                                        }
                                    });

                                },
                                setup: function(editor) {
                                    editor.on('init', function() {
                                        if (response.post.image_title != null) {
                                            editor.setContent(response.post
                                                .image_title);
                                        }
                                    });
                                },
                            });
                        }

                    }
                });
            }
            $(document).on('click', '.close', function(e) {
                e.preventDefault();
                table = $('#chuyen-muc').val();
                month_search = $('#date_created').val();
                var url =
                    "{{ route('admin.edit.post', ['table' => ':table', 'month_search' => ':month_search']) }}";
                url = url.replace(':table', table).replace(':month_search', month_search);
                var form = document.getElementById('create-post');

                form.reset();
                window.location.href = url;
            });

            $(document).on('click', '#updated', function(e) {
                e.preventDefault();
                var noi_dung = tinymce.get('content').getContent();
                var noi_dung_2 = tinymce.get('image-title').getContent();
                var regex = /<img[^>]*src="([^"]+)"[^>]*>/;
                var data = noi_dung_2.match(regex);
                if (data) {
                    var image_path = data[0];
                } else {
                    var image_path = [];
                }
                var post_id = $('#create-post').val();

                var data = {
                    'title': $('#title-creat').val(),
                    'content': noi_dung,
                    'month': $('#date_created').val(),
                    'team': $('#team_group').val(),
                    'chuyen_muc': $('#chuyen-muc').val(),
                    'image_path': image_path,
                    'post_show': $('#post_show').val(),
                    'stt': $('#stt').val(),
                    'locale': $('#locale').val(),
                    'remark': 'post',
                    'id': post_id,
                }
                console.log(data);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: '{{ route('post.update') }}',
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 400) {
                            $('#update_msgList').html("");
                            $('#update_msgList').addClass(
                                'alert alert-danger');
                            $.each(response.errors, function(key,
                                err_value) {
                                window.alert('Error: Kiểm tra lại nội dung');
                            });

                        } else {
                            window.alert('update bài viết thành công');
                            table = $('#chuyen-muc').val();
                            month_search = $('#date_created').val();
                            url = url.replace(':table', table).replace(':month_search',
                                month_search);
                            window.location.href = url;
                        }

                    }
                });
            });

        });
    </script>
@endsection
