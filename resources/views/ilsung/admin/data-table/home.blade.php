@extends('Checklist_EQM.admin.check-list.admin-layout')

@section('content')
    <div class="container">
        <div class="row mb-2">
            <div class="col-md-12 ">
                <div id="success_message"></div>
                <div class="card card-ke-hoach">
                    <div class="card-body">
                        <table class="table table-bordered text-center table-hover" style="width:100%"
                            id="table-result-traning">
                            <thead class="table-success">
                                <Tr>
                                    <th>STT</th>
                                    <th>Tên Model</th>
                                    <th>Tên bảng trong (SQL)</th>
                                    <th>Remark</th>
                                </Tr>
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
    {{--  <script>
        localStorage.setItem('activeItem', 'update');
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
    </script> --}}
    <script>
        $(document).ready(function() {
            localStorage.setItem('activeItem', 'update');
            var tab_model = 'all';
            data_table_list(tab_model);

            function data_table_list(model) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('table.list') }}",
                    dataType: "json",
                    data: {
                        model_tab: model,
                    },
                    success: function(users) {
                        var data = [];
                        var count = 0;
                        $.each(users.data, function(index, value) {
                            count++;
                            var view = '<button type="button" value="' + value.model +
                                '"class="btn btn-primary view-table btn-sm" id="view">View</button>';
                            data.push([
                                count,
                                value.model,
                                value.table,
                                view,
                            ]);

                        });
                        // console.log(users.data)
                        $('#table-result-traning').DataTable().destroy();
                        $('#table-result-traning').DataTable({
                            data: data,
                            "searching": true,
                            "paging": true,
                            "info": true,
                            'ordering': false,
                        });
                    }
                });
            }

            var buttom = document.querySelectorAll("#myTab button");
            buttom.forEach((item) => item.addEventListener('click', function(event) {
                tab_model = this.id;
                data_table_list(tab_model);
            }));

            $(document).on('click', '#view', function(e) {
                e.preventDefault();
                tab_model = this.value;
                console.log(tab_model);
                var url = "{{ route('table.show', ':table') }}".replace(':table', tab_model);
                console.log(url);
                window.location.href = url;

            });

        });
    </script>
@endsection
