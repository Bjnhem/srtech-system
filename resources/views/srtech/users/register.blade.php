@extends('srtech.users.user-layout')

@section('content')
    <section class="login-content">
        <div class="row m-0 align-items-center bg-white vh-100">
            <div class="col-md-6 d-md-block d-none bg-primary p-0 mt-n1 vh-100 overflow-hidden">
                <img src="{{ asset('images/auth/05.png') }}" class="img-fluid gradient-main animated-scaleX" alt="images">
            </div>
            <div class="col-md-6">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card card-transparent auth-card shadow-none d-flex justify-content-center mb-0">
                            <div class="card-body">
                                <h2 class="mb-5 text-center">ĐĂNG KÝ TÀI KHOẢN</h2>
                                {{-- <p class="text-center">WELLCOME TO SR-TECH SYSTEM</p> --}}
                                @if (session('status'))
                                    <div class="font-medium text-sm text-green-600 mb-4">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <!-- Validation Errors -->
                                @if ($errors->any())
                                    <div class="alert alert-danger" role="alert">
                                        {{ $errors->first() }}
                                    </div>
                                @endif
                                <form method="POST" action="{{ route('auth.submit.signup') }}" data-toggle="validator">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="username" class="form-label">Tên đăng nhập</label>
                                                <input id="username" type="text" name="username" value=""
                                                    class="form-control" placeholder="" required autofocus>
                                                <small id="username-feedback" class="text-danger"></small>
                                                <!-- Hiển thị thông báo -->
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="part" class="form-label">Bộ phận</label>
                                                <input id="part" type="text" name="part" value=""
                                                    class="form-control" placeholder="" required autofocus>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="password" class="form-label">Password</label>
                                                <input class="form-control" type="password" placeholder=" " id="password"
                                                    name="password" required autocomplete="new-password">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="confirm-password" class="form-label">Confirm Password</label>
                                                <input id="password_confirmation" class="form-control" type="password"
                                                    placeholder=" " name="password_confirmation" required>
                                                <small id="password-feedback" class="text-danger"></small>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary"> Đăng ký</button>
                                    </div>
                                    <p class="text-center my-3">or sign in with other accounts?</p>
                                    <div class="d-flex justify-content-center">
                                        <ul class="list-group list-group-horizontal list-group-flush">
                                            <li class="list-group-item border-0 pb-0">
                                                <a href="#"><img src="{{ asset('images/brands/fb.svg') }}"
                                                        alt="fb"></a>
                                            </li>
                                            <li class="list-group-item border-0 pb-0">
                                                <a href="#"><img src="{{ asset('images/brands/gm.svg') }}"
                                                        alt="gm"></a>
                                            </li>
                                            <li class="list-group-item border-0 pb-0">
                                                <a href="#"><img src="{{ asset('images/brands/im.svg') }}"
                                                        alt="im"></a>
                                            </li>
                                            <li class="list-group-item border-0 pb-0">
                                                <a href="#"><img src="{{ asset('images/brands/li.svg') }}"
                                                        alt="li"></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <p class="mt-3 text-center">
                                        Nếu đã có tài khoản? <a href="{{ route('auth.signin') }}"
                                            class="text-underline">Click để đăng nhập</a>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('admin-js')
    <script>
        $(document).ready(function() {
            $('#username').on('blur', function() {
                var username = $(this).val();
                var feedback = $('#username-feedback');

                if (username.length > 0) {
                    $.ajax({
                        url: "{{ route('auth.check.username') }}",
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            username: username
                        },
                        success: function(response) {
                            if (response.exists) {
                                feedback.text(
                                    'Tài khoản đã tồn tại.');
                                feedback.removeClass('text-success').addClass('text-danger');
                            } else {
                                feedback.text('Tên đăng nhập có thể sử dụng.');
                                feedback.removeClass('text-danger').addClass('text-success');
                            }
                        },
                        error: function() {
                            feedback.text('Đã xảy ra lỗi khi kiểm tra. Vui lòng thử lại sau.');
                            feedback.removeClass('text-success').addClass('text-danger');
                        }
                    });
                } else {
                    feedback.text('');
                }
            });

            $('#password_confirmation').on('blur', function() {
                var password_feedback = $(this).val();
                var password = $('#password').val();
                var feedback = $('#password-feedback');

                if (password.length > 0 && password_feedback.length > 0) {

                    if (password_feedback != password) {
                        feedback.text('Confirm password không đúng. Vui lòng kiểm tra lại.');
                        feedback.removeClass('text-success').addClass('text-danger');
                    } else {
                        feedback.text('Confirm password OK.');
                        feedback.removeClass('text-danger').addClass('text-success');
                    }

                } else {
                    feedback.text('');
                }
            });

        });
    </script>
@endsection
