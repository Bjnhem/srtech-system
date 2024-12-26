@extends('smart-ver2.admin.admin-layout')

@section('content')
    <div class="container">
        <div class="modal admin" id="modal-show">
            <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="posts">
                                <div class="entry">
                                    <h1 class="title" id="tieu-de"></h1>
                                    <div class="top_area clearfix mt-3">
                                        <div class="meta">
                                            <div class="entry-meta">
                                                <ul>
                                                    <li id="time-update"><i class="icon-calendar3"></i></li>
                                                    <li id="tac-gia"><i class="icon-comments"></i></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="entry-content content-1 my-5" id="noi-dung">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade admin" id="DeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Bài viết</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h4>Confirm to Delete Data Bài viết ?</h4>
                        <input type="hidden" id="deleteing_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary delete-post">Yes Delete</button>
                    </div>
                </div>
            </div>
        </div>
        

        <div class="fancy-title title-bottom-border">
            <h3>TÀI LIỆU THAM KHẢO</h3>
        </div>

        {{-- <div class="input-group">
            <span class="input-group-btn">
                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                    <i class="fa fa-picture-o"></i> Choose
                </a>
            </span>
            <input id="thumbnail" class="form-control" type="text" name="filepath">
        </div> --}}
        <button type="button" id="creat" class="btn btn-primary mb-3">Tạo Tiêu Chuẩn</button>
        <div class="row mb-2">
            <div class="col-md-12 ">
                <div id="success_message"></div>
                <div class="card card-ke-hoach">
                    <div class="card-body">
                        <table class="table table-admin table-bordered text-center table-hover" style="width:100%"
                            id="table-tieu-chuan-all">
                            <thead class="table-success">
                                <tr>
                                    <th style="width:5%" rowspan="2">ID</th>
                                    <th style="width:45%" rowspan="2">title</th>
                                    <th style="width:50%" colspan="5">Remark</th>
                                </tr>
                                <tr>
                                    <th style="width:10%">Chuyên mục</th>
                                    <th style="width:10%">Tháng</th>
                                    <th style="width:10%">View</th>
                                    <th style="width:10%">Edit</th>
                                    <th style="width:10%">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('admin-js')
    <script src="vendor/laravel-filemanager/js/stand-alone-button.js"></script>

    <script>
        var route_prefix = "http://107.114.222.206:8000/app/public/laravel-filemanager";
        $('#lfm').filemanager('image', {
            prefix: route_prefix
        });

        tinymce.init({
            selector: '#content-creat',
            plugins: 'image link autolink autoresize advlist lists table code',
            toolbar: 'undo redo | styles | bold italic  underline strikethrough |alignleft aligncenter alignright alignjustify |table media| bullist numlist outdent indent |image',
            menubar: 'file edit view insert format tools table tc help',
            toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media pageembed template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
            file_picker_callback: function(callback, value, meta) {
                let x = window.innerWidth || document.documentElement.clientWidth || document
                    .getElementsByTagName('body')[0].clientWidth;
                let y = window.innerHeight || document.documentElement.clientHeight || document
                    .getElementsByTagName('body')[0].clientHeight;

                let type = 'image' === meta.filetype ? 'Images' : 'Files',
                    url = 'laravel-filemanager?editor=tinymce5&type=' + type;

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

            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            mergetags_list: [{
                    value: 'First.Name',
                    title: 'First Name'
                },
                {
                    value: 'Email',
                    title: 'Email'
                },
            ],
            ai_request: (request, respondWith) => respondWith.string(() => Promise.reject(
                "See docs to implement AI Assistant")),
        });
    </script>

    <script>
        $(document).ready(function() {

            function show_post_list(tab, table) {
                $.ajax({
                    type: "GET",
                    url: "admin-dashboard/tieu-chuan/list/" + tab,
                    dataType: "json",
                    success: function(response) {
                        var data = [];
                        var count = 0;

                        $.each(response.post, function(index, value) {
                            count++;
                            id = value.id;

                            var view = '<button type="button" value="' + id +
                                '"class="btn btn-primary editbtn btn-sm" id="view">View</button>';

                            var edit = '<button type="button" value="' + id +
                                '"class="btn btn-danger editbtn btn-sm" id="edit">Edit</button>';
                            var deleted = '<button type="button" value="' + id +
                                '"class="btn btn-danger editbtn btn-sm" id="delete">Delete</button>';

                            data.push([
                                count,
                                value.title,
                                value.chuyen_muc,
                                value.month,
                                view,
                                edit,
                                deleted,

                            ]);

                        });

                        $(table).DataTable().destroy();
                        $(table).DataTable({
                            data: data,
                            "searching": true,
                            "autoWidth": false,
                            "paging": true,
                            "ordering": false,
                            "info": false,
                            "columnDefs": [{
                                "targets": 1,
                                "className": "dt-left",
                            }],

                            // columns: [{
                            //         data: "0"
                            //     },
                            //     {
                            //         data: "1"
                            //     },
                            //     {
                            //         data: "2"
                            //     },
                            //     {
                            //         data: "3"
                            //     },
                            //     {
                            //         data: "4"
                            //     },
                            //     {
                            //         data: "5"
                            //     },
                            //     {
                            //         data: "6"
                            //     },


                            // ]
                        });
                    }
                });
            }

            show_post_list('tieu chuan', '#table-tieu-chuan-all');
            $(document).on('click', '#creat', function(e) {
                e.preventDefault();
                var url = "{{ route('tieu.chuan.created') }}";
                window.location.href = url;
            });



            $(document).on('click', '#view', function(e) {
                e.preventDefault();
                $('#modal-show').modal('show');
                var post_id = this.value;
                            $.ajax({
                    type: "GET",
                    url: "admin-dashboard/tieu-chuan/show/" + post_id,
                    success: function(response) {
                        console.log(response.post);
                        if (response.status == 404) {
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);

                        } else {

                            $('#time-update').text(response.post.created_at);
                            $('#tac-gia').text(response.post.team);
                            $('#noi-dung').html(response.post.content);
                            $('#tieu-de').text(response.post.title);
                        }
                    }
                });
                $('.btn-close').find('input').val('');


            });

            $(document).on('click', '#edit', function(e) {
                e.preventDefault();
                var post_id = this.value;
                console.log(post_id);
                var url = "{{ route('tieu.chuan.edit', ':id') }}".replace(':id', post_id);
                window.location.href = url;
                console.log(url);

            });

            $(document).on('click', '#delete', function() {
                var stud_id = $(this).val();
                $('#deleteing_id').val(stud_id);
                $('#DeleteModal').modal('show');

            });

            $(document).on('click', '.delete-post', function(e) {
                e.preventDefault();
                var post_id = $('#deleteing_id').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content')
                    }
                });

                $.ajax({
                    type: "post",
                    url: "admin-dashboard/tieu-chuan/delete/" + post_id,
                    dataType: "json",
                    success: function(response) {
                        // console.log(response);
                        if (response.status == 404) {
                            $('#DeleteModal').modal('hide');
                            window.alert('Không thể xóa viết');

                        } else {

                            window.alert('Xóa bài viết thành công');
                            $('#DeleteModal').modal('hide');
                        }
                        show_post_list('tieu chuan', '#table-tieu-chuan-all');
                    }
                });
            });

        });
    </script>
@endsection
