@extends('index')
@section('container')
  
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title">View Booking Event</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Event</a></li>
                        <li class="breadcrumb-item active" aria-current="page">View Booking Event</li>
                    </ol>
                </nav>
            </div>

            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="bg-white d-flex flex-wrap justify-content-between align-items-center">
                            <h4 class="fw-bold text-dark">Manage Booking Data</h4>
                            <div class="d-flex">
                                <a href="{{ route('EventsIndexPage') }}" class="btn btn-primary btn-sm shadow-sm">
                                    <i class="mdi mdi-plus"></i> Add New Booking
                                </a>
                            </div>
                        </div>
                        <br>

                        <table class="table table-bordered table-striped text-capitalize" id="myTable">
                            <thead class="">
                                <tr>
                                    <th>#</th>
                                    <th>Customer</th>
                                    <th>Event</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $count = 1; @endphp
                                @foreach ($book as $item)
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td>{{ $item->getcustomer->name }}</td>

                                        <td>
                                            @foreach ($item->event as $i => $eventId)
                                                {{ $event[$eventId] ?? 'N/A' }}@if ($i < count($item->event) - 1)
                                                    <br>
                                                @endif
                                            @endforeach
                                        </td>

                                        <td>
                                            @foreach ($item->qty as $i => $q)
                                                {{ $q }}@if ($i < count($item->qty) - 1)
                                                    <br>
                                                @endif
                                            @endforeach
                                        </td>

                                        <td>
                                            @foreach ($item->total as $i => $price)
                                                {{ $price }}@if ($i < count($item->total) - 1)
                                                    <br>
                                                @endif
                                            @endforeach
                                        </td>

                                        <td>{{ $item->grand_total }}</td>

                                        <td>{{ $item->status }}</td>

                                        <td>
                                            <a href="{{route('EventsBookDetailPage',$item->id)}}" class="text-decoration-none"><i
                                                    class="mdi mdi-eye mdi-24px color-black"></i></a>
                                            <a href="#" class="text-decoration-none text-dark"><i
                                                    class="mdi mdi-pencil-box mdi-24px"></i></a>
                                            <a href="javascript:void(0)" class="text-decoration-none text-danger btn-del"
                                                data-id="{{ $item->id }}">
                                                <i class="mdi mdi-delete mdi-24px"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>



                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal for Updating Status --}}
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
                        <button type="submit" class="btn btn-primary w-100">Update Status</button>
                    </form>
                    <div id="message" class="alert alert-success text-center mt-2 d-none"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.6/js/dataTables.min.js"></script>
    <script src="{{ asset('ajax.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = $('#myTable').DataTable();

            // Delete Booking
            $('#myTable').on('click', '.btn-del', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var obj = $(this);
                var url = "/eventbook-delete/" + id;
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you cannot recover this booking!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        reusableAjaxCall(url, 'GET', null, function(response) {
                            swal("Deleted!", response.message, "success");
                            table.row(obj.closest('tr')).remove().draw(false);
                        }, function(error) {
                            console.log(error);
                        });
                    }
                });
            });

            // Open modal
            $(document).on('click', '.open-modal', function() {
                let id = $(this).data('id');
                let status = $(this).data('status');
                $('#booking_id').val(id);
                $('#status').val(status);
            });

            // Update Status
            $('#modelform').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var url = "/event-book-update";
                $('.error').text('');
                reusableAjaxCall(url, 'POST', formData, function(response) {
                    if (response.status) {
                        $('#message').removeClass('d-none').html(response.message).fadeIn();
                        setTimeout(function() {
                            $('#message').addClass('d-none').fadeOut();
                            location.reload();
                        }, 2000);
                    }
                }, function(error) {
                    console.log(error);
                });
            });
        });
    </script>
@endsection
