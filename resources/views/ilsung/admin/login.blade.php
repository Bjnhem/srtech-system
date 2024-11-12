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
    <h1 class="sign-up__title">Welcome to admin dashboard</h1>
    <p class="sign-up__subtitle">Vui lòng đăng nhập để tiếp tục sử dụng</p>
    <form class="sign-up-form form" action="" method="POST">
      @csrf
      <label class="form-label-wrapper">
        <p class="form-label">Tên đăng nhập</p>
        <input class="form-input" type="email" name="email" placeholder="Enter your email" required>
      </label>
      <label class="form-label-wrapper">
        <p class="form-label">Password</p>
        <input class="form-input" type="password" name="password" placeholder="Enter your password" required>
      </label>
      <a class="link-info forget-link" href="##">Forgot your password?</a>
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