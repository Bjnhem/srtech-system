@extends('Checklist_EQM.admin.check-list.admin-layout')
@section('content')
    <div class="container">
        <div class="card card-ke-hoach table-responsive">
            <div class="card-header">
                <div class="row mx-2 mt-2">
                    <div class="col-6">
                        <form action="{{ route('table.update.data') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group">
                                <input type="hidden" name="id" id="table_name" value="{{ $table }}">
                                <input class="form-control" type="file" name="csv_file" accept=".csv" id="file-upload">
                                <button class="btn btn-success" type="submit"><i class="icon-line-upload"></i>
                                    <span class="hidden-xs">Upload</span></button>

                            </div>
                        </form>
                    </div>

                    <div class="col-6" style="text-align: end">
                        <button type="button" id="new-row" class="btn btn-primary">Thêm dòng mới</button>
                        <button type="button" id="delete-row" class="btn btn-danger">Xóa nhiều dòng</button>
                    </div>
                </div>

            </div>
            <div class="card-body ">
                <table class="table table-bordered table-hover table-sm " id="table-result-traning" style="width:100%">
                    <thead class="table-success"></thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('admin-js')
    <script>
        var activeItem = localStorage.getItem('activeItem');
        let list = document.querySelectorAll(".sidebar-body-menu a");

        if (activeItem) {
            var selectedItem = document.getElementById(activeItem);
            if (selectedItem) {
                selectedItem.classList.add('active');
            }
        }

        function activeLink() {
            var itemId = this.id;
            list.forEach((item) => {
                item.classList.remove("active");
            });
            this.classList.add("active");
            localStorage.setItem('activeItem', itemId);
        }
        list.forEach((item) => item.addEventListener('click', activeLink));
    </script>
    <script>
        $(document).ready(function() {
            var table = @json($table);
            var colum_table = [];
            var tables;

            data_table_view(table, 'Bảng' + table);

            /*    editTable(); */

            function editTable() {
                $('#table-result-traning').Tabledit({
                    url: "admin-dashboard/update-data/edit-table/" + table,
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
                            $('#table-result-traning').DataTable().ajax.reload();
                        }
                    }
                });
            }

            function data_table_view(id_table, title_1) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('table.show.model') }}",
                    dataType: "json",
                    data: {
                        table: id_table,
                    },
                    success: function(users) {
                        var colum = users.colums;
                        var count = 0;
                        // console.log(colum);
                        $.each(colum, function(index, value) {
                            if (value != 'id') {
                                count++;
                                colum_table.push([count, value]);
                            }
                        });
                        tables = $('#table-result-traning').DataTable({
                            data: users.data,
                            "info": false,
                            'ordering': false,
                            'autowidth': true,
                            "dom": 'Bfrtip',

                            select: {
                                style: 'multi',
                            },

                            columns: colum.map(function(columnMane) {
                                return {
                                    title: columnMane,
                                    data: columnMane,
                                };
                            })


                        });

                    }
                });
            }

            $(document).on('click', '#new-row', function(e) {
                e.preventDefault();
                var model = table;
                $.ajax({
                    type: "GET",
                    url: "{{ route('table.new_row') }}",
                    dataType: "json",
                    data: {
                        table: model,
                    },
                    success: function(users, ) {
                        var colum = users.colums;
                        var count = 0;
                        colum_table = [];
                        $.each(colum, function(index, value) {
                            if (value != 'id') {
                                count++;
                                colum_table.push([count, value]);
                            }
                        });

                        var table = $('#table-result-traning').DataTable();
                        table.clear().rows.add(users.data).draw();
                    }
                });
            });

            $(document).on('click', '#delete-row', function(e) {
                e.preventDefault();
                var model = table;
                var rowSelect = tables.rows('.selected').data();
                var idsrow = rowSelect.toArray().map(row => row.id);
                console.log(idsrow);
                $.ajax({
                    type: "GET",
                    url: "{{ route('table.delete_row') }}",
                    dataType: "json",
                    data: {
                        table: model,
                        rowId: idsrow,
                    },
                    success: function(users, ) {
                        var colum = users.colums;
                        var count = 0;
                        colum_table = [];
                        $.each(colum, function(index, value) {
                            if (value != 'id') {
                                count++;
                                colum_table.push([count, value]);
                            }
                        });
                        var tables = $('#table-result-traning').DataTable();
                        tables.clear().rows.add(users.data).draw();
                    }
                });
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                }
            });

            $('#table-result-traning').on('draw.dt', function() {
                editTable();
            });
        });
    </script>
@endsection
