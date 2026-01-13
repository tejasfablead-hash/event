<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Purple Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../../vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../../css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="../../images/favicon.png" />
    <style>
        .password-toggle {
            position: absolute;
            top: 70%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            font-size: 20px;
        }

        .password-toggle:hover {
            color: #4B49AC;
            /* Purple Admin primary color */
        }
    </style>

</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row w-100">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-5">

                            <h4>Hello! let's get started</h4>
                            <h6 class="font-weight-light">Sign in to continue.</h6>

                            <form id="loginform" method="post" class="pt-3">
                                @csrf
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Username</label>
                                    <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                        placeholder="enter email" aria-describedby="emailHelp">
                                    <span class="text-danger error" id="email_error"></span>
                                </div>
                                <div class="form-group position-relative">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" id="password" name="password" class="form-control"
                                        placeholder="Enter password">
                                    <span class="password-toggle" onclick="togglePassword()">
                                        <i id="toggleIcon" class="mdi mdi-eye"></i>
                                    </span>
                                </div>
                                <span class="text-danger error" id="password_error"></span>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div class="form-check">
                                         <label class="form-check-label text-muted">
                                            <input type="checkbox" class="form-check-input">
                                           Remeber this Device 
                                        </label>
                                        <!-- <label class="form-check-label text-dark" for="flexCheckChecked"> -->
                                        
                                        <!-- </label> -->
                                    </div>
                                    <a class="text-primary fw-bold" href="#">Forgot Password ?</a>
                                </div>
                                <input type="submit" name="submit"
                                    class="btn btn-primary w-100 py-8 fs-4 mb-1 rounded-2" value="Sign In">
                            </form>
                            <hr class="my-2">
                            <div class="text-center">
                                <p>or sign in with:</p>
                                <a href="{{ route('google.login') }}" class="btn btn-link btn-floating mx-1">
                                    <i class="mdi mdi-google"></i>
                                </a>
                                <a href="{{ route('facebook.login') }}" class="btn btn-link btn-floating mx-1">
                                    <i class="mdi mdi-facebook"></i>
                                </a>


                            </div>

                            <hr class="my-1">

                            <div class="text-center mt-1  font-weight-light">
                                You have no account? <a href="{{ route('RegisterPage') }}"
                                    class="mt-1 text-primary">Register
                                </a>
                            </div>

                            <div id="loginError" class="alert alert-danger mt-2 text-center d-none" role="alert">
                            </div>
                            <div id="loginSuccess" class="alert alert-success mt-2 text-center d-none" role="alert">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('vendors/js/vendor.bundle.addons.js') }}"></script>
    <script src="{{ asset('js/off-canvas.js') }}"></script>
    <script src="{{ asset('js/misc.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('ajax.js') }}"></script>
    <script src="http://structureless-brice-abruptly.ngrok-free.dev/ajax.js"></script>
    <script>
        $(document).ready(function() {

            $('#loginform').submit(function(e) {
                e.preventDefault();

                let formData = new FormData(this);
                let url = "{{ route('LoginMatchPage') }}";

                $('.error').text('');
                $('#loginError').addClass('d-none').html('');
                $('#loginSuccess').addClass('d-none').html('');

                reusableAjaxCall(url, 'POST', formData, function(response) {

                    if (response.status === true) {

                        $('#loginSuccess')
                            .removeClass('d-none')
                            .html(response.message)
                            .fadeIn();

                        setTimeout(function() {
                            window.location.href = "{{ route('DashboardPage') }}";
                        }, 2000);

                    } else {

                        $('#loginError')
                            .removeClass('d-none')
                            .html(response.message)
                            .fadeIn();

                        setTimeout(function() {
                            $('#loginError').fadeOut(function() {
                                $(this).addClass('d-none').html('').show();
                            });
                        }, 3000);
                    }
                });
            });
        });
    </script>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>

</body>

</html>
