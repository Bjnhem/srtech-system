<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('admin//img/svg/logo.svg') }}" type="image/x-icon">
    <!-- Custom styles -->
    <link rel="stylesheet" href="{{ asset('admin/css/style.min.css') }}">
</head>

<body>
    <div class="layer"></div>
    <main class="page-center">
        <article class="sign-up">
            <h1 class="sign-up__title">ĐĂNG KÝ TÀI KHOẢN</h1>
            {{--  <p class="sign-up__subtitle">Start creating the best possible user experience for you customers</p> --}}
            <form class="sign-up-form form" action="" method="POST">
                @csrf
                <label class="form-label-wrapper">
                    <p class="form-label">Name</p>
                    <input class="form-input" type="text" name="username" placeholder="Enter your name" required>
                </label>
                <label class="form-label-wrapper">
                    <p class="form-label">Email</p>
                    <input class="form-input" type="email" name="email" placeholder="Enter your email" required>
                </label>
                <label class="form-label-wrapper">
                    <p class="form-label">Password</p>
                    <input class="form-input" type="password" name="password" placeholder="Enter your password"
                        required>
                </label>
               {{--  <div class="form-group col-md-4">
                    <label for="inputState">State</label>
                    <select id="inputState" class="form-select">
                        <option selected="">Choose...</option>
                        <option>...</option>
                    </select>
                </div> --}}
               {{--  <label class="form-group"> Team </label>
                    <select name="team" class="form-select">
                        <option value="SEVT" selected>SEVT</option>
                        <option>CNC T</option>
                        <option>Glass T</option>
                        <option>Production T</option>
                        <option>R&D T</option>
                        <option>QC T</option>
                        <option>Other T</option>
                    </select> --}}
              
                <label class="form-checkbox-wrapper">
                    <input class="form-checkbox" type="checkbox" required>
                    <span class="form-checkbox-label">Remember me next time</span>
                </label>
                <button class="form-btn primary-default-btn transparent-btn">Sign in</button>
            </form>
        </article>
    </main>
    <!-- Chart library -->
    <script src="{{ asset('admin/plugins/chart.min.js') }}"></script>
    <!-- Icons library -->
    <script src="{{ asset('admin/plugins/feather.min.js') }}"></script>
    <!-- Custom scripts -->
    <script src="{{ asset('admin/js/script.js') }}"></script>
</body>

</html>
