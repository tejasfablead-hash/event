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
                    Event Booking Details
                </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Events</a></li>
                        <li class="breadcrumb-item active">View Booking Details</li>
                    </ol>
                </nav>
            </div>

            <!-- MAIN CARD -->
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">

                                <!-- LEFT : EVENT IMAGE -->
                                <div class="col-md-5">

                                    @php
                                        $images = json_decode($data->getevent->image, true);
                                    @endphp
                                    @if (is_array($images) && count($images) > 0)
                                        <div class="mb-3 d-flex justify-content-center align-items-center"
                                            style="height:300px;background:#f8f9fa;border-radius:8px;">
                                            <img src="{{ asset('/storage/' . $images[0]) }}" class="img-fluid rounded"
                                                id="mainEventImage" style="max-height:100%;object-fit:contain;">
                                        </div>

                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach ($images as $image)
                                                <img src="{{ asset('/storage/' . $image) }}" class="rounded border"
                                                    onclick="changeEventImage(this.src)"
                                                    style="width:70px;height:70px;object-fit:cover;">
                                            @endforeach

                                        </div>
                                    @endif
                                </div>

                                <!-- RIGHT : DETAILS -->
                                <div class="col-md-7 ">

                                    <!-- EVENT INFO -->
                                    <h3 class="mb-1 text-capitalize">Title : {{ $data->getevent->title }}</h3>
                                    <p class="text-muted text-capitalize"> Desc :
                                        {{ $data->getevent->desc }}
                                    </p>

                                    <h4 class="text-primary text-capitalize font-weight-bold">
                                        Price : ₹ {{ $data->getevent->price }}
                                    </h4>

                                    <hr>

                                    <!-- EVENT META -->
                                    <div class="row mb-3 text-capitalize">
                                        <div class="col-sm-6">
                                            <p><strong>Category :</strong> {{ $data->getevent->category }}</p>
                                            <p><strong>City :</strong> {{ $data->getevent->city }}</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <p><strong>Capacity :</strong> {{ $data->getevent->capacity }} People</p>
                                            <p><strong>Total :</strong> {{ $data->grandtotal }} </p>

                                        </div>
                                    </div>
                                    <hr>
                                    <!-- BOOKING DETAILS -->
                                    <h5 class="mb-2">📅 Booking Details</h5>

                                    <div class="row mb-3 text-capitalize">
                                        <div class="col-sm-6">
                                            <p><strong>Start Date :</strong>
                                                {{ optional($data->start_date)->format('d M Y') }} </p>
                                            <p><strong>End Date :</strong> {{ optional($data->end_date)->format('d M Y') }}
                                            </p>
                                        </div>
                                        <div class="col-sm-6">
                                            <p><strong>Quantity :</strong> {{ $data->qty }} Tickets</p>
                                            <strong>Booking Status :</strong>
                                            <p class="badge badge-gradient-success"> {{ $data->status }}</p>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- CUSTOMER DETAILS -->
                                    <h5 class="mb-2">👤 Customer Details</h5>

                                    <div class="d-flex align-items-center">

                                        <img src="{{ asset('/storage/user/' . $data->getcustomer->image) }}"
                                            class="rounded-circle mr-3" style="width:60px;height:60px;object-fit:cover;">
                                        <div>
                                            <p class="mb-0 font-weight-bold text-capitalize">{{ $data->getcustomer->name }}
                                            </p>
                                            <p class="mt-1 text-muted">{{ $data->getcustomer->email }}</p>
                                        </div>
                                    </div>

                                    <!-- ACTIONS -->
                                    <div class="mt-4">
                                        {{-- <a href="javascript:void(0)" class="text-decoration-none open-modal "
                                            data-bs-toggle="modal" data-bs-target="#topUpModal"
                                            data-id="{{ $data->id }}" data-status="{{ $data->status }}"> <button
                                                class="btn btn-gradient-success">
                                                Update Booking
                                            </button></a> --}}
                                        <a href=" {{ route('EventsMultiBookEditPage', $data->id) }}"
                                            class="text-decoration-none open-modal "> <button
                                                class="btn btn-gradient-success">
                                                Update Booking
                                            </button></a>
                                        <a href="{{ route('EventsBookViewPage') }}"><button class="btn btn-dark">
                                                Back
                                            </button></a>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id="topUpModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Update Booking Status</h5>
                    <button type="button" class="btn-close border-0" data-bs-dismiss="modal">X</button>
                </div>

                <div class="modal-body">
                    <form id="modelform">
                        @csrf
                        <input type="hidden" name="id" id="booking_id">
                        <div class="mb-3">
                            <label>Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                            <span class="text-danger error" id="status_error"></span>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Update Status
                        </button>
                    </form>

                    <div id="message" class="alert alert-success text-center mt-2 d-none"></div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.7.1.js" crossorigin="anonymous"></script>

    <script src="{{ asset('ajax.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.open-modal', function() {
                let id = $(this).data('id');
                let status = $(this).data('status');
                $('#booking_id').val(id);
                $('#status').val(status);
            });

            $('#modelform').on('submit', function(e) {
                e.preventDefault();
                var data = $('#modelform')[0];
                var formData = new FormData(data);
                var url = "/event-book-update";
                $('.error').text('');

                reusableAjaxCall(url, 'POST', formData, function(response) {
                    console.log(response);
                    if (response.status == true) {
                        $('#message').removeClass('d-none').html(response.message).fadeIn();
                        setTimeout(function() {
                            $('#message').addClass('d-none').html('').fadeOut();
                            window.location.href = "{{ route('EventsBookViewPage') }}";
                        }, 4000);
                    }
                    $('#modelform')[0].reset();
                    $('.error').empty();
                }, function(error) {
                    console.log(error);
                });
            })
        });

        function changeEventImage(src) {
            document.getElementById('mainEventImage').src = src;
        }
    </script>
@endsection
