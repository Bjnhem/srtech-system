@extends('pro_3m.admin.admin-layout')

@section('content')
    <div class="container">

        <ul id="myTab" class="nav nav-tabs boot-tabs mb-5">
            <li class="nav-item">
                <button class="nav-link  active " id="all" data-bs-toggle="tab" data-bs-target="#all-post" type="button"
                    role="tab" aria-controls="nav-disabled" aria-selected="false">All
                    Post</button>
            </li>
            <li class="nav-item">
                <button class="nav-link " id="smart" data-bs-toggle="tab" data-bs-target="#smart-post" type="button"
                    role="tab" aria-controls="nav-disabled" aria-selected="false">SMART</button>
            </li>
            <li class="nav-item"> <button class="nav-link " id="study" data-bs-toggle="tab" data-bs-target="#study-post"
                    type="button" role="tab" aria-controls="nav-home" aria-selected="true">STUDY</button></li>
            <li class="nav-item"> <button class="nav-link" id="mind" data-bs-toggle="tab" data-bs-target="#mind-post"
                    type="button" role="tab" aria-controls="nav-profile" aria-selected="false">MIND</button></li>
            <li class="nav-item">
                <button class="nav-link" id="action" data-bs-toggle="tab" data-bs-target="#action-post" type="button"
                    role="tab" aria-controls="nav-contact" aria-selected="false">ACTION</button>

            </li>
            <li class="nav-item">
                <button class="nav-link" id="relationship" data-bs-toggle="tab" data-bs-target="#relationship-post"
                    type="button" role="tab" aria-controls="nav-disabled" aria-selected="false">RELATIONSHIP</button>
            </li>
            <li class="nav-item ">
                <button class="nav-link" id="target" data-bs-toggle="tab" data-bs-target="#target-post" type="button"
                    role="tab" aria-controls="nav-disabled" aria-selected="false">TARGET</button>
            </li>
        </ul>
        <div class="tab-content mt-4" id="nav-tabContent">
            {{-- =====  Hoạt động nổi bật ===== --}}
            <div class="tab-pane fade show active " id="all-post" role="tabpanel" aria-labelledby="all" tabindex="0">
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
            </div>
        </div>
    </div>
@endsection

@section('admin-js')
<script>
    $(document).ready(function() {
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
