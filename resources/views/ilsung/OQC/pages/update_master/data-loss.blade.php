@extends('ilsung.OQC.layouts.OQC_layout')

@section('content')
    <div class="card table-responsive" style="border: none">
        <div class="card-header">
            <button type="button" id="Home" class="btn btn-success"
                onclick="window.location='{{ route('OQC.update.master') }}'"><span class="icon-home"></span></button>
            <button type="button" id="creat" class="btn btn-primary">Add</button>
        </div>
        <div class="card-body ">
            <div class="row">

                <div class="col-sm-6 col-xl-6 mb-3">
                    <span>Trường lỗi:</span>
                    <select name="category_search" id="category_search" class="form-select">
                        <option value="All">All</option>
                    </select>
                </div>

            </div>
            <table class="table table-bordered table-hover table-sm " id="table-result" style="width:100%">
                <thead class="table-success">
                    <tr>
                        <th>ID</th>
                        <th>Trường lỗi</th>
                        <th>Tên lỗi</th>
                        <th>Remark</th>
                        <th>Edit</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="modal" id="modal-created">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <!-- Tiêu đề bên trái -->
                    <h5 class="text-primary mx-3" id="title_modal_data">

                    </h5>
                    <div>
                        <button type="button" id="save" class="btn btn-success">Save</button>
                        <button type="button" id="update" class="btn btn-success">Update</button>
                        <button type="button" id="close-model" class="btn btn-warning close-model-checklist">Close</button>
                    </div>
                </div>
                <div class="modal-body" style="background-color: white">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center" style="display: contents">
                                <!-- Phần tải file mẫu -->
                                <div class="col-md-3 text-start">
                                    <a href="#" id="download-template" class="btn btn-primary">
                                        <i class="icon-download"></i> Tải file mẫu
                                    </a>
                                </div>

                                <!-- Phần upload file -->
                                <div class="col-md-9">
                                    <form action="{{ route('OQC.update.loss.item') }}" method="post" id="form-upload"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="input-group">
                                            <input class="form-control" type="file" name="excel_file"
                                                accept=".xlsx, .xls" id="file-upload">
                                            <button class="btn btn-success" type="submit">
                                                <i class="icon-line-upload"></i> Upload
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                        <div class="card-body">
                            <div class="col-12"> <!-- Phần Thêm kế hoạch bằng Form -->
                                <form action="{{ route('OQC.update.add.data') }}" method="post" id="form_data"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <input name="id" type="hidden" id="id" class="form-control"
                                            value="">

                                        <div class="col-sm-12 col-xl-4 mb-3">
                                            <span>Trường lỗi:</span>
                                            <input name="category" type="text" id="category" class="form-control"
                                                placeholder="Nhập trường lỗi...">
                                        </div>
                                        <div class="col-sm-12 col-xl-4 mb-3">
                                            <span>Tên lỗi:</span>
                                            <input name="name" type="text" id="name" class="form-control"
                                                placeholder="Nhập vị trí...">
                                        </div>

                                        <div class="col-sm-12 col-xl-4 mb-3">
                                            <span>Remark:</span>
                                            <input name="remark" type="text" id="remark" class="form-control"
                                                placeholder="remark...">
                                        </div>
                                    </div>
                                </form>

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
        // Chạy khi trang đã tải xong
        document.addEventListener('DOMContentLoaded', function() {
            // Lấy tên file cần tải
            var fileName = 'loss_item_form.xlsx'; // Bạn có thể thay đổi tên file ở đây nếu cần

            // Tạo URL với tham số file_name
            var url = "{{ route('OQC.download.template', ['file_name' => '__FILE_NAME__']) }}";
            url = url.replace('__FILE_NAME__', fileName); // Thay __FILE_NAME__ bằng tên file thực tế

            // Cập nhật href của thẻ a
            document.getElementById('download-template').setAttribute('href', url);
        });
    </script>

    <script>
        $(document).ready(function() {
            var table_name = 'ErrorList';
            var table = '#table-result';
            let title_add = "Thêm tên lỗi";
            let title_edit = "Sửa tên lỗi";
            const filePath = 'loss_item_form.xlsx'; // Đường dẫn file mẫu
            var tables;
            let id;


            function show_category_check() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('OQC.show.data.loss.item') }}",
                    dataType: "json",
                    success: function(response) {
                        $('#category_search').empty().append($('<option>', {
                            value: "",
                            text: "All",
                        }));

                        $.each(response.category, function(index, value) {
                            $('#category_search').append($('<option>', {
                                value: value,
                                text: value,
                            }));


                        });

                    }
                });


            }
            show_category_check();

            tables = $(table).DataTable({
                processing: true, // Cho phép xử lý dữ liệu trong lúc tải
                serverSide: true, // Bật chế độ server-side pagination
                ajax: {
                    url: "{{ route('OQC.update.show.data.loss') }}", // Đường dẫn đến route mà ta đã định nghĩa
                    type: "GET",
                    data: function(d) {
                        // Thêm các tham số tìm kiếm từ các form hoặc dropdowns
                        console.log('Sending data:', d);
                        d.category = $('#category_search')
                            .val(); // Lấy giá trị từ input hoặc select
                    },
                },

                columns: [{
                        data: null, // Không cần dữ liệu vì chúng ta sẽ tính số thứ tự
                        name: null,
                        render: function(data, type, row, meta) {
                            return meta.row +
                                1; // meta.row trả về chỉ số dòng, cộng thêm 1 để bắt đầu từ 1
                        },
                        title: 'STT' // Tên cột sẽ hiển thị là "STT"
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    }, // Cột tên sản phẩm
                    {
                        data: 'remark',
                        name: 'remark'
                    }, // Cột code purchase

                    {
                        data: 'id',
                        render: function(data) {
                            // Thêm nút sửa và xóa
                            var editButton =
                                '<button type="button" value="' + data +
                                '" class="btn btn-success btn-sm editbtn" style="margin-right:5px" id="edit"><span class="icon-pencil2"></span></button>';
                            var deleteButton =
                                '<button type="button" value="' + data +
                                '" class="btn btn-danger btn-sm deletebtn" id="delete"><span class="icon-trash1"></span></button>';
                            return editButton + deleteButton;
                        }
                    }
                ],
                pageLength: 10, // Mỗi trang có 20 bản ghi
                ordering: false, // Tắt chức năng sắp xếp (có thể bật lại nếu cần)
                searching: true, // Cho phép tìm kiếm
                lengthChange: true, // Cho phép thay đổi số bản ghi mỗi trang
                info: false, // Tắt thông tin số lượng bản ghi (total, filtered)
                autoWidth: false,
                select: {
                    style: 'single',
                }, // Tự động điều chỉnh chiều rộng của cột

            });

            function save_update_data() {
                const data = new FormData(document.getElementById('form_data'));
                data.append('table', table_name);
                data.append('id', id);
                console.log(id);
                if (data.get('name') == "" || data.get('category') == "") {
                    return alert(
                        "Vui lòng điền đầy đủ thông tin");
                } else {
                    // Gửi yêu cầu AJAX với cả hai dữ liệu
                    $.ajax({
                        type: "POST",
                        url: "{{ route('OQC.update.add.data') }}",
                        dataType: 'json',
                        data: data,
                        processData: false, // Không xử lý dữ liệu (FormData tự xử lý)
                        contentType: false,
                        success: function(response) {
                            if (response.status === 400) {
                                toastr.danger('Có lỗi - vui lòng thực hiện lại');
                            }
                            toastr.success('Thành công');
                            // show_data_table(table_name);
                            $('#modal-created').modal('hide');
                            tables.ajax.reload(); // Tải lại dữ liệu của DataTable khi filter thay đổi
                            document.getElementById('form_data').reset();
                        },
                        error: function() {
                            toastr.success('Có lỗi - vui lòng thực hiện lại');
                        }
                    });
                }
            }

            $('#category_search').on('change', function() {
                tables.ajax.reload(); // Tải lại dữ liệu của DataTable khi filter thay đổi
            });

            $(document).on('click', '#creat', function(e) {
                e.preventDefault();
                $('#title_modal_data').text(title_add);
                $('#save').show(); // Ẩn nút Save
                $('#update').hide();
                $('#modal-created').modal('show');
                id = "";
            });

            $(document).on('click', '#save', function(e) {
                e.preventDefault();
                save_update_data();
                show_category_check();
            });

            $(document).on('click', '#edit', function(e) {
                e.preventDefault();
                // Hiển thị modal với tiêu đề chỉnh sửa
                $('#title_modal_data').text('Chỉnh sửa sản phẩm');
                $('#save').hide(); // Ẩn nút Save
                $('#update').show(); // Hiển thị nút Update
                // Lấy ID từ nút Edit (giá trị ID hoặc dòng nào đó)

                id = $(this).val();
                let rowData = tables.rows().data().toArray().find(row => row.id == id);
                if (rowData) {
                    // Gán dữ liệu vào các trường form
                    $('#name').val(rowData.name); // ID ẩn
                    $('#category').val(rowData.category); // ID Sản phẩm
                    $('#remark').val(rowData.remark); // Tên sản phẩm
                    $('#id').val(id); // Tên sản phẩm
                    console.log(rowData.category);

                }

                // Hiển thị modal
                $('#modal-created').modal('show');
            });


            $(document).on('click', '#update', function(e) {
                e.preventDefault();
                save_update_data();
            });
            $(document).on('click', '#delete', function() {
                const id = $(this).val(); // Lấy ID của checklist từ nút

                const row = $(this).closest('tr'); // Lưu tham chiếu đến dòng chứa nút
                if (confirm('Bạn có chắc chắn muốn xóa không?')) {
                    $.ajax({
                        type: "post",
                        url: "{{ route('OQC.update.delete.data') }}",
                        data: {
                            table: table_name,
                            id_row: id
                        },
                        success: function(response) {
                            if (response.status === 200) {
                                toastr.success('Xóa thành công');
                                tables.row(row).remove().draw();
                                show_category_check();
                            } else {
                                toastr.error('Có lỗi xảy ra. Không thể xóa.');
                            }
                        },
                        error: function() {
                            toastr.error('Có lỗi xảy ra. Không thể xóa.');

                        }
                    });
                }
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                }
            });
            $(document).on('click', '#close-model', function(e) {
                e.preventDefault();
                $('#modal-created').modal('hide');
                document.getElementById('form_data').reset();

            });

            // show_data_table(table_name);

        });
    </script>
@endsection
