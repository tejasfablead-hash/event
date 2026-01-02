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
                    Event Details
                </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Events</a></li>
                        <li class="breadcrumb-item active">View Event</li>
                    </ol>
                </nav>
            </div>

            <!-- MAIN CARD -->
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">

                                <!-- EVENT IMAGE SECTION -->
                                <div class="col-md-6">
                                    @php
                                        $images = json_decode($data->image, true);
                                    @endphp

                                    @if (is_array($images) && count($images))
                                        <div class="mb-3 d-flex justify-content-center align-items-center"
                                            style="height:320px;background:#f8f9fa;border-radius:8px;">
                                            <img id="mainEventImage" src="{{ asset('storage/' . $images[0]) }}"
                                                class="img-fluid rounded"
                                                style="max-height:100%;max-width:100%;object-fit:contain;">
                                        </div>

                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach ($images as $img)
                                                <img src="{{ asset('storage/' . $img) }}"
                                                    onclick="changeEventImage(this.src)" class="rounded border"
                                                    style="width:70px;height:70px;object-fit:cover;cursor:pointer;">
                                            @endforeach
                                        </div>
                                    @else
                                        <img src="{{ asset('images/faces/face1.jpg') }}" class="img-fluid rounded shadow">
                                    @endif
                                </div>


                                <!-- EVENT DETAILS SECTION -->
                                <div class="col-md-6">

                                    <h3 class="text-capitalize">Title : {{ $data->title }}</h3>

                                    <h4 class="text-primary font-weight-bold mt-2">
                                        Price : ₹{{ $data->price }}
                                    </h4>

                                    <p class="text-muted mt-3 text-capitalize">
                                        Descripton : {{ $data->desc }}
                                    </p>

                                    <hr>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p><strong>Category:</strong> {{ $data->getcategory->category_name }}</p>
                                            <p><strong>City:</strong> {{ $data->getcity->city_name }}</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <p><strong>Date:</strong> {{ $data->created_at->format('d M Y') }}</p>
                                            <p>
                                                <strong>Status:</strong>
                                                <label class="badge badge-gradient-success">Active</label>
                                            </p>
                                        </div>
                                    </div>
                                    @if (Auth::user()->role == 1)
                                        <a href="{{ route('EditEventPage', $data->id) }}"
                                            class="btn btn-gradient-info mt-3">
                                            Edit Event
                                        </a>
                                        <button class="btn btn-light mt-3">
                                            Back
                                        </button>
                                    @else
                                        <a href="" class="text-decoration-none open-model btn btn-gradient-info mt-3"
                                            data-bs-toggle="modal" data-bs-target="#topUpModal"
                                            data-id="{{ $data->id }}">
                                            Book Event
                                        </a>
                                        <button class="btn btn-dark mt-3">
                                            Back
                                        </button>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 stretch-card">
                <div class="card">
                    <div class="card-body">

                        @if ($result->count() > 0)
                            <h4 class="card-title">Event Request</h4>
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>
                                            Customer
                                        </th>

                                        <th>
                                            Start_Date
                                        </th>
                                        <th>
                                            End_Date
                                        </th>
                                        <th>
                                            Qty
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="text-capitalize">

                                    @foreach ($result as $item)
                                        <tr>
                                            <td class="py-1">
                                                {{ $item->getcustomer->name }}
                                            </td>
                                            <td>
                                                {{ optional($item->start_date)->format('d M Y') }}
                                            </td>
                                            <td>
                                                {{ optional($item->end_date)->format('d M Y') }}
                                            </td>
                                            <td>
                                                {{ $item->qty }}
                                            </td>
                                            <td>
                                                {{ $item->status }}
                                            </td>
                                            <td>&nbsp;&nbsp;&nbsp;
                                                @if (Auth::user()->role == 1)
                                                    <a href="{{ route('EventsBookDetailPage', $item->id) }}"
                                                        class=" text-decoration-none"><i class="mdi mdi-eye "></i>
                                                    </a>
                                                @else
                                                  
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        @else
                        <h4 class="card-title">No Event Request</h4>    
                        @endif

                    </div>
                </div>
            </div>
        </div>

    </div>



    <div class="modal fade" id="topUpModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-mg">
            <div class="modal-content border-0 rounded-4 shadow">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="eventModalLabel">
                        Book Event
                    </h5>
                    <button type="button" class="btn-close" onclick="reset()" data-bs-dismiss="modal"
                        aria-label="Close">X</button>
                </div>

                <div class="modal-body px-8">
                    <form id="modelform">
                        @csrf
                        <div class="form-floating ">
                            <input type="hidden" name="event" id="event_id">
                            <input type="hidden" name="customer" value="{{ Auth::id() }}">
                        </div>
                        <!-- Start & End Date -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <label for="startDate">Start Date</label>
                                    <input type="date" class="form-control" id="startDate" name="startdate">
                                    <span class="text-danger error" id="startdate_error"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <label for="endDate">End Date</label>
                                    <input type="date" class="form-control" id="endDate" name="enddate">
                                    <span class="text-danger error" id="enddate_error"></span>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-floating mb-3">
                                    <label for="qty">Qty</label>
                                    <input type="text" class="form-control" id="qty" name="qty">
                                    <span class="text-danger error" id="qty_error"></span>
                                </div>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary btn-lg w-100 mt-3" name="submit"
                            value="Book Event" />

                    </form>

                    <div id="message" class="alert alert-success text-center mt-2 d-none" role="alert"></div>

                </div>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js" crossorigin="anonymous"></script>

    <script src="{{ asset('ajax.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.open-model').on('click', function() {
                var id = $(this).data('id');
                $('#event_id').val(id);
            });

            $('#modelform').on('submit', function(e) {
                e.preventDefault();
                var data = $('#modelform')[0];
                var formData = new FormData(data);
                var url = "/event-book";
                $('.error').text('');

                reusableAjaxCall(url, 'POST', formData, function(response) {
                    console.log(response);
                    if (response.status == true) {
                        $('#message').removeClass('d-none').html(response.message).fadeIn();
                        setTimeout(function() {
                            $('#message').addClass('d-none').html('').fadeOut();
                            window.location.href = "{{ route('EventViewPage') }}";
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
