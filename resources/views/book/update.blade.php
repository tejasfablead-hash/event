@extends('index')
@section('container')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header ">
                <h6 class="page-title pr-5">
                    <div id="message" class="alert alert-success text-center d-none" role="alert"></div>
                </h6>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Booking</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Update Booking</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Update Booking</h4>
                        <br>
                        <form class="form-sample" id="updatebook" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="id" class="form-control" value="{{ $single->id }}"
                                    placeholder="enter title">

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Event</label>
                                        <div class="col-sm-9">
                                            <select class="form-control event border-redius" name="event">
                                                <option value="">Select Event....</option>
                                                @foreach ($event as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ isset($single) && $item->id == $single->event ? 'selected' : '' }}>
                                                        {{ $item->title }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error eventerror" id="event_error"></span>
                                            <input type="hidden" name="customer" class="form-control"
                                                value="{{ $single->customer }}" placeholder="enter title">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Status</label>
                                        <div class="col-sm-9">
                                            <select class="form-control status border-redius" name="status">

                                                <option value="">Select Status....</option>
                                                <option value="pending"
                                                    {{ $single->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="confirmed"
                                                    {{ $single->status == 'confirmed' ? 'selected' : '' }}>Confirmed
                                                </option>
                                                <option value="cancelled"
                                                    {{ $single->status == 'cancelled' ? 'selected' : '' }}>Cancelled
                                                </option>
                                            </select>
                                            <span class="text-danger error statuserror" id="status_error"></span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Qty</label>
                                        <div class="col-sm-9">
                                            <input type="number" name="qty" value="{{ $single->qty }}"
                                                class="form-control qty" placeholder="enter qty">
                                            <span class="text-danger error qtyerror" id="qty_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                 
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-3">
                                            <input type="submit" class="btn btn-gradient-primary mr-2" value="Update">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.7.1.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="{{ asset('ajax.js') }}"></script>
        <script>
            $(document).ready(function() {
               

                $('#updatebook').submit(function(e) {
                    e.preventDefault();
                    var data = $('#updatebook')[0];
                    var formData = new FormData(data);

                    $('.error').text('');
                    var url = "{{ route('EventsBooksUpdatePage') }}";
                    reusableAjaxCall(url, 'POST', formData, function(response) {
                        console.log(response.message);
                        if (response.status == true) {
                            $('#message').removeClass('d-none').html(response.message).fadeIn();
                            setTimeout(function() {
                                $('#message').addClass('d-none').html('').fadeOut();
                                window.location.href = "{{ route('EventsBookViewPage') }}";
                            }, 4000);
                        }
                        $('#updatebook')[0].reset();
                        $(".error").empty();
                    }, function(error) {
                        
                            }
                    );

                });
            });
        </script>
    @endsection
