@extends('index')

@section('container')
    <div class="main-panel">
        <div class="content-wrapper">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h3 class="page-title">
                    <span class="page-title-icon bg-gradient-primary text-white mr-2">
                        <i class="mdi mdi-calendar-text"></i>
                    </span>
                    Profile Details
                </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Profile</a></li>
                        <li class="breadcrumb-item active">View Profile</li>
                    </ol>
                </nav>
            </div>

            <!-- MAIN CARD -->
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">

                                <!-- LEFT PROFILE CARD -->
                                <div class="col-md-4">
                                    <div class="card shadow-sm rounded-4 text-center">
                                        <div class="card-body">
                                            @if (!empty(auth()->user()->image))
                                                <img src="{{ asset('storage/user/' . auth()->user()->image) }}"
                                                class="rounded-circle mb-3" width="120" height="120" alt="User">

                                            @else
                                                 <img src="{{ asset('images/faces/face1.jpg') }}"
                                                    class="img-lg rounded-circle" alt="Default User">
                                            @endif
                                            
                                            <h5 class="fw-bold mb-1 text-capitalize">{{ auth()->user()->name }}</h5>
                                            <p class="text-muted mb-2">{{ auth()->user()->email }}</p>

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
                                        <div class="card-body">

                                            <h5 class="fw-bold mb-4">Profile Information</h5>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="text-muted ">Full Name</label>
                                                    <p class="fw-semibold text-capitalize">{{ auth()->user()->name }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="text-muted">Email</label>
                                                    <p class="fw-semibold">{{ auth()->user()->email }}</p>
                                                </div>
                                            </div>

                                            {{-- <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="text-muted">Phone</label>
                                                    <p class="fw-semibold">{{ auth()->user()->phone ?? 'N/A' }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="text-muted">City</label>
                                                    <p class="fw-semibold">{{ auth()->user()->city ?? 'N/A' }}</p>
                                                </div>
                                            </div> --}}
                                            <div class="text-end">
                                                <a href="{{ route('ProfileEditPage') }}" class="btn btn-primary px-4">
                                                    Edit Profile
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
