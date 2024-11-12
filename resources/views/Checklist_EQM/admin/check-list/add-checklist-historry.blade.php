@extends('pro_3m.admin.check-list.admin-layout')
@section('content')
    <div class="container-fluid" style="margin-top: 1px;">
        <!-- Content Row -->
        <div class="card mb-4">
            <div class="card-header py-3">
                <h5 class="text-primary mx-3"><b><i class="icon-line-check-square" style="padding-right: 5px"></i>CHECK LIST
                        EQM</b>
                </h5>
            </div>
            <div class="card-body">
              
                <div class="row">
              
                    <div class=" col-sm-2 col-md-2  bottommargin-sm">
                        <label for="">Date Search</label>

                        <div class="input-daterange component-datepicker multidate input-group">
                            <input type="text" value="" class="form-control text-start" id="date_form"
                                placeholder="MM/DD/YYYY">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <span>
                            <br>
                        </span>
                         <button id="add-plan-checklist" class="form-control btn-success"><i
                            class="icon-line-check"></i>Created plan checklist
                    </button>
                    </div>


                </div>
                <br>
                <table class="table table-bordered text-center mt-4 table-hover" id="table-check-list"
                    style="width: 100%; text-align: center; vertical-align:middle">
                    <thead class="table-success">
                        <tr>
                            <th style="width:3%">STT</th>
                            <th style="width:7%">Check List</th>
                            <th style="width:7%">Công đoạn</th>
                            <th style="width:7%">Phân loại</th>
                            <th style="width:auto">Nội dung</th>
                            <th style="width:7%">Tình trạng</th>
                            <th style="width:10%">Vấn đề</th>
                            <th style="width:7%">Tiến độ</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>
@endsection

@section('admin-js')
    <script>
        $(document).ready(function() {
            localStorage.setItem('activeItem', 'historry');
            var table = 'result';
            var table_2 = 'result_detail'
            var colum_table = [];
            var tables;
            var tab = @json($view);
      

            function Convertdate(date) {
                var data = date.split('/');
                var dateconvert = data[2] + '-' + data[0] + '-' + data[1];
                return dateconvert;
            }

            function Convert_year(date) {
                var data = date.split('/');
                var dateconvert = data[2] + '_' + data[0];
                return dateconvert;
            }


            $(document).on('click', '#add-plan-checklist', function(e) {
                e.preventDefault();
                var date = Convertdate($('#date_form').val());
                console.log(date);
                if ($('#date_form').val() == 0) {
                    alert('Bạn điền thiếu thông tin');
                } else {
                    var data = {
                        date: date,
                    }
                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.add.plan.checklist') }}",
                        dataType: 'json',
                        data: data,
                        success: function(response) {
                            if (response.status == 200) {
                                alert("Số check list đã tạo: " + response.count)
                            } else {
                                alert("Tạo Checklist lỗi")
                            }
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

        });
    </script>
@endsection
