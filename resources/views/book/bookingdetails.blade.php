@extends('index')

@section('container')
    <div class="main-panel">
        <div class="content-wrapper">

            <!-- PAGE HEADER -->
            <div class="page-header d-flex justify-content-between align-items-center">
                <h3 class="page-title mb-0">
                    <span class="page-title-icon bg-gradient-primary text-white mr-2">
                        <i class="mdi mdi-calendar-text"></i>
                    </span>
                    Event Booking Details
                </h3>
                <a href="{{ route('EventsBookViewPage') }}" class="btn btn-dark btn-sm">Back to Bookings</a>
            </div>

            <!-- MAIN CARD -->
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">

                            <div class="row g-4">

                                <!-- LEFT : EVENT IMAGES -->
                               
                                <div class="col-lg-5 col-md-12">
                                    @php
                                        $images = json_decode($data->getevent->image, true);
                                    @endphp
                                    @if (is_array($images) && count($images) > 0)
                                        <div class="mb-3 text-center"
                                            style="height: 350px; background: #f8f9fa; border-radius: 8px; display:flex; align-items:center; justify-content:center;">
                                            <img src="{{ asset('/storage/' . $images[0]) }}" id="mainEventImage"
                                                class="img-fluid rounded" style="max-height:100%; object-fit:contain;">
                                        </div>

                                        <div class="d-flex flex-wrap gap-2 justify-content-center">
                                            @foreach ($images as $image)
                                                <img src="{{ asset('/storage/' . $image) }}" class="rounded border"
                                                    onclick="changeEventImage(this.src)"
                                                    style="width:70px; height:70px; object-fit:cover; cursor:pointer;">
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center text-muted py-5 border rounded">No Images Available</div>
                                    @endif
                                </div>

                                <!-- RIGHT : DETAILS -->
                                <div class="col-lg-7 col-md-12">
                                    <!-- EVENT INFO -->
                                    <h3 class="mb-2 text-capitalize">Title : {{ $data->getevent->title ?? 'Event Title' }}</h3>
                                    <p class="text-muted text-capitalize">
                                        Description : {{ $data->getevent->desc ?? 'No Description Available' }}</p>
                                    <h4 class="text-primary text-capitalize font-weight-bold">Price: ₹{{ $data->getevent->price ?? '0' }}
                                    </h4>
                                    <hr>

                                    <!-- EVENT META -->
                                    <div class="row mb-3 text-capitalize">
                                        <div class="col-sm-6 ">
                                            <p><strong>Category:</strong> {{ $data->getevent->getcategory->category_name ?? 'N/A' }}</p>
                                            <p><strong>City:</strong> {{ $data->getevent->getcity->city_name ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <p><strong>Capacity:</strong> {{ $data->getevent->capacity ?? 'N/A' }} People
                                            </p>

                                        </div>
                                    </div>
                                    <hr>

                                    <!-- BOOKING DETAILS -->
                                    <h5 class="mb-2">📅 Booking Details</h5>
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <p><strong>Start Date:</strong> {{ $data->start_date[0] ?? '-' }}</p>
                                            <p><strong>End Date:</strong> {{ $data->end_date[0] ?? '-' }}</p>

                                        </div>
                                        <div class="col-sm-6">
                                            <p><strong>Quantity:</strong>
                                                @foreach ($data->qty as $key => $val)
                                                @endforeach{{ $val }} Tickets
                                            </p>
                                            <p><strong>Status:</strong>
                                                <span
                                                    class="badge 
                                                @if ($data->status == 'confirmed') badge-success
                                                @elseif($data->status == 'pending') badge-warning
                                                @else badge-danger @endif">
                                                    {{ ucfirst($data->status) }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    <hr>

                                    <!-- CUSTOMER DETAILS -->
                                    <h5 class="mb-2">👤 Customer Details</h5>
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="{{ asset('storage/user/' . $data->getcustomer->image) }}"
                                            class="rounded-circle me-3" style="width:60px;height:60px;object-fit:cover;">
                                        <div>
                                            <p class="mb-0 fw-bold text-capitalize">{{ $data->getcustomer->name }}</p>
                                            <p class="text-muted mb-0">{{ $data->getcustomer->email }}</p>
                                        </div>
                                    </div>

                                    <!-- ACTIONS -->
                                    <a href="{{ route('EditEventPage', $data->id) }}" class="btn btn-gradient-info mt-3">
                                        Edit Event
                                    </a>
                                    <a href="{{ route('EventsBookViewPage') }}"> <button class="btn btn-dark mt-3">
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

    <script>
        function changeEventImage(src) {
            document.getElementById('mainEventImage').src = src;
        }
    </script>
@endsection
