@extends('index')
@section('container')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h6 class="page-title">
                    
                   <div id="message" class="alert alert-success text-center d-none" role="alert"></div>
                </h6>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Profile</a></li>
                        <li class="breadcrumb-item active">Update Profile</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Update Profile</h4>
                        <br>
                        <div class="row">

                            <!-- LEFT PROFILE CARD -->
                            <div class="col-md-4">
                                <div class="card shadow-sm rounded-4 text-center">
                                    <div class="card-body">

                                        <img src="{{ asset('storage/user/' . $data->image) }}" class="rounded-circle mb-3"
                                            width="120" height="120" alt="User">

                                        <h5 class="fw-bold mb-1 text-capitalize">{{ $data->name }}</h5>
                                        <p class="text-muted mb-2">{{ $data->email }}</p>

                                        <hr>

                                        {{-- <div class="d-flex justify-content-between text-muted">
                                                <div>
                                                    <h6 class="mb-0">Events</h6>
                                                    <small>12</small>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">Bookings</h6>
                                                    <small>8</small>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">Reviews</h6>
                                                    <small>4</small>
                                                </div>
                                            </div> --}}

                                    </div>
                                </div>
                            </div>

                            <!-- RIGHT DETAILS -->
                            <div class="col-md-8">
                                <div class="card shadow-sm rounded-4">
                                    <form id="profileform" enctype="multipart/form-data">
                                        <h5 class="fw-bold mb-4">Profile Information</h5>
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <input type="hidden" name="id" class="form-control"
                                                    value="{{ $data->id }}" placeholder="enter id">
                                                <div class="col-md-6">
                                                    <label class="text-muted ">Full Name</label>
                                                    <input type="text" name="name" class="form-control"
                                                        value="{{ $data->name }}" placeholder="enter name">
                                                    <span class="text-danger error" id="name_error"></span>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="text-muted">Email</label>
                                                    <input type="email" name="email" class="form-control"
                                                        value="{{ $data->email }}" placeholder="enter email">
                                                    <span class="text-danger error" id="email_error"></span>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="text-muted ">Image</label>
                                                    <input type="file" name="image" class="form-control"
                                                        value="">

                                                    <span class="text-danger error" id="image_error"></span>
                                                </div>
                                                <div class="col-md-6">
                                                </div>
                                            </div>

                                            <div class="text-end">
                                                <input type="submit" class="btn btn-primary px-4" value="Update Profile" />
                                            </div>

                                        </div>
                                    </form>
                                    
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.7.1.js" crossorigin="anonymous"></script>
        <script src="{{ asset('ajax.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#profileform').submit(function(e) {
                    e.preventDefault();
                    var data = $('#profileform')[0];
                    var formData = new FormData(data);
                    $('.error').text('');
                    var url = "{{ route('ProfileUpdatePage') }}";
                    reusableAjaxCall(url, 'POST', formData, function(response) {
                        console.log(response.message);
                        if (response.status == true) {
                            $('#message').removeClass('d-none').html(response.message).fadeIn();
                            setTimeout(function() {
                                $('#message').addClass('d-none').html('').fadeOut();
                                window.location.href = "{{ route('ProfilePage') }}";
                            }, 4000);
                        }
                        $('#profileform')[0].reset();
                        $(".error").empty();
                    }, function(error) {
                        console.log(error);
                    });

                });
            });
        </script>
    @endsection
