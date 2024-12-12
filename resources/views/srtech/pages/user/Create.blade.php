@extends('ilsung.layouts.layout')
@section('content')
    <div>
        <?php
        $id = $id ?? null;
        ?>
        @if (isset($id))
            {!! Form::model($data, [
                'route' => ['users.update', $id],
                'method' => 'patch',
                'enctype' => 'multipart/form-data',
            ]) !!}
        @else
            {!! Form::open(['route' => ['users.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
        @endif
        <div class="row">
            <div class="col-xl-3 col-lg-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">{{ $id !== null ? 'Update' : 'Add' }} User</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="profile-img-edit position-relative">
                                <img src="{{ $profileImage ?? asset('images/avatars/01.png') }}" alt="User-Profile"
                                    class="profile-pic rounded avatar-100">
                                <div class="upload-icone bg-primary">
                                    <svg class="upload-button" width="14" height="14" viewBox="0 0 24 24">
                                        <path fill="#ffffff"
                                            d="M14.06,9L15,9.94L5.92,19H5V18.08L14.06,9M17.66,3C17.41,3 17.15,3.1 16.96,3.29L15.13,5.12L18.88,8.87L20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18.17,3.09 17.92,3 17.66,3M14.06,6.19L3,17.25V21H6.75L17.81,9.94L14.06,6.19Z" />
                                    </svg>
                                    {{-- <input class="file-upload" type="file" accept="image/*" name="profile_image" onchange="previewImage();"> --}}
                                </div>
                            </div>

                            <div class="img-extension mt-3">
                                <div class="d-inline-block align-items-center">
                                    <span>Only</span>
                                    <a href="javascript:void();">.jpg</a>
                                    <a href="javascript:void();">.png</a>
                                    <a href="javascript:void();">.jpeg</a>
                                    <span>allowed</span>
                                </div>
                                {{-- <input type="file" accept="image/*" id="image" name="profile_image" class="form-control " onchange="previewImage();"> --}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status:</label>
                            <div class="grid" style="--bs-gap: 1rem">
                                <div class="form-check g-col-6">
                                    {{ Form::radio('status', 'active', old('status') || true, ['class' => 'form-check-input', 'id' => 'status-active']) }}
                                    <label class="form-check-label" for="status-active">
                                        Active
                                    </label>
                                </div>
                                <div class="form-check g-col-6">
                                    {{ Form::radio('status', 'pending', old('status'), ['class' => 'form-check-input', 'id' => 'status-pending']) }}
                                    <label class="form-check-label" for="status-pending">
                                        Pending
                                    </label>
                                </div>
                                {{-- <div class="form-check g-col-6">
                                    {{ Form::radio('status', 'banned', old('status'), ['class' => 'form-check-input', 'id' => 'status-banned']) }}
                                    <label class="form-check-label" for="status-banned">
                                        Banned
                                    </label>
                                </div>
                                <div class="form-check g-col-6">
                                    {{ Form::radio('status', 'inactive', old('status'), ['class' => 'form-check-input', 'id' => 'status-inactive']) }}
                                    <label class="form-check-label" for="status-inactive">
                                        Inactive
                                    </label>
                                </div> --}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">User Role: <span class="text-danger">*</span></label>
                            {{ Form::select('user_role', $roles, old('user_role') ? old('user_role') : $data->user_type ?? 'user', ['class' => 'form-control', 'placeholder' => 'Select User Role']) }}
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">{{ $id !== null ? 'Update' : 'New' }} User Information</h4>
                        </div>
                        <div class="card-action">
                            <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary" role="button">Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="new-user-info">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="form-label" for="uname">User Name: <span
                                            class="text-danger">*</span></label>
                                    {{ Form::text('username', old('username'), ['class' => 'form-control', 'required', 'placeholder' => 'Enter Username',]) }}
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label" for="pass">Password: <span class="text-danger">*</span>
                                    </label>
                                    {{ Form::password('password', ['class' => 'form-control', 'placeholder', 'required' => 'Password']) }}
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label" for="rpass">Repeat Password:</label>
                                    {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder', 'required' => 'Repeat Password']) }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="form-label" for="email">Email: <span class="text-danger">*</span>
                                    </label>
                                    {{ Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Enter e-mail']) }}
                                </div>

                                {{-- <div class="form-group col-4">
                            <label class="form-label" for="fname">Full Name: <span class="text-danger">*</span></label>
                            {{ Form::text('first_name', old('first_name'), ['class' => 'form-control', 'placeholder' => 'First Name', 'required']) }}
                         </div> --}}

                                <div class="form-group col-4">
                                    <label class="form-label" for="cname">Công ty: </label>
                                    {{ Form::text('userProfile[company_name]', old('userProfile[company_name]'), ['class' => 'form-control', 'placeholder' => 'Company Name']) }}
                                </div>

                                <div class="form-group col-4">
                                    <label class="form-label" for="mobno">Mobile Number:</label>
                                    {{ Form::text('userProfile[phone_number]', old('userProfile[phone_number]'), ['class' => 'form-control', 'id' => 'mobno', 'placeholder' => 'Mobile Number']) }}
                                </div>

                            </div>
                            <hr>


                            <button type="submit" class="btn btn-primary">{{ $id !== null ? 'Update' : 'Add' }}
                                User</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('admin-js')
    {{-- <script type="text/javascript">
        $(function() {
            window.LaravelDataTables = window.LaravelDataTables || {};
            window.LaravelDataTables["dataTable"] = $("#dataTable").DataTable({
                "serverSide": true,
                "processing": true,
                "ajax": {
                    "url": "http:\/\/localhost\/ilsung-system\/public\/users",
                    "type": "GET",
                    "data": function(data) {
                        for (var i = 0, len = data.columns.length; i < len; i++) {
                            if (!data.columns[i].search.value) delete data.columns[i].search;
                            if (data.columns[i].searchable === true) delete data.columns[i].searchable;
                            if (data.columns[i].orderable === true) delete data.columns[i].orderable;
                            if (data.columns[i].data === data.columns[i].name) delete data.columns[i]
                                .name;
                        }
                        delete data.search.regex;
                    }
                },
                "columns": [{
                    "name": "id",
                    "data": "id",
                    "title": "id",
                    "orderable": true,
                    "searchable": true
                }, {
                    "name": "full_name",
                    "data": "full_name",
                    "title": "FULL NAME",
                    "orderable": false,
                    "searchable": true
                }, {
                    "name": "phone_number",
                    "data": "phone_number",
                    "title": "Phone Number",
                    "orderable": true,
                    "searchable": true
                }, {
                    "name": "email",
                    "data": "email",
                    "title": "Email",
                    "orderable": true,
                    "searchable": true
                }, {
                    "name": "userProfile.country",
                    "data": "userProfile.country",
                    "title": "Country",
                    "orderable": true,
                    "searchable": true
                }, {
                    "name": "status",
                    "data": "status",
                    "title": "Status",
                    "orderable": true,
                    "searchable": true
                }, {
                    "name": "userProfile.company_name",
                    "data": "userProfile.company_name",
                    "title": "Company",
                    "orderable": true,
                    "searchable": true
                }, {
                    "name": "created_at",
                    "data": "created_at",
                    "title": "Join Date",
                    "orderable": true,
                    "searchable": true
                }, {
                    "data": "action",
                    "name": "action",
                    "title": "Action",
                    "orderable": false,
                    "searchable": false,
                    "width": 60,
                    "className": "text-center hide-search"
                }],
                "dom": "<\"row align-items-center\"<\"col-md-2\" l><\"col-md-6\" B><\"col-md-4\"f>><\"table-responsive my-3\" rt><\"row align-items-center\" <\"col-md-6\" i><\"col-md-6\" p>><\"clear\">",
                "autoWidth": false
            });
        });
    </script> --}}
@endsection
