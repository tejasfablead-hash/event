@extends('index')

@section('container')
    <style>
        /* DASHBOARD CARDS */
        .stretch-card .card {
            min-height: 160px;
            border-radius: 14px;
        }

        .card-body h2 {
            font-size: 32px;
            font-weight: 700;
        }

        .card-body h4 {
            font-size: 16px;
        }

        /* CALENDAR */
        #calendar {
            width: 100%;
            /* min-height: 500px; */
        }

        .fc-toolbar-title {
            font-size: 22px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .fc-button {
            text-transform: capitalize;
        }

        .fc-daygrid-event {
            font-size: 13px;
            padding: 2px 4px;
        }
    </style>

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
                        <div class="card-body">
                            <h4 class="card-title mb-3">Event Calendar</h4>
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- EVENT MODAL -->
            <div class="modal fade" id="eventModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Booking Details</h5>
                            <button type="button" class="btn-close border-0" data-bs-dismiss="modal">x</button>

                        </div>

                        <div class="modal-body text-capitalize">
                            <p><strong>Customer :</strong> <span id="m_customer"></span></p>
                            <p><strong>Event :</strong> <span id="m_event"></span></p>
                            <hr>
                            <p><strong>Start :</strong> <span id="m_start"></span></p>
                            <p><strong>End :</strong> <span id="m_end"></span></p>
                            <hr>
                            <p><strong>City :</strong> <span id="m_city"></span></p>
                            <p><strong>Status :</strong> <span id="m_status"></span></p>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-dark btn-sm " data-bs-dismiss="modal">Close</button>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        @include('footer')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            let calendarEl = document.getElementById('calendar');

            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                contentHeight: 600,

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
                    let e = info.event;
                    document.getElementById('m_customer').innerText = e.extendedProps.customer;
                    document.getElementById('m_event').innerText = e.extendedProps.event;
                    document.getElementById('m_start').innerText = e.startStr;
                    document.getElementById('m_end').innerText = e.endStr ?? '-';
                    document.getElementById('m_status').innerText = e.extendedProps.status;
                    document.getElementById('m_city').innerText = e.extendedProps.city;

                    $('#eventModal').modal('show');
                }
            });

            calendar.render();
        });
    </script>
@endsection
