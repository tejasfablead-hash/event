<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Purple Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('vendors/iconfonts/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row w-100">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-5">

                            <h4>Hello! let's get started</h4>
                            <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
                            <form class="pt-3" id="registerform" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="exampleInputPassword1" class="form-label">UserName</label>
                                    <input type="text" name="name" class="form-control form-control-lg"
                                        id="exampleInputUsername1" placeholder="Username">
                                    <span class="text-danger error" id="name_error"></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                        placeholder="enter email" aria-describedby="emailHelp">
                                    <span class="text-danger error" id="email_error"></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control"
                                        placeholder="enter password" id="exampleInputPassword1">
                                    <span class="text-danger error" id="password_error"></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                        placeholder="enter password">
                                    <span class="text-danger error" id="password_confirmation_error"></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1" class="form-label">Image</label>
                                    <input type="file" name="image" class="form-control form-control-lg">
                                    <span class="text-danger error" id="image_error"></span>
                                </div>
                                <div class="mb-4">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <input type="checkbox" class="form-check-input">
                                            I agree to all Terms & Conditions
                                        </label>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <input type="submit" name="submit" value="SIGN UP"
                                        class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" />
                                </div>
                                <div class="text-center mt-4 font-weight-light">
                                    Already have an account? <a href="{{ route('LoginPage') }}"
                                        class="text-primary">Login</a>
                                </div>
                                <div id="regError" class="alert alert-danger  mt-2 text-center d-none" role="alert"></div>
                                <div id="regSuccess" class="alert alert-success mt-2 text-center d-none" role="alert">

                            </form>
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
    <script>
        $(document).ready(function() {

            $('#registerform').submit(function(e) {
                e.preventDefault();

                let formData = new FormData(this);
                let url = "{{ route('RegisterAddPage') }}";

                $('.error').text('');
                $('#regError').addClass('d-none').html('');
                $('#regSuccess').addClass('d-none').html('');

                reusableAjaxCall(url, 'POST', formData, function(response) {
                    if (response.status === true) {
                        $('#regSuccess')
                            .removeClass('d-none')
                            .html(response.message)
                            .fadeIn();  
                        setTimeout(function() {
                            window.location.href = "{{route('LoginPage')}}";
                        }, 2000);

                    } else {
                        $('#regError')
                            .removeClass('d-none')
                            .html(response.message)
                            .fadeIn();

                        setTimeout(function() {
                            $('#regError').fadeOut(function() {
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
