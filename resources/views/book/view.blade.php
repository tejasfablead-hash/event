@extends('index')
@section('container')
    <style>
        .tbody-border td,
        th {
            border: 1px solid #000 !important;
        }
    </style>
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title">
                    
                </h3>
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

                        <table class="table table-bordered bordered-3 table-striped text-capitalize" id="myTable">
                            <thead class="table-bordered bordered-3">
                                <tr>
                                    <th>#</th>
                                    <th>Customer</th>
                                    <th>Event</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Total Price</th>

                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="tbody-border">
                                @php $count = 1; @endphp
                                @foreach ($book as $item)
                                    <tr class="table">
                                        <td>{{ $count++ }}</td>
                                        <td>{{ $item->getcustomer->name }}</td>

                                        <td>
                                            @foreach ($item->event as $i => $eventId)
                                                {{ $event[$eventId] ?? 'N/A' }}@if ($i < count($item->event) - 1)
                                                    <br>
                                                    <br>
                                                @endif
                                            @endforeach
                                        </td>

                                        <td>
                                            @foreach ($item->qty as $i => $q)
                                                {{ $q }}@if ($i < count($item->qty) - 1)
                                                    <br>
                                                    <br>
                                                @endif
                                            @endforeach
                                        </td>

                                        <td>
                                            @foreach ($item->total as $i => $price)
                                                {{ $price }}@if ($i < count($item->total) - 1)
                                                    <br>
                                                    <br>
                                                @endif
                                            @endforeach
                                        </td>

                                        <td>{{ $item->grand_total }}</td>



                                        <td>
                                            <a href="{{ route('EventsBookDetailPage', $item->id) }}"
                                                class="text-decoration-none"><i
                                                    class="mdi mdi-eye mdi-24px color-black"></i></a>
                                            <a href="{{ route('EventsMultiBookEditPage', $item->id) }}"
                                                class="text-decoration-none text-dark"><i
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
                var url = "/delete-eventbook/" + id;
                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this imaginary file!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        cancelButtonText: "No",
                        confirmButtonText: "Yes",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(id) {
                        if (id) {
                            reusableAjaxCall(url, 'GET', null, function(response) {
                                console.log(response.message);
                                swal("Deleted!", response.message,
                                    "success");
                                table
                                    .row(obj.closest('tr'))
                                    .remove()
                                    .draw(false);
                            }, function(error) {
                                console.log(error);
                            });
                        } else {
                            swal("Cancelled", "Your imaginary record is safe :)", "error");
                        }
                    });
            });
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
