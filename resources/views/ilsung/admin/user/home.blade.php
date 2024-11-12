@extends('smart-ver2.admin.admin-layout')

@section('content')
    <div class="container admin">
        <div class="modal" id="modal-show">
            <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
                <div class="modal-content">
                    {{-- <div class="modal-header">
                        @include('smart-ver2.pages.layout.header')
                    </div> --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Close</button>
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
                                                    <li id="time-update"></li>
                                                    <li id="tac-gia"></li>
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
                </div>
            </div>
        </div>

        <div class="modal" id="modal-created">

            <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">

                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <form action="" method="post" enctype="multipart/form-data" id="create-post">
                                @csrf

                                <div class="form-group">
                                    <label class="form-check-label" for="title-creat">Tiêu đề bài viết</label>
                                    <input type="text" name="title" id="title-creat" class="form-control">
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <div class="form-group mb-3">
                                            <label for="chuyen-muc">CHUYÊN MỤC</label>
                                            <select class="form-select" id="chuyen-muc">
                                                <option value="SMART" selected>SMART</option>
                                                <option>STUDY</option>
                                                <option>MIND</option>
                                                <option>ACTION</option>
                                                <option>RELATIONSHIO</option>
                                                <option>TARGET</option>
                                                <option>SÁCH</option>
                                                <option>CHÍNH SÁCH</option>
                                                <option>QUY ĐỊNH</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-3">
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
                                        <div class="form-group mb-3">
                                            <label for="date_created">Thời gian</label>
                                            <select class="form-select" id="date_created">
                                                <option value="8">Tháng 8</option>
                                                <option value="9" selected>Tháng 9</option>
                                                <option value="10">Tháng 10</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-check-label" for="image-title">Ảnh title</label>
                                            <textarea id="image-title" class="form-control" style="height: 400px"></textarea>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="form-check-label" for="content-creat">Nội Dung</label>
                                    <textarea id="content-creat" class="form-control" style="height: 400px"></textarea>
                                </div>

                            </form>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" id="created" class="btn btn-primary">Created</button>
                        <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>

        </div>
        <div class="modal fade" id="DeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

        {{-- <div class="container mt-5"> --}}
        <ul id="myTab" class="nav nav-tabs boot-tabs mb-5">
            <li class="nav-item">
                <button class="nav-link" id="ALL" data-bs-toggle="tab" data-bs-target="#all-post" type="button"
                    role="tab" aria-controls="nav-disabled" aria-selected="false">All
                    Post</button>
            </li>
            <li class="nav-item">
                <button class="nav-link " id="SMART" data-bs-toggle="tab" data-bs-target="#smart-post"
                    type="button" role="tab" aria-controls="nav-disabled" aria-selected="false">SMART</button>
            </li>
            <li class="nav-item"> <button class="nav-link " id="STUDY" data-bs-toggle="tab"
                    data-bs-target="#study-post" type="button" role="tab" aria-controls="nav-home"
                    aria-selected="true">STUDY</button></li>
            <li class="nav-item"> <button class="nav-link" id="MIND" data-bs-toggle="tab"
                    data-bs-target="#mind-post" type="button" role="tab" aria-controls="nav-profile"
                    aria-selected="false">MIND</button></li>
            <li class="nav-item">
                <button class="nav-link" id="ACTION" data-bs-toggle="tab" data-bs-target="#action-post"
                    type="button" role="tab" aria-controls="nav-contact" aria-selected="false">ACTION</button>

            </li>
            <li class="nav-item">
                <button class="nav-link" id="RELATIONSHIP" data-bs-toggle="tab" data-bs-target="#relationship-post"
                    type="button" role="tab" aria-controls="nav-disabled"
                    aria-selected="false">RELATIONSHIP</button>
            </li>
            <li class="nav-item ">
                <button class="nav-link" id="TARGET" data-bs-toggle="tab" data-bs-target="#target-post"
                    type="button" role="tab" aria-controls="nav-disabled" aria-selected="false">TARGET</button>
            </li>
            <li class="nav-item ">
                <button class="nav-link" id="SÁCH" data-bs-toggle="tab" data-bs-target="#sach-post" type="button"
                    role="tab" aria-controls="nav-disabled" aria-selected="false">SÁCH</button>
            </li>
            <li class="nav-item ">
                <button class="nav-link" id="QUY ĐỊNH" data-bs-toggle="tab" data-bs-target="#quy-dinh-post"
                    type="button" role="tab" aria-controls="nav-disabled" aria-selected="false">QUY ĐỊNH</button>
            </li>
            <li class="nav-item ">
                <button class="nav-link" id="CHÍNH SÁCH" data-bs-toggle="tab" data-bs-target="#chinh-sach-post"
                    type="button" role="tab" aria-controls="nav-disabled" aria-selected="false">CHÍNH SÁCH</button>
            </li>
        </ul>


        <div class="tab-content mt-4" id="nav-tabContent">
            {{-- =====  Hoạt động nổi bật ===== --}}
            <div class="tab-pane fade show active " id="all-post" role="tabpanel" aria-labelledby="all"
                tabindex="0">

                <div class="row mb-2">
                    <div class="col-md-12 ">
                        <div id="success_message"></div>
                        <div class="card card-ke-hoach">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-10">
                                        <button type="button" id="creat" class="btn btn-primary"
                                            data-bs-toggle="modal" data-bs-target="#modal-created">tạo bài
                                            viết</button>
                                    </div>
                                    <div class="col-2 form-group ">
                                        <label for="team"> Chọn Tháng: </label>
                                        <select name="" id="team" class="form-select">
                                            <option value="" selected>all</option>
                                            <option value="12">Tháng 12</option>
                                            <option value="11">Tháng 11</option>
                                            <option value="10">Tháng 10</option>
                                            <option value="9">Tháng 9</option>
                                            <option value="8">Tháng 8</option>
                                            <option value="7">Tháng 7</option>
                                            <option value="6">Tháng 6</option>
                                            <option value="5">Tháng 5</option>
                                            <option value="4">Tháng 4</option>
                                            <option value="3">Tháng 3</option>
                                            <option value="2">Tháng 2</option>
                                            <option value="1">Tháng 1</option>
                                        </select>
                                    </div>
                                </div>

                                <table class="table table-bordered text-center table-hover" style="width:100%"
                                    id="table-post-all">
                                    <thead class="table-success">
                                        <tr>
                                            <th>No.</th>
                                            <th>Tiêu đề</th>
                                            <th>ID</th>
                                            <th>Tháng</th>
                                            <th>STT</th>
                                            <th>Hide</th>
                                            <th>Team</th>
                                            <th>locale</th>
                                            <th>Chuyên mục</th>
                                            <th>Remark</th>
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

        </div>
    </div>
@endsection

@section('admin-js')
        <script>
        $(document).ready(function() {
            var month_search = @json($month_search);
            var tab = @json($table);
            document.getElementById(tab).classList.add('active');
            var table = 'Smart_Post';
            show_post_list(tab, month_search);

            var buttom = document.querySelectorAll("#myTab button");
            buttom.forEach((item) => item.addEventListener('click', function(event) {
                month_search = '';
                tab = this.id;
                show_post_list(tab, month_search);
            }));

            $('#team').on('change', function() {
                month_search = $(this).val();
                show_post_list(tab, month_search);
            });

            $(document).on('click', '#creat', function(e) {
                e.preventDefault();
                var url = "{{ route('post.created') }}";
                window.location.href = url;
            });

            $(document).on('click', '#view', function(e) {
                e.preventDefault();
                $('#modal-show').modal('show');
                var post_id = this.value;

                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.post.show') }}",
                    dataType: 'json',
                    data: {
                        posts_id: post_id
                    },
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
                var url = "{{ route('post.edit', ':id') }}".replace(':id', post_id);
                window.location.href = url;
            });

            function show_post_list(tab, month_search) {
                var table = '#table-post-all';
                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.post.list') }}",
                    dataType: "json",
                    data: {
                        table: tab,
                        month: month_search
                    },
                    success: function(response) {
                        var data = [];
                        var count = 0;

                        $.each(response.post, function(index, value) {
                            count++;
                            id = value.id;

                            var view = '<button type="button" value="' + id +
                                '" data-bs-toggle="modal" data-bs-target="#modal-show" class="btn btn-primary editbtn btn-sm" id="view"><span class="icon-eye2"></span></button>';

                            var edit = '<button type="button" value="' + id +
                                '"class="btn btn-success editbtn btn-sm" id="edit"><span class="icon-pencil2"></span></button>';
                            var deleted = '<button type="button" value="' + id +
                                '" data-bs-toggle="modal" data-bs-target="#DeleteModal" class="btn btn-danger editbtn btn-sm" id="delete"><span class="icon-trash1"></span></button>';

                            data.push([
                                count,
                                value.title,
                                value.id,
                                value.month,
                                value.STT,
                                value.post_show,
                                value.team,
                                value.locale,
                                value.chuyen_muc,
                                view + edit + deleted,
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
                        });
                        $('#team').val(month_search);
                    }
                });
            }

            $(document).on('click', '#delete', function() {
                var stud_id = $(this).val();
                $('#deleteing_id').val(stud_id);
            });

            $(document).on('click', '.delete-post', function(e) {
                e.preventDefault();
                var post_id = $('#deleteing_id').val();
                console.log(tab);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content')
                    }
                });

                $.ajax({
                    type: "post",
                    url: "admin-dashboard/post/delete/" + post_id,
                    dataType: "json",
                    success: function(response) {
                        // console.log(response);
                        if (response.status == 404) {
                            $('#DeleteModal').modal('hide');
                            window.alert('Không thể xóa viết thành công');

                        } else {
                            $('#DeleteModal').modal('hide');
                            window.alert('Xóa bài viết thành công');

                        }
                        show_post_list(tab);
                    }
                });
            });

            function editTable() {
                $('#table-post-all').Tabledit({
                    url: "admin-dashboard/table/edit-table/" + table,
                    method: 'POST',
                    dataType: 'json',
                    columns: {
                        identifier: [0, 'id'],
                        editable: colum_table,
                    },
                    restoreButton: false,
                    deleteButtom: false,
                    onSuccess: function(data, textStatus, jqXHR) {
                        if (data.action == 'delete') {
                            $('#' + data.id).remove();
                            /*  data_table_view(table, 'Bảng' + table); */
                            $('#table-post-all').DataTable().ajax.reload();
                        }
                    }
                });
            }

            /*  $('#table-post-all').on('draw.dt', function() {

                 editTable();

             }); */

        });
    </script>
@endsection
