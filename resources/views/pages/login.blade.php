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
                                <div class="mb-2">
                                    <label for="exampleInputPassword1" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control"
                                        placeholder="enter password" id="exampleInputPassword1">
                                    <span class="text-danger error" id="password_error"></span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input primary" type="checkbox" value=""
                                            id="flexCheckChecked" checked>
                                        <!-- <label class="form-check-label text-dark" for="flexCheckChecked"> -->
                                        Remeber this Device
                                        <!-- </label> -->
                                    </div>
                                    <a class="text-primary fw-bold" href="#">Forgot Password ?</a>
                                </div>
                                <input type="submit" name="submit"
                                    class="btn btn-primary w-100 py-8 fs-4 mb-1 rounded-2" value="Sign In">

                                <hr class="my-2">
                                <div class="text-center">
                                    <p>or sign up with:</p>
                                    <button type="button" data-mdb-button-init data-mdb-ripple-init
                                        class="btn btn-link btn-floating mx-1">
                                        <a href="{{ route('google.login') }}"><i class="mdi mdi-google "></i></a>
                                    </button>

                                    <button type="button" data-mdb-button-init data-mdb-ripple-init
                                        class="btn btn-link btn-floating mx-1">
                                     <i class="mdi mdi-facebook"></i>
                                    </button>


                                </div>

                            </form>

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
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../../vendors/js/vendor.bundle.base.js"></script>
    <script src="../../vendors/js/vendor.bundle.addons.js"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="../../js/off-canvas.js"></script>
    <script src="../../js/misc.js"></script>
    <!-- endinject -->

    <script src="{{ asset('ajax.js') }}"></script>
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
</body>

</html>
