 <nav class="sidebar sidebar-offcanvas" id="sidebar">
     <ul class="nav">
         {{-- <li class="nav-item nav-profile">
             <a href="{{route('ProfilePage')}}  " class="nav-link">
                 <div class="nav-profile-image">
                     <img src="{{ asset('storage/user/' . Auth()->user()->image) }}" class="img-lg rounded-circle">

                     <span class="login-status online"></span> <!--change to offline or busy as needed-->
                 </div>
                 <div class="nav-profile-text d-flex flex-column">
                     <span class="font-weight-bold mb-2 text-capitalize">{{ Auth::user()->name }}</span>
                     <span class="text-secondary text-small">Well Come Admin</span>
                 </div>
                 <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
             </a>
         </li> --}}
         <li class="nav-item">
             <a class="nav-link" href="{{ route('DashboardPage') }}">
                 <span class="menu-title">Dashboard</span>
                 <i class="mdi mdi-home menu-icon"></i>
             </a>
         </li>
         <li class="nav-item">
             <a class="nav-link" href="{{ route('UsersPage') }}">
                 <span class="menu-title">Customer</span>
                 <i class="mdi mdi-account-circle menu-icon"></i>
             </a>
         </li>
         <li class="nav-item">
             <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                 <span class="menu-title">Event</span>
                 <i class="menu-arrow"></i>
                 <i class="mdi mdi-crosshairs-gps menu-icon"></i>
             </a>
             <div class="collapse" id="ui-basic">
                 <ul class="nav flex-column sub-menu">

                     <li class="nav-item"> <a class="nav-link" href="{{ route('EventAddPage') }}">Add Event</a></li>
                     <li class="nav-item"> <a class="nav-link" href="{{ route('EventViewPage') }}">All Event</a>
                     </li>

                 </ul>
             </div>
         </li>
         <li class="nav-item">
             <a class="nav-link" data-toggle="collapse" href="#ui-basics" aria-expanded="false"
                 aria-controls="ui-basics">
                 <span class="menu-title">Booking</span>
                 <i class="menu-arrow"></i>
                 <i class="mdi mdi-crosshairs-gps menu-icon"></i>
             </a>
             <div class="collapse" id="ui-basics">
                 <ul class="nav flex-column sub-menu">

                     <li class="nav-item"> <a class="nav-link" href="{{ route('EventsIndexPage') }}">Add Booking</a>
                     </li>
                     <li class="nav-item"> <a class="nav-link" href="{{ route('EventsBookViewPage') }}">All Booking</a>
                     </li>

                 </ul>
             </div>
         </li>

         <li class="nav-item">
             <a class="nav-link" href="{{ route('ViewPaymentPage') }}">
                 <span class="menu-title">Payment</span>
                 <i class="mdi mdi-bank menu-icon"></i>
             </a>
         </li>

     </ul>
 </nav>
