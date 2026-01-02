 <nav class="sidebar sidebar-offcanvas" id="sidebar">
     <ul class="nav">
         <li class="nav-item nav-profile">
             <a href="#" class="nav-link">
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
         </li>
         <li class="nav-item">
             <a class="nav-link" href="{{ route('DashboardPage') }}">
                 <span class="menu-title">Dashboard</span>
                 <i class="mdi mdi-home menu-icon"></i>
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
              
                     @if(Auth::user()->role == 1)
                         <li class="nav-item"> <a class="nav-link" href="{{ route('EventAddPage') }}">Add Event</a></li>
                         <li class="nav-item"> <a class="nav-link" href="{{ route('EventViewPage') }}">All Event</a>
                         </li>
                     @else
                         <li class="nav-item"> <a class="nav-link" href="{{ route('EventViewPage') }}">All Event</a>
                         </li>
                     @endif
                

                 </ul>
             </div>
         </li>
             <li class="nav-item">
             <a class="nav-link" data-toggle="collapse" href="#ui-basics" aria-expanded="false" aria-controls="ui-basics">
                 <span class="menu-title">Booking</span>
                 <i class="menu-arrow"></i>
                 <i class="mdi mdi-crosshairs-gps menu-icon"></i>
             </a>
             <div class="collapse" id="ui-basics">
                 <ul class="nav flex-column sub-menu">
              
                     @if(Auth::user()->role == 1)
                         <li class="nav-item"> <a class="nav-link" href="{{route('EventsIndexPage')}}">Add Booking</a></li>
                         <li class="nav-item"> <a class="nav-link" href="{{route('EventsBookViewPage')}}">All Booking</a>
                         </li>
                     @else
                         <li class="nav-item"> <a class="nav-link" href="{{ route('EventsBookViewPage') }}">All Event</a>
                         </li>
                     @endif
                 </ul>
             </div>
         </li>
         <li class="nav-item">
             <a class="nav-link" href="pages/forms/basic_elements.html">
                 <span class="menu-title">Forms</span>
                 <i class="mdi mdi-format-list-bulleted menu-icon"></i>
             </a>
         </li>
         <li class="nav-item">
             <a class="nav-link" href="pages/charts/chartjs.html">
                 <span class="menu-title">Charts</span>
                 <i class="mdi mdi-chart-bar menu-icon"></i>
             </a>
         </li>
         <li class="nav-item">
             <a class="nav-link" href="pages/tables/basic-table.html">
                 <span class="menu-title">Tables</span>
                 <i class="mdi mdi-table-large menu-icon"></i>
             </a>
         </li>
         <li class="nav-item">
             <a class="nav-link" data-toggle="collapse" href="#general-pages" aria-expanded="false"
                 aria-controls="general-pages">
                 <span class="menu-title">Sample Pages</span>
                 <i class="menu-arrow"></i>
                 <i class="mdi mdi-medical-bag menu-icon"></i>
             </a>
             <div class="collapse" id="general-pages">
                 <ul class="nav flex-column sub-menu">
                     <li class="nav-item"> <a class="nav-link" href="pages/samples/blank-page.html"> Blank Page </a>
                     </li>
                     <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Login </a></li>
                     <li class="nav-item"> <a class="nav-link" href="pages/samples/register.html"> Register </a></li>
                     <li class="nav-item"> <a class="nav-link" href="pages/samples/error-404.html"> 404 </a></li>
                     <li class="nav-item"> <a class="nav-link" href="pages/samples/error-500.html"> 500 </a></li>
                 </ul>
             </div>
         </li>
         <li class="nav-item sidebar-actions">
             <span class="nav-link">
                 <!-- <div class="border-bottom">
                <h6 class="font-weight-normal mb-3">Projects</h6>
              </div> -->
                 <!-- <button class="btn btn-block btn-lg btn-gradient-primary mt-4">+ Add a project</button> -->
                 <div class="mt-4">
                     <div class="border-bottom">
                         <p class="text-secondary">Categories</p>
                     </div>

                 </div>
             </span>
         </li>
     </ul>
 </nav>
