@extends('ilsung.layouts.layout')

@section('content')
    <div class="tab-content mt-4" id="nav-tabContent">
        {{-- =====  Hoạt động nổi bật ===== --}}

        <div class="tab-pane fade show active " id="check-list" role="tabpanel" aria-labelledby="check-list-1" tabindex="0">
            <div class="card table-responsive" style="border: none">
                <div class="card-header">
                    <button type="button" id="Home" class="btn btn-success"
                        onclick="window.location='{{ route('update.master') }}'"><span class="icon-home"></span></button>
                    <button type="button" id="creat" class="btn btn-primary">Add</button>

                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-sm-6 col-xl-3 mb-3">
                            <span>Machine:</span>
                            <select name="Machine" id="Machine_search" class="form-select">
                            </select>

                        </div>

                    </div>
                    <div class="table_view table-responsive">
                        <table class="table table-bordered table-hover table-sm " id="table-result" style="width:100%">
                            <thead class="table-success">
                                <tr>
                                    <th>STT</th>
                                    <th>Machine</th>
                                    <th>Item checklist</th>
                                    <th>Chu kỳ</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>
            </div>
        </div>


    </div>



    <div class="modal" id="modal-created">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
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
                    <form action="" method="post" id="form_data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 col-xl-4 mb-3">
                                <span>Machine:</span>
                                <input name="Machine" type="text" id="Machine" class="form-control"
                                    placeholder="Nhập machine...">
                            </div>
                            <div class="col-sm-12 col-xl-4 mb-3">
                                <span>Item checklist:</span>
                                <input name="item_checklist" type="text" id="item_checklist" class="form-control"
                                    placeholder="Nhập item check...">
                            </div>
                            <div class="col-sm-12 col-xl-4 mb-3">
                                <span>Chu kỳ:</span>
                                <input name="Chu_ky" type="text" id="Chu_ky" class="form-control">
                            </div>

                        </div>
                       
                    </form>

                    <br>

                </div>
            </div>
        </div>
    </div>

    {{-- modal Scan --}}
    <div class="modal" id="modal-scan">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="text-primary mx-3">Quét QR Code</b>
                    </h5>

                </div>
                <div class="modal-footer mx-5">
                    <button type="button" class="btn btn-warning close close-model-scan"
                        id="close-model-scan">Close</button>
                </div>
                <div class="modal-body mx-5" style="background-color: white; ">
                    <div id="qr-reader" style="width:100%"></div>
                    <button id="closeScanBtn" style="display: none;">Đóng Quét</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('admin-js')
    <script src="{{ asset('checklist-ilsung/js/QR.min.js') }}"></script>
    <script src="{{ asset('checklist-ilsung/html5.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table_name = 'Checklist_master';
            var table = '#table-result';
            let title_add = "Add new Machine";
            let title_edit = "Edit machine";
            var tables;
            let id;
         
            function show_data_table(tab) {
                // var Item_search = $('#Item_search option:selected').text();
                var Machine_search = $('#Machine_search option:selected').text();

                $.ajax({
                    type: "GET",
                    url: "{{ route('update.data.checklist.item') }}",
                    dataType: "json",
                    data: {
                        table: tab,
                        // item: Item_search,
                        Machine: Machine_search,

                    },
                    success: function(response) {
                        var data = [];
                        var count = 0;
                        console.log(response.data);
                        $.each(response.data, function(index, value) {

                            count++;
                            id = value.id;
                            var qrCodeContainer = '<div id="qr-' + id +
                                '" class="qr-container"></div>';
                            var qrCodeData = value.Code_machine; // Dữ liệu để tạo QR code

                            var view = '<button type="button" value="' + id +
                                '" data-bs-toggle="modal" data-bs-target="#modal-show" class="btn btn-primary editbtn btn-sm" id="view"><span class="icon-eye2"></span></button>';

                            var edit = '<button type="button" value="' + id +
                                '"class="btn btn-success editbtn btn-sm" style="margin-right:5px" id="edit"><span class="icon-pencil2"></span></button>';
                            var deleted = '<button type="button" value="' + id +
                                '" data-bs-toggle="modal" data-bs-target="#DeleteModal" class="btn btn-danger editbtn btn-sm" id="delete"><span class="icon-trash1"></span></button>';

                            data.push([
                                count,
                                value.Machine,
                                value.item_checklist,
                                value.Chu_kỳ,
                                edit + deleted,
                            ]);

                        });
                        if (tables) {
                            tables.clear();
                            tables.rows.add(data).draw();
                        } else {
                            tables = $(table).DataTable({
                                data: data,
                                "searching": false,
                                "lengthChange": false,
                                "autoWidth": false,
                                "paging": true,
                                "ordering": false,
                                "info": true,
                                select: {
                                    style: 'single',
                                },
                                
                            });
                        }




                    }
                });
            }

            function save_update_data() {
                const data = new FormData(document.getElementById('form_data'));
                data.append('table', table_name);
                data.append('id', id);
                data.set('Machine', $('#Machine option:selected').text());
                data.set('Locations', $('#Locations option:selected').text());
                console.log(id);
                if (data.get('Machine') == "" || data.get('Code_machine') == "" || data.get('Locations') == "") {
                    return alert(
                        "Vui lòng điền đầy đủ thông tin");
                } else {
                    // Gửi yêu cầu AJAX với cả hai dữ liệu
                    $.ajax({
                        type: "POST",
                        url: "{{ route('update.add.data') }}",
                        dataType: 'json',
                        data: data,
                        processData: false, // Không xử lý dữ liệu (FormData tự xử lý)
                        contentType: false,
                        success: function(response) {
                            if (response.status === 400) {
                                toastr.danger('Có lỗi - vui lòng thực hiện lại');
                            }
                            toastr.success('Thành công');
                            show_data_table(table_name);
                            $('#modal-created').modal('hide');
                            document.getElementById('form_data').reset();
                        },
                        error: function() {
                            toastr.success('Có lỗi - vui lòng thực hiện lại');
                        }
                    });
                }
            }

            function show_master() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('update.data.machine.master') }}",
                    dataType: "json",
                    success: function(response) {
                        $('#Machine').empty();
                        $('#Machine_search').empty();
                        $('#ID_machine').empty();
                        $('#Locations').empty();
                        $('#Line_search').empty();

                        $('#Machine').append($('<option>', {
                            value: "",
                            text: "---",
                        }));
                        $('#Locations').append($('<option>', {
                            value: "",
                            text: "---",
                        }));

                        $('#Machine_search').append($('<option>', {
                            value: "",
                            text: "All",
                        }));
                        $('#Line_search').append($('<option>', {
                            value: "",
                            text: "All",
                        }));


                        $.each(response.machine, function(index, value) {
                            $('#Machine').append($('<option>', {
                                value: value.id,
                                text: value.Machine,
                            }));

                            $('#Machine_search').append($('<option>', {
                                value: value.id,
                                text: value.Machine,
                            }));
                        });
                        $.each(response.line, function(index, value) {
                            $('#Locations').append($('<option>', {
                                value: value.id,
                                text: value.line_name,
                            }));
                            $('#Line_search').append($('<option>', {
                                value: value.id,
                                text: value.line_name,
                            }));
                        });

                    }
                });


            }

            function checkMachineID(machineID) {
                console.log(machineID);
                $.ajax({
                    type: "POST",
                    url: '{{ route('check.machine') }}',
                    contentType: 'application/json', // Đảm bảo là gửi dữ liệu dưới dạng JSON
                    data: JSON.stringify({
                        machine_id: machineID,
                    }),
                    success: function(users) {
                        if (users.isValid) {
                            $('#Code_machine_search').val(users.machine_id);
                            toastr.success("Mã QR hợp lệ. ID máy đã được điền.");
                            html5QrcodeScanner.clear();
                            $('#modal-scan').modal('hide');

                        } else {
                            // Nếu mã QR không hợp lệ
                            const userChoice = confirm(
                                "Mã QR không hợp lệ. Bạn có muốn quét lại hoặc thoát?");
                            if (userChoice) {} else {
                                html5QrcodeScanner.clear();
                                $('#modal-scan').modal('hide');
                            }
                        }
                    },
                    error: function() {
                        alert("Lỗi kết nối khi kiểm tra mã máy.");
                    }


                });
            }

            function reader_QR() {
                var lastResult, countResults = 0;
                html5QrcodeScanner = new Html5QrcodeScanner(
                    "qr-reader", {
                        fps: 10,
                        qrbox: 250,
                        experimentalFeatures: {
                            useBarCodeDetectorIfSupported: true
                        },
                        rememberLastUsedCamera: true,
                        showTorchButtonIfSupported: true
                    });

                html5QrcodeScanner.render(onScanSuccess);

                function onScanSuccess(decodedText, decodedResult) {
                    if (decodedText !== lastResult) {
                        ++countResults;
                        lastResult = decodedText;
                        checkMachineID(lastResult);

                    }
                }

            }


            show_master();
            show_data_table(table_name);


            Scan.addEventListener('click', () => {
                $('#modal-scan').modal('show');
                reader_QR();
            });


            $('#Line_search').on('change', function(e) {
                e.preventDefault();
                show_data_table(table_name);

            });

            // $('#Code_machine').on('change', function(e) {
            //     e.preventDefault();
            //     show_data_table(table_name);

            // });

            $('#Machine_search').on('change', function(e) {
                e.preventDefault();
                show_data_table(table_name);

            });

            $('#Code_machine_search').on('change', function(e) {
                e.preventDefault();
                show_data_table(table_name);

            });


            $('#Status_search').on('change', function(e) {
                e.preventDefault();
                show_data_table(table_name);
            });

            document.getElementById('Machine').addEventListener('change', function() {
                // Lấy giá trị của option đã được chọn
                var selectedValue = this.value;
                // Cập nhật giá trị của input hidden
                document.getElementById('ID_machine').value = selectedValue;
            });

            $(document).on('click', '#creat', function(e) {
                e.preventDefault();
                $('#title_modal_data').text(title_add);
                const button1 = document.getElementById('save');
                button1.style.display = 'unset'; // Ẩn button
                const button2 = document.getElementById('update');
                button2.style.display = 'none'; // Ẩn button
                $('#modal-created').modal('show');
                id = "";
            });

            $(document).on('click', '#save', function(e) {
                e.preventDefault();
                save_update_data();

            });

            $(document).on('click', '#edit', function(e) {
                e.preventDefault();
                $('#title_modal_data').text(title_edit);
                const button1 = document.getElementById('save');
                button1.style.display = 'none'; // Ẩn button
                const button2 = document.getElementById('update');
                button2.style.display = 'unset'; // Ẩn button
                id = $(this).val();

                rowSelected = tables.rows('.selected').indexes();
                if (rowSelected.length > 0) {
                    var rowData = tables.row(rowSelected[0]).data();
                    $('#Machine').val(rowData[1]);
                    $('#Status').val(rowData[5]);
                    $('#Code_machine').val(rowData[2]);
                    // $('#Locations option').text(rowData[4]);
                    $('#ID_machine').val(rowData[1]);
                    $('#Locations option').each(function() {
                        if ($(this).text() === rowData[4]) {
                            $(this).prop('selected', true); // Chọn option có text khớp
                        }
                    });

                }
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
                        url: "{{ route('update.delete.data') }}",
                        data: {
                            table: table_name,
                            id_row: id
                        },
                        success: function(response) {
                            if (response.status === 200) {
                                toastr.success('Xóa thành công');

                                tables.row(row).remove().draw();

                            } else {
                                alert('Có lỗi xảy ra. Không thể xóa.');
                            }
                        },
                        error: function() {
                            alert('Có lỗi xảy ra. Không thể xóa.');
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

            $(document).on('click', '.close-model-scan', function(e) {
                e.preventDefault();
                $('#modal-scan').modal('hide');
                html5QrcodeScanner.clear();
            });
        });
    </script>
@endsection
