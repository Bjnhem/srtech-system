@extends('ilsung.layouts.layout')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <a href="{{ route('update.data.model') }}">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="bg-info text-white rounded p-3">
                                <img class=" icon" src="{{ asset('checklist-ilsung/icon/smartphone.png') }}" alt="Camera"
                                    width="30" height="30">
                            </div>
                            <div class="text-end">
                                Danh sách model
                                <h2 class="counter" style="visibility: visible;">75</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6">
            <a href="{{ route('update.data.line') }}">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="bg-warning text-white rounded p-3">
                                <img class=" icon" src="{{ asset('checklist-ilsung/icon/production.png') }}" alt="Camera"
                                    width="30" height="30">
                            </div>
                            <div class="text-end">
                                Products line
                                <h2 class="counter counter_line" style="visibility: visible;">60</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

        </div>
        <div class="col-lg-3 col-md-6">
            <a href="{{ route('update.data.machine') }}">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="bg-success text-white rounded p-3">
                                <img class=" icon" src="{{ asset('checklist-ilsung/icon/machine.png') }}" alt="Camera"
                                    width="30" height="30">
                            </div>
                            <div class="text-end">
                                Machine master
                                <h2 class="counter counter_machine" style="visibility: visible;">80</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6">
            <a href="{{ route('update.data.machine.list') }}">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="bg-danger text-white rounded p-3">
                                <img class=" icon" src="{{ asset('checklist-ilsung/icon/evaluating.png') }}" alt="Camera"
                                    width="30" height="30">
                            </div>
                            <div class="text-end">
                                List machine
                                <h2 class="counter counter-list_machine" style="visibility: visible;">45</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6">
            <a href="{{ route('update.data.checklist.master') }}">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="bg-warning text-white rounded p-3">
                                <img class=" icon" src="{{ asset('checklist-ilsung/icon/production.png') }}" alt="Camera"
                                    width="30" height="30">
                            </div>
                            <div class="text-end">
                                Checklist master
                                <h2 class="counter counter_line" style="visibility: visible;">60</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

        </div>
        <div class="col-lg-3 col-md-6">
            <a href="{{ route('update.data.checklist.item') }}">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="bg-success text-white rounded p-3">
                                <img class=" icon" src="{{ asset('checklist-ilsung/icon/machine.png') }}" alt="Camera"
                                    width="30" height="30">
                            </div>
                            <div class="text-end">
                               Checklist item
                                <h2 class="counter counter_machine" style="visibility: visible;">80</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>





        {{-- <div class="col-lg-3 col-md-6">
            <div class="card bg-soft-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="bg-soft-info rounded p-3">

                            <img class=" icon" src="{{ asset('checklist-ilsung/icon/smartphone.png') }}" alt="Camera"
                                width="30" height="30">
                        </div>
                        <div class="text-end">
                            <h2 class="counter counter_model" style="visibility: visible;">5600</h2>
                            Model
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-soft-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="bg-soft-warning rounded p-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="text-end">
                            <h2 class="counter" style="visibility: visible;">5600</h2>
                            Nurses
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-soft-danger">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="bg-soft-danger rounded p-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z">
                                </path>
                            </svg>
                        </div>
                        <div class="text-end">
                            <h2 class="counter" style="visibility: visible;">3500</h2>
                            Patients
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-soft-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="bg-soft-primary rounded p-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="text-end">
                            <h2 class="counter" style="visibility: visible;">4500</h2>
                            Pharmacists
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}


    </div>
@endsection

@section('admin-js')
    <script>
        $(document).ready(function() {
            localStorage.setItem('activeItem', 'master');
            var table = 'model_master';
            var colum_table = [];
            var colums = [];
            var tables;

            /*  $('#model').val() = table; */
            data_table_view(table);
            localStorage.setItem('activeItem', 'Master');
            var activeItem = localStorage.getItem('activeItem');
            let list = document.querySelectorAll(".sidebar-body-menu a");
            list.forEach((item) => item.addEventListener('click', activeLink));
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


            var buttom = document.querySelectorAll("#myTab button");
            buttom.forEach((item) => item.addEventListener('click', function(event) {
                table = $(this).val();
                colums = [];
                data_table_view(table);

            }));

            function editTable() {
                $('#table-result').Tabledit({
                    url: "admin-dashboard/master/edit-table/" + table,
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
                            data_table_view(table);
                        }
                    }
                });
            }

            function data_table_view(id_table) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('master.show.model') }}",
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

                                window[value] = [];
                                colums.push(value);
                            }
                        });
                        console.log(colums);
                        /*  var group = [];
                          var check_list = [];  */

                        $.each(users.data, function(index, value) {
                            $.each(colums, function(index, row) {
                                window[row].push(value[row]);
                                window[row] = [...new Set(window[row])];
                            });


                        });

                        $.each(colums, function(index, row) {
                            $("#" + row).autocomplete({
                                source: window[row]
                            });
                        });






                        if (tables) {
                            $('#table-result').DataTable().clear().destroy();
                            $('#table-result thead tr').remove();
                        }
                        tables = $('#table-result').DataTable({
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


            $(document).on('click', '#add_check_list', function(e) {
                e.preventDefault();
                var model = table;
                var group_master = $('#group').val();
                var check_list_master = $('#check_list_master').val();
                if (group == '' || check_list_master == '') {
                    alert('Bạn nhập thiếu thông tin');
                } else {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('master.add.check.list.name') }}",
                        dataType: "json",
                        data: {
                            table: model,
                            Group: group_master,
                            check_list: check_list_master
                        },
                        success: function(users) {
                            if (users.status == 200) {
                                data_table_view(table);
                                alert('Thêm thành công');
                            }

                            if (users.status == 400) {
                                alert('Check list đã tồn tại');

                            }
                        }
                    });
                }
            });
            $(document).on('click', '#new-row', function(e) {
                e.preventDefault();
                var model = table;
                $.ajax({
                    type: "GET",
                    url: "{{ route('master.new_row') }}",
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

                        var table = $('#table-result').DataTable();
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
                    url: "{{ route('master.delete_row') }}",
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
                        var tables = $('#table-result').DataTable();
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

            $('#table-result').on('draw.dt', function() {
                editTable();
            });

        });
    </script>
@endsection
