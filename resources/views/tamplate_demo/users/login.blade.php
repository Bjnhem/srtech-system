@extends('users.user-layout')

@section('content')
    <section class="login-content">
        <div class="row m-0 align-items-center bg-white vh-100">
            <div class="col-md-6">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card card-transparent shadow-none d-flex justify-content-center mb-0 auth-card">
                            <div class="card-body">

                                <h2 class="mb-2 text-center">ĐĂNG NHẬP</h2>
                                <p class="text-center">WELLCOME TO SR-TECH SYSTEM</p>
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

                                <form method="POST" action="{{ route('auth.submit.signin') }}" data-toggle="validator">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="username" class="form-label">User name</label>
                                                <input id="username" type="text" name="username"
                                                    value="{{ env('IS_DEMO') ? 'Username' : old('username') }}"
                                                    class="form-control" placeholder="User name" required autofocus>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="password" class="form-label">Password</label>
                                                <input class="form-control" type="password" placeholder="********"
                                                    name="password" value="" required            >
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-check mb-3">
                                                <input type="checkbox" class="form-check-input" id="customCheck1">
                                                <label class="form-check-label" for="customCheck1">Remember Me</label>
                                            </div>
                                        </div>
                                        {{-- <div class="col-lg-6">
                                 <a href="{{route('auth.recoverpw')}}"  class="float-end">Forgot Password?</a>
                              </div> --}}
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary">Đăng nhập</button>
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
                                        Nếu bạn chưa có tài khoản? <a href="{{ route('auth.signup') }}"
                                            class="text-underline">Click để đăng ký.</a>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sign-bg">
                    <svg width="280" height="230" viewBox="0 0 431 398" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g opacity="0.05">
                            <rect x="-157.085" y="193.773" width="543" height="77.5714" rx="38.7857"
                                transform="rotate(-45 -157.085 193.773)" fill="#3B8AFF" />
                            <rect x="7.46875" y="358.327" width="543" height="77.5714" rx="38.7857"
                                transform="rotate(-45 7.46875 358.327)" fill="#3B8AFF" />
                            <rect x="61.9355" y="138.545" width="310.286" height="77.5714" rx="38.7857"
                                transform="rotate(45 61.9355 138.545)" fill="#3B8AFF" />
                            <rect x="62.3154" y="-190.173" width="543" height="77.5714" rx="38.7857"
                                transform="rotate(45 62.3154 -190.173)" fill="#3B8AFF" />
                        </g>
                    </svg>
                </div>
            </div>
            <div class="col-md-6 d-md-block d-none bg-primary p-0 mt-n1 vh-100 overflow-hidden">
                <img src="{{ asset('images/auth/01.png') }}" class="img-fluid gradient-main animated-scaleX"
                    alt="images">
            </div>
        </div>
    </section>
@endsection
