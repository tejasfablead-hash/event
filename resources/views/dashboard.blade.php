 @extends('index')
 @section('container')
     <style>
         #calendar {
             max-width: 100%;
         }

         .fc {
             font-size: 14px;
         }
     </style>

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
                         <li class="breadcrumb-item active" aria-current="page">
                             <span></span>Overview
                             <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                         </li>
                     </ul>
                 </nav>
             </div>
             <div class="row">
                 <div class="col-md-3 stretch-card grid-margin">
                     <div class="card bg-gradient-danger card-img-holder text-white">
                         <div class="card-body">
                             <img src="images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                             <h4 class="font-weight-normal mb-3">Total Event
                                 <i class="mdi mdi-chart-line mdi-24px float-right"></i>
                             </h4>
                             <h2 class="mb-5">{{ $event }}</h2>
                         </div>
                     </div>
                 </div>
                 <div class="col-md-3 stretch-card grid-margin">
                     <div class="card bg-gradient-info card-img-holder text-white">
                         <div class="card-body">
                             <img src="images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                             <h4 class="font-weight-normal mb-3">Total Booking
                                 <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                             </h4>
                             <h2 class="mb-5">{{ $book }}</h2>
                         </div>
                     </div>
                 </div>
                 <div class="col-md-3 stretch-card grid-margin">
                     <div class="card bg-gradient-success card-img-holder text-white">
                         <div class="card-body">
                             <img src="images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                             <h4 class="font-weight-normal mb-3">Total Customer
                                 <i class="mdi mdi-account-circle mdi-24px float-right"></i>
                             </h4>
                             <h2 class="mb-5">{{ $customer }}</h2>
                         </div>
                     </div>
                 </div>
                   <div class="col-md-3 stretch-card grid-margin">
                     <div class="card bg-gradient-dark card-img-holder text-white">
                         <div class="card-body">
                             <img src="images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                             <h4 class="font-weight-normal mb-3">Total Pending
                                 <i class="mdi mdi-clock-alert mdi-24px float-right"></i>
                             </h4>
                             <h2 class="mb-5">{{ $pending }}</h2>
                         </div>
                     </div>
                 </div>
             </div>

             <div class="row">
                 <div class="col-12 grid-margin stretch-card">
                     <div class="card">
                         <div class="row">
                             <div class="col-12 grid-margin stretch-card">
                                 <div class="card">
                                     <div class="card-body">
                                         <h4 class="card-title">Calendar</h4>
                                         <div id="calendar" class="text-capitalize"></div>
                                     </div>
                                 </div>
                             </div>
                         </div>


                     </div>
                 </div>
             </div>

             <!-- Simple Event Details Modal -->
             <div class="modal fade" id="eventModal" tabindex="-1" aria-hidden="true">
                 <div class="modal-dialog modal-dialog-centered modal-md">
                     <div class="modal-content">

                         <div class="modal-header text-capitalize">
                             <h5 class="modal-title">Booking Details</h5>
                             <button type="button" class="btn-close border-0" data-bs-dismiss="modal">X</button>
                         </div>

                         <div class="modal-body text-capitalize">

                             <div class="d-flex  gap-2 mb-2">
                                 <span class="text-muted">Customer : </span>
                                 <strong id="m_customer"></strong>
                             </div>

                             <div class="d-flex gap-2  mb-2">
                                 <span class="text-muted">Event : </span>
                                 <strong id="m_event"></strong>
                             </div>

                             <hr>

                             <div class="d-flex gap-2  mb-2">
                                 <span class="text-muted">Start Date : </span>
                                 <span id="m_start"></span>
                             </div>

                             <div class="d-flex mb-2">
                                 <span class="text-muted">End Date : </span>
                                 <span id="m_end" class="gap-2"></span>
                             </div>

                             <hr>

                             <div class="d-flex ">
                                 <span class="text-muted">Status : </span>
                                 <span id="m_status"></span>
                             </div>

                         </div>

                         <div class="modal-footer">
                             <button class="btn btn-dark btn-sm" data-bs-dismiss="modal">
                                 Close
                             </button>
                         </div>

                     </div>
                 </div>
             </div>

         </div>
         @include('footer')
         <!-- partial -->
     </div>
     <script>
         document.addEventListener('DOMContentLoaded', function() {

             let calendarEl = document.getElementById('calendar');

             let calendar = new FullCalendar.Calendar(calendarEl, {
                 initialView: 'dayGridMonth',
                 height: 'auto',

                 headerToolbar: {
                     left: 'prev,next today',
                     center: 'title',
                     right: 'dayGridMonth,timeGridWeek,timeGridDay'
                 },

                 events: {
                     url: "{{ route('DashboardEventPage') }}",
                     method: 'GET',
                     failure: function() {
                         alert('Error loading events');
                     }
                 },

                 eventClick: function(info) {
                     let e = info.event;
                     document.getElementById('m_customer').innerText = e.extendedProps.customer;
                     document.getElementById('m_event').innerText = e.extendedProps.event;
                     document.getElementById('m_start').innerText = e.startStr;
                     document.getElementById('m_end').innerText = e.endStr ?? '-';
                     document.getElementById('m_status').innerText = e.extendedProps.status;

                     $('#eventModal').modal('show');
                 }

             });

             calendar.render();
         });
     </script>
 @endsection
