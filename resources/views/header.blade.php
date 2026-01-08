  <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
          <a class="navbar-brand brand-logo" href="{{ route('DashboardPage') }}"><img
                  src="{{ asset('images/new.png') }}"class="w-50 h-50" alt="Home" /></a>
          <a class="navbar-brand brand-logo-mini" href="{{ route('DashboardPage') }}"><img
                  src="{{ asset('images/event.jpg') }}" class="img-fluid rounded">
          </a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-stretch">
          <div class="search-field d-none d-md-block">
              <form class="d-flex align-items-center h-100" action="#">
                  <div class="input-group">
                      <div class="input-group-prepend bg-transparent">
                          <i class="input-group-text border-0 mdi mdi-magnify"></i>
                      </div>
                      <input type="text" class="form-control bg-transparent border-0" placeholder="Search event...">
                  </div>
              </form>
          </div>
          <ul class="navbar-nav navbar-nav-right">
              <li class="nav-item nav-profile dropdown">
                  <a class="nav-link dropdown-toggle" id="profileDropdown" href="" data-toggle="dropdown"
                      aria-expanded="false">
                      <div class="nav-profile-img">
                          <img src="{{ asset('storage/user/' . Auth()->user()->image) }}" class="img-lg rounded-circle">

                          <span class="availability-status online"></span>
                      </div>
                      <div class="nav-profile-text">
                          <p class="mb-1 text-black"> </p>
                      </div>
                  </a>
                  <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                      <a class="dropdown-item" href="{{ route('ProfilePage') }}">
                          <i class="mdi mdi-cached mr-2 text-success"></i>
                          Profile
                      </a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" id="logout" href="#">
                          <i class="mdi mdi-logout mr-2 text-primary"></i>
                          Signout
                      </a>
                  </div>
              </li>
              <li class="nav-item d-none d-lg-block full-screen-link">
                  <a class="nav-link">
                      <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
                  </a>
              </li>
              <li class="nav-item dropdown">
                  <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#"
                      data-toggle="dropdown" aria-expanded="false">
                      <i class="mdi mdi-email-outline"></i>
                      <span class="count-symbol bg-warning"></span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                      aria-labelledby="messageDropdown">
                      <h6 class="p-3 mb-0">Messages</h6>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item preview-item">
                          <div class="preview-thumbnail">
                              <img src="images/faces/face4.jpg" alt="image" class="profile-pic">
                          </div>
                          <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                              <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Mark send you a message</h6>
                              <p class="text-gray mb-0">
                                  1 Minutes ago
                              </p>
                          </div>
                      </a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item preview-item">
                          <div class="preview-thumbnail">
                              <img src="images/faces/face2.jpg" alt="image" class="profile-pic">
                          </div>
                          <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                              <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Cregh send you a message</h6>
                              <p class="text-gray mb-0">
                                  15 Minutes ago
                              </p>
                          </div>
                      </a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item preview-item">
                          <div class="preview-thumbnail">
                              <img src="images/faces/face3.jpg" alt="image" class="profile-pic">
                          </div>
                          <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                              <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Profile picture updated</h6>
                              <p class="text-gray mb-0">
                                  18 Minutes ago
                              </p>
                          </div>
                      </a>
                      <div class="dropdown-divider"></div>
                      <h6 class="p-3 mb-0 text-center">4 new messages</h6>
                  </div>
              </li>
              <li class="nav-item dropdown">
                  <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
                      data-toggle="dropdown">
                      <i class="mdi mdi-bell-outline"></i>
                      <span class="count-symbol bg-danger"></span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                      aria-labelledby="notificationDropdown">
                      <h6 class="p-3 mb-0">Notifications</h6>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item preview-item">
                          <div class="preview-thumbnail">
                              <div class="preview-icon bg-success">
                                  <i class="mdi mdi-calendar"></i>
                              </div>
                          </div>
                          <div
                              class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                              <h6 class="preview-subject font-weight-normal mb-1">Event today</h6>
                              <p class="text-gray ellipsis mb-0">
                                  Just a reminder that you have an event today
                              </p>
                          </div>
                      </a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item preview-item">
                          <div class="preview-thumbnail">
                              <div class="preview-icon bg-warning">
                                  <i class="mdi mdi-settings"></i>
                              </div>
                          </div>
                          <div
                              class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                              <h6 class="preview-subject font-weight-normal mb-1">Settings</h6>
                              <p class="text-gray ellipsis mb-0">
                                  Update dashboard
                              </p>
                          </div>
                      </a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item preview-item">
                          <div class="preview-thumbnail">
                              <div class="preview-icon bg-info">
                                  <i class="mdi mdi-link-variant"></i>
                              </div>
                          </div>
                          <div
                              class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                              <h6 class="preview-subject font-weight-normal mb-1">Launch Admin</h6>
                              <p class="text-gray ellipsis mb-0">
                                  New admin wow!
                              </p>
                          </div>
                      </a>
                      <div class="dropdown-divider"></div>
                      <h6 class="p-3 mb-0 text-center">See all notifications</h6>
                  </div>
              </li>
              <li class="nav-item nav-logout d-none d-lg-block">
                  <a class="nav-link" href="#">
                      <i class="mdi mdi-power"></i>
                  </a>
              </li>
              <li class="nav-item nav-settings d-none d-lg-block">
                  <a class="nav-link" href="#">
                      <i class="mdi mdi-format-line-spacing"></i>
                  </a>
              </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
              data-toggle="offcanvas">
              <span class="mdi mdi-menu"></span>
          </button>
      </div>
  </nav>

  <script src="https://code.jquery.com/jquery-3.7.1.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
  </script>
  <script src="{{ asset('ajax.js') }}"></script>
  <script>
      $(document).ready(function() {

          $('#logout').on('click', function() {
              var url = "{{ route('LogoutPage') }}";
              reusableAjaxCall(url, 'POST', null, function(response) {
                  window.location.href = '/';
              });
          });
      });
  </script>
