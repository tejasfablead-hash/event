@extends('index')

@section('container')
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="page-header">
                <h3 class="page-title">
                    <span class="page-title-icon bg-gradient-primary text-white mr-2">
                        <i class="mdi mdi-home"></i>
                    </span>
                    Dashboard
                </h3>
                <nav aria-label="breadcrumb">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">
                            Overview
                            <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- DASHBOARD CARDS -->
            <div class="row">
                <div class="col-md-6 col-lg-3 stretch-card grid-margin">
                    <div class="card bg-gradient-danger card-img-holder text-white">
                        <div class="card-body">
                            <img src="images/dashboard/circle.svg" class="card-img-absolute" alt="">
                            <h4>Total Events</h4>
                            <h2>{{ $event }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 stretch-card grid-margin">
                    <div class="card bg-gradient-info card-img-holder text-white">
                        <div class="card-body">
                            <img src="images/dashboard/circle.svg" class="card-img-absolute" alt="">
                            <h4>Total Bookings</h4>
                            <h2>{{ $book }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 stretch-card grid-margin">
                    <div class="card bg-gradient-success card-img-holder text-white">
                        <div class="card-body">
                            <img src="images/dashboard/circle.svg" class="card-img-absolute" alt="">
                            <h4>Total Customers</h4>
                            <h2>{{ $customer }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 stretch-card grid-margin">
                    <div class="card bg-gradient-dark card-img-holder text-white">
                        <div class="card-body">
                            <img src="images/dashboard/circle.svg" class="card-img-absolute" alt="">
                            <h4>Pending Bookings</h4>
                            <h2>{{ $pending }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CALENDAR -->
            <div class="row">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="card-body text-capitalize">
                            {{-- <h4 class="card-title mb-3">Event Calendar</h4> --}}
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
            {{--             
            <div class="row">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="card-body text-capitalize">
                            <div class="bg-white d-flex flex-wrap justify-content-between align-items-center">
                                <!-- Title -->
                                <h4 class=" fw-bold text-dark">All Events</h4>
                                <div class="d-flex">
                                    <a href="{{ route('EventAddPage') }}" class="btn btn-primary btn-sm shadow-sm">
                                        <i class="mdi mdi-plus"></i> Add New Record
                                    </a>
                                </div>
                            </div>
                            <br>
                            <table class="table table-hover" id="myTable">

                                <thead class="table-dark">
                                    <tr>
                                        <th>
                                            Image
                                        </th>

                                        <th>
                                            Title
                                        </th>
                                        <th>
                                            Category
                                        </th>
                                        <th>
                                            City
                                        </th>
                                        <th>
                                            Capacity
                                        </th>
                                        <th>
                                            Price
                                        </th>
                                        <th>
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($event as $item)
                                        <tr class="text-capitalize">
                                            <td class="py-1">
                                                @php
                                                    $images = json_decode($item->image, true);

                                                @endphp
                                                @if (is_array($images) && count($images) > 0)
                                                    @php
                                                        $firstImage = $images[0];
                                                    @endphp
                                                    <img src="{{ asset('/storage/' . $firstImage) }}">
                                                @endif
                                            </td>

                                            <td>
                                                {{ $item->title }}
                                            </td>
                                            <td>
                                                {{ $item->getcategory->category_name }}
                                            </td>
                                            <td>
                                                {{ $item->getcity->city_name }}
                                            </td>
                                            <td>
                                                {{ $item->capacity }}
                                            </td>
                                            <td>
                                                {{ $item->price }}
                                            </td>
                                            <td>&nbsp;&nbsp;&nbsp;
                                                <a href="{{ route('EventDetailPage', $item->id) }}"
                                                    class=" text-decoration-none "><i
                                                        class="mdi mdi-eye mdi-24px color-black"></i>
                                                </a>&nbsp;&nbsp;&nbsp;
                                                <a href="{{ route('EditEventPage', $item->id) }}"
                                                    class=" text-decoration-none  text-dark"><i
                                                        class="mdi mdi-pencil-box mdi-24px"></i>
                                                </a>&nbsp;&nbsp;&nbsp;
                                                <a href="javascript:void(0)" class=" text-decoration-none  text-danger"
                                                    data-id="{{ $item->id }}"><i
                                                        class="mdi mdi-delete btn-del mdi-24px"></i>
                                                </a>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div> --}}

        </div>
<!-- Simple Event Modal -->
<div class="modal fade text-capitalize" id="eventModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Event Details</h4>
                <button type="button" class="close sm" data-bs-dismiss="modal">
                    <span>x</span>&nbsp;
                </button>
            </div>

            <div class="modal-body">
                <p><strong>Event : </strong> <span id="m_event">-</span></p>
                <p><strong>Customer : </strong> <span id="m_customer">-</span></p>
                <p><strong>Quantity : </strong> <span id="m_qty">-</span></p>
                <p><strong>Start Date : </strong> <span id="m_start">-</span></p>
                <p><strong>End Date : </strong> <span id="m_end">-</span></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>

        @include('footer')
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            let calendarEl = document.getElementById('calendar');

            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                contentHeight: 500,

                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },

                events: {
                    url: "{{ route('DashboardEventPage') }}",
                    method: 'GET'
                },

                eventClick: function(info) {
                    if (!info.event) {
                        console.error('No event object found', info);
                        return;
                    }

                    let props = info.event.extendedProps || {};

                    document.getElementById('m_customer').innerText = props.customer ?? '-';
                    document.getElementById('m_event').innerText = props.event ?? '-';
                    document.getElementById('m_qty').innerText = props.qty ?? '-';
                    document.getElementById('m_start').innerText = info.event.startStr ?? '-';
                    document.getElementById('m_end').innerText = info.event.endStr ?? '-';

                    $('#eventModal').modal('show');
                }
            });

            calendar.render();
        });
    </script>
@endsection
