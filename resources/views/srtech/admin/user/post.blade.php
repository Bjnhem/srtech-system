@extends('smart-ver2.admin.admin-layout')

@section('content')
    <div class="container">

        <div class="modal" id="modal-show">

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
        <div class="modal" id="modal-edit">

            <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit-post-id">
                        <form action="" method="post" enctype="multipart/form-data" id="edit-post">
                            @csrf

                            <div class="form-group">
                                <label class="form-check-label" for="title-edit">Tiêu đề bài viết</label>
                                <input type="text" name="title" id="title-edit" class="form-control">
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label for="chuyen-muc-edit">CHUYÊN MỤC</label>
                                        <select class="form-select" id="chuyen-muc-edit">
                                            <option value="SMART" selected>SMART</option>
                                            <option>STUDY</option>
                                            <option>MIND</option>
                                            <option>ACTION</option>
                                            <option>RELATIONSHIO</option>
                                            <option>TARGET</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="team-group-edit">Team</label>
                                        <select class="form-select" id="team-group-edit">
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
                                        <label for="date-created-edit">Thời gian</label>
                                        <select class="form-select" id="date-created-edit">
                                            <option value="8">Tháng 8</option>
                                            <option value="9" selected>Tháng 9</option>
                                            <option value="10">Tháng 10</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-check-label" for="image-title-edit">Ảnh bìa bài viết</label>
                                        <textarea id="image-title-edit" class="form-control" style="height: 400px"></textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <label class="form-check-label" for="content-edit">Nội Dung</label>
                                <textarea id="content-edit" class="form-control" style="height: 400px"></textarea>
                            </div>

                        </form>

                    </div>

                    <div class="modal-footer">
                        <button type="button" id="updated" class="btn btn-primary">Updated</button>
                        <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Close</button>
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

        <div class="container mt-5">
            <ul id="myTab" class="nav nav-tabs boot-tabs mb-5">
                <li class="nav-item">
                    <button class="nav-link  active " id="all" data-bs-toggle="tab" data-bs-target="#all-post"
                        type="button" role="tab" aria-controls="nav-disabled" aria-selected="false">All
                        Post</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link " id="smart" data-bs-toggle="tab" data-bs-target="#smart-post"
                        type="button" role="tab" aria-controls="nav-disabled" aria-selected="false">SMART</button>
                </li>
                <li class="nav-item"> <button class="nav-link " id="study" data-bs-toggle="tab"
                        data-bs-target="#study-post" type="button" role="tab" aria-controls="nav-home"
                        aria-selected="true">STUDY</button></li>
                <li class="nav-item"> <button class="nav-link" id="mind" data-bs-toggle="tab"
                        data-bs-target="#mind-post" type="button" role="tab" aria-controls="nav-profile"
                        aria-selected="false">MIND</button></li>
                <li class="nav-item">
                    <button class="nav-link" id="action" data-bs-toggle="tab" data-bs-target="#action-post"
                        type="button" role="tab" aria-controls="nav-contact" aria-selected="false">ACTION</button>

                </li>
                <li class="nav-item">
                    <button class="nav-link" id="relationship" data-bs-toggle="tab" data-bs-target="#relationship-post"
                        type="button" role="tab" aria-controls="nav-disabled"
                        aria-selected="false">RELATIONSHIP</button>
                </li>
                <li class="nav-item ">
                    <button class="nav-link" id="target" data-bs-toggle="tab" data-bs-target="#target-post"
                        type="button" role="tab" aria-controls="nav-disabled" aria-selected="false">TARGET</button>
                </li>
                <li class="nav-item ">
                    <button class="nav-link" id="sach" data-bs-toggle="tab" data-bs-target="#sach-post"
                        type="button" role="tab" aria-controls="nav-disabled" aria-selected="false">SÁCH</button>
                </li>
            </ul>

            <button type="button" id="creat" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#modal-created">tạo bài
                viết</button>
            <div class="tab-content mt-4" id="nav-tabContent">
                {{-- =====  Hoạt động nổi bật ===== --}}
                <div class="tab-pane fade show active " id="all-post" role="tabpanel" aria-labelledby="all"
                    tabindex="0">
                    <div class="container">
                        <div class="row mb-2">
                            <div class="col-md-12 ">
                                <div id="success_message"></div>
                                <div class="card card-ke-hoach">
                                    <div class="card-body">
                                        <table class="table table-bordered text-center table-hover" style="width:100%"
                                            id="table-post-all">
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
                </div>

                <div class="tab-pane fade " id="smart-post" role="tabpanel" aria-labelledby="smart" tabindex="0">
                    <div class="container">
                        <div class="row mb-2">
                            <div class="col-md-12 ">
                                <div id="success_message"></div>
                                <div class="card card-ke-hoach">
                                    <div class="card-header text-center">
                                        <h3 id="title-post-smart"></h3>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered text-center table-hover" style="width:100%"
                                            id="table-post-smart">
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

                </div>
                <div class="tab-pane fade " id="study-post" role="tabpanel" aria-labelledby="study" tabindex="0">
                    <div class="container">
                        <div class="row mb-2">
                            <div class="col-md-12 ">
                                <div id="success_message"></div>
                                <div class="card card-ke-hoach">
                                    <div class="card-header text-center">
                                        <h3 id="title-post-study"></h3>

                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered text-center table-hover" style="width:100%"
                                            id="table-post-study">
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

                </div>

                <div class="tab-pane fade " id="mind-post" role="tabpanel" aria-labelledby="mind" tabindex="0">
                    <div class="container">
                        <div class="row mb-2">
                            <div class="col-md-12 ">
                                <div id="success_message"></div>
                                <div class="card card-ke-hoach">
                                    <div class="card-header text-center">
                                        <h3 id="title-post-mind"></h3>

                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered text-center table-hover" style="width:100%"
                                            id="table-post-mind">
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

                </div>

                <div class="tab-pane fade " id="action-post" role="tabpanel" aria-labelledby="action" tabindex="0">
                    <div class="container">
                        <div class="row mb-2">
                            <div class="col-md-12 ">
                                <div id="success_message"></div>
                                <div class="card card-ke-hoach">
                                    <div class="card-header text-center">
                                        <h3 id="title-post-action"></h3>
                                        <button type="button" id="created" class="btn btn-primary">tạo bài
                                            viết</button>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered text-center table-hover" style="width:100%"
                                            id="table-post-action">
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

                </div>

                <div class="tab-pane fade " id="relationship-post" role="tabpanel" aria-labelledby="relationship"
                    tabindex="0">
                    <div class="container">
                        <div class="row mb-2">
                            <div class="col-md-12 ">
                                <div id="success_message"></div>
                                <div class="card card-ke-hoach">
                                    <div class="card-header text-center">
                                        <h3 id="title-post-relationship"></h3>

                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered text-center table-hover" style="width:100%"
                                            id="table-post-relationship">
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

                </div>

                <div class="tab-pane fade" id="target-post" role="tabpanel" aria-labelledby="target" tabindex="0">
                    <div class="container">
                        <div class="row mb-2">
                            <div class="col-md-12 ">
                                <div id="success_message"></div>
                                <div class="card card-ke-hoach">
                                    <div class="card-header text-center">
                                        <h3 id="title-post-target"></h3>

                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered text-center table-hover" style="width:100%"
                                            id="table-post-target">
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

                </div>
                <div class="tab-pane fade" id="sach-post" role="tabpanel" aria-labelledby="sach" tabindex="0">
                    <div class="container">
                        <div class="row mb-2">
                            <div class="col-md-12 ">
                                <div id="success_message"></div>
                                <div class="card card-ke-hoach">
                                    <div class="card-header text-center">
                                        <h3 id="title-post-sach"></h3>

                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered text-center table-hover" style="width:100%"
                                            id="table-post-target">
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
            selector: 'textarea#content-creat',
            height: 400,
            plugins: 'image link autolink autoresize advlist lists table',
            toolbar: 'undo redo | styles | bold italic  underline strikethrough |alignleft aligncenter alignright alignjustify |table media| bullist numlist outdent indent |image',
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
            }
        });

        tinymce.init({
            selector: 'textarea#image-title',
            height: 222,
            plugins: 'link autoresize image autolink advlist lists',
            toolbar: "image ",
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
            }
        });

        tinymce.init({
            selector: 'textarea#content-edit',
            height: 400,
            plugins: 'image link autolink autoresize advlist lists',
            toolbar: 'undo redo | styles | bold italic  underline strikethrough |alignleft aligncenter alignright alignjustify | bullist numlist outdent indent |image',
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
            }
        });

        tinymce.init({
            selector: 'textarea#image-title-edit',
            height: 222,
            plugins: 'link autoresize image autolink advlist lists',
            toolbar: "image ",
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
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            show_post_list('all', '#table-post-all');

            $(document).on('click', '#smart', function(e) {
                e.preventDefault();
                show_post_list('smart', '#table-post-smart');
            });
            $(document).on('click', '#study', function(e) {
                e.preventDefault();
                show_post_list('study', '#table-post-study');
            });
            $(document).on('click', '#mind', function(e) {
                e.preventDefault();
                show_post_list('mind', '#table-post-mind');
            });
            $(document).on('click', '#action', function(e) {
                e.preventDefault();
                show_post_list('action', '#table-post-action');
            });
            $(document).on('click', '#relationship', function(e) {
                e.preventDefault();
                show_post_list('relationship', '#table-post-relationship');
            });
            $(document).on('click', '#sach', function(e) {
                e.preventDefault();
                show_post_list('sach', '#table-post-sach');
            });

            $(document).on('click', '#target', function(e) {
                e.preventDefault();
                show_post_list('target', '#table-post-target');
            });


            $(document).on('click', '#created', function(e) {
                e.preventDefault();
                var noi_dung = tinymce.get('content-creat').getContent();
                var noi_dung_2 = tinymce.get('image-title').getContent();
                var regex = /<img[^>]*src="([^"]+)"[^>]*>/;


                var data = noi_dung_2.match(regex);
                if (data) {
                    var image_path = data[0];
                } else {
                    var image_path = [];
                }


                console.log(image_path);
                console.log('ok');

                var data = {
                    'title': $('#title-creat').val(),
                    'content': noi_dung,
                    'month': $('#date_created').val(),
                    'team': $('#team_group').val(),
                    'chuyen_muc': $('#chuyen-muc').val(),
                    'image_path': image_path,
                    'remark': 'post',

                }
                console.log(data);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('post.save') }}",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        if (response.status == 400) {

                            window.alert('Tạo bài viết không thành công');

                        } else {
                            var form = document.getElementById('create-post');
                            form.reset();
                            window.alert('Tạo bài viết thành công');
                            $('#modal-created').modal('hide');
                            show_post_list('smart', '#table-post-all');
                        }

                    }
                });

            });

            $(document).on('click', '#view', function(e) {
                e.preventDefault();

                var post_id = this.value;
                console.log(post_id);
                console.log("ok-1");
                $.ajax({
                    type: "GET",
                    url: "admin-dashboard/post/" + post_id,
                    success: function(response) {
                        // console.log(response.post);
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
                $.ajax({
                    type: "GET",
                    url: "admin-dashboard/post/" + post_id,
                    success: function(response) {


                        // var post_id = $('#edit-post-id').val();
                        // alert(post_id);
                        if (response.status == 404) {
                            $('#success_message').addClass(
                                'alert alert-success');
                        } else {
                            $('#edit-post-id').val(response.post.id);
                            $('#title-edit').val(response.post.title);
                            tinymce.get('content-edit').setContent(response.post.content);
                            tinymce.get('image-title-edit').setContent(response.post
                                .image_title);
                            $('#team-group-edit').val(response.post.team);
                            $('#date-created-edit').val(response.post.month);
                            $('#chuyen-muc-edit').val(response.post.chuyen_muc);


                        }
                    }
                });
                $('.btn-close').find('input').val('');

            });

            $(document).on('click', '#updated', function(e) {
                e.preventDefault();
                var noi_dung = tinymce.get('content-edit').getContent();
                var noi_dung_2 = tinymce.get('image-title-edit').getContent();
                var regex = /<img[^>]*src="([^"]+)"[^>]*>/;
                var data = noi_dung_2.match(regex);
                if (data) {
                    var image_path = data[0];
                } else {
                    var image_path = [];
                }
                var post_id = $('#edit-post-id').val();
                // alert(post_id);

                // console.log(image_path);
                // console.log(post_id);

                var data = {
                    'title': $('#title-edit').val(),
                    'content': noi_dung,
                    'month': $('#date-created-edit').val(),
                    'team': $('#team-group-edit').val(),
                    'chuyen_muc': $('#chuyen-muc-edit').val(),
                    'image_path': image_path,
                    'remark': 'post',
                }
                console.log(data);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "admin-dashboard/post/update/" + post_id,
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        if (response.status == 400) {
                            $('#update_msgList').html("");
                            $('#update_msgList').addClass(
                                'alert alert-danger');
                            $.each(response.errors, function(key,
                                err_value) {
                                window.alert('Update bài viết không thành công');
                            });

                        } else {
                            var form = document.getElementById('edit-post');
                            form.reset();
                            $('#modal-edit').modal('hide');
                            window.alert('update bài viết thành công');
                            show_post_list('smart', '#table-post-all');
                        }

                    }
                });
            });


            function show_post_list(tab, table) {
                $.ajax({
                    type: "GET",
                    url: "admin-dashboard/post/list/" + tab,
                    dataType: "json",
                    success: function(response) {
                        var data = [];
                        var count = 0;

                        $.each(response.post, function(index, value) {
                            count++;
                            id = value.id;

                            var view = '<button type="button" value="' + id +
                                '" data-bs-toggle="modal" data-bs-target="#modal-show" class="btn btn-primary editbtn btn-sm" id="view">View</button>';

                            var edit = '<button type="button" value="' + id +
                                '" data-bs-toggle="modal" data-bs-target="#modal-edit" class="btn btn-danger editbtn btn-sm" id="edit">update</button>';
                            var deleted = '<button type="button" value="' + id +
                                '" data-bs-toggle="modal" data-bs-target="#DeleteModal" class="btn btn-danger editbtn btn-sm" id="delete">Delete</button>';

                            data.push([
                                count,
                                value.title,
                                value.month,
                                value.chuyen_muc,
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

                            columns: [{
                                    data: "0"
                                },
                                {
                                    data: "1"
                                },
                                {
                                    data: "2"
                                },
                                {
                                    data: "3"
                                },
                                {
                                    data: "4"
                                },
                                {
                                    data: "5"
                                },
                                {
                                    data: "6"
                                },


                            ]
                        });
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

                            window.alert('Xóa bài viết thành công');
                            $('#DeleteModal').modal('hide');
                        }
                        show_post_list('smart', '#table-post-all');
                    }
                });
            });

        });
    </script>
@endsection
