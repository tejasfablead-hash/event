@extends('index')
@section('container')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title">

                </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Event</a></li>
                        <li class="breadcrumb-item active" aria-current="page">View Booking Event </li>
                    </ol>
                </nav>
            </div>

            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="bg-white d-flex flex-wrap justify-content-between align-items-center">
                            <!-- Title -->
                            <h4 class=" fw-bold text-dark">Manage Booking Data</h4>
                            <div class="d-flex">
                                <a href="{{ route('EventsIndexPage') }}" class="btn btn-primary btn-sm shadow-sm">
                                    <i class="mdi mdi-plus"></i> Add New Booking
                                </a>
                            </div>
                        </div>
                        <br>

                        <table class="table table-striped" id="myTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>
                                        Customer
                                    </th>

                                    <th>
                                        Event
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
                                        Price
                                    </th>
                                     <th>
                                       Total Price
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
                                @php
                                    $count = 1;
                                @endphp
                                @foreach ($book as $item)
                                    <tr>
                                        <td class="py-1">
                                            {{ $count++ }}
                                        </td>
                                        <td>
                                            {{ $item->getcustomer->name }}
                                        </td>
                                        <td>
                                            {{substr( $item->getevent->title,0,10) }}
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
                                            ₹ {{ number_format((float) $item->total) }}
                                        </td>
                                        <td>
                                            ₹ {{ number_format((float) $item->grandtotal) }}
                                        </td>
                                        <td>
                                            {{ $item->status }}
                                        </td>

                                        <td>&nbsp;&nbsp;&nbsp;

                                            <a href="{{ route('EventsBookDetailPage', $item->id) }}"
                                                class=" text-decoration-none  "><i class="mdi mdi-eye mdi-24px"></i>
                                            </a>&nbsp;&nbsp;&nbsp;

                                            <a href=" {{ route('EventsMultiBookEditPage', $item->id) }}"
                                                class="text-decoration-none  text-dark open-modal">
                                                <i class="mdi mdi-pencil-box mdi-24px"></i>
                                            </a>
                                            {{-- <a href="javascript:void(0)" class="text-decoration-none text-dark open-modal"
                                                data-bs-toggle="modal" data-bs-target="#topUpModal"
                                                data-id="{{ $item->id }}" data-status="{{ $item->status }}">
                                                <i class="mdi mdi-pencil-box mdi-24px"></i>
                                            </a>EventsMultiBookEditPage --}}
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="javascript:void(0)" class=" text-danger text-decoration-none"
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
        </div>

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

                            <button type="submit" class="btn btn-primary w-100">
                                Update Status
                            </button>
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
                $('#myTable').on('click', '.btn-del', function(e) {
                    e.preventDefault();
                    var id = $(this).closest('a').data('id');
                    var obj = $(this);
                    var url = "/eventbook-delete/" + id;
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
                                    reIndexTableRows(table);
                                }, function(error) {
                                    console.log(error);
                                });
                            } else {
                                swal("Cancelled", "Your imaginary record is safe :)", "error");
                            }
                        });
                });

                function reIndexTableRows(dataTableInstance) {
                    dataTableInstance.rows().nodes().each(function(row, index) {
                        $(row).find('.btn-del').each(function() {
                            $(this).data('id', index + 1);
                            $(row).find('td:first').text(index + 1);
                        });
                    });
                }

                $(document).on('click', '.open-modal', function() {
                    let id = $(this).data('id');
                    let status = $(this).data('status');
                    $('#booking_id').val(id);
                    $('#status').val(status);

                });

                $('#modelform').on('submit', function(e) {
                    e.preventDefault();
                    var data = $('#modelform')[0];
                    var formData = new FormData(data);
                    var url = "/event-book-update";
                    $('.error').text('');

                    reusableAjaxCall(url, 'POST', formData, function(response) {
                        console.log(response);
                        if (response.status == true) {
                            $('#message').removeClass('d-none').html(response.message).fadeIn();
                            setTimeout(function() {
                                $('#message').addClass('d-none').html('').fadeOut();
                                window.location.href = "{{ route('EventsBookViewPage') }}";
                            }, 4000);
                        }
                        $('#modelform')[0].reset();
                        $('.error').empty();
                    }, function(error) {
                        console.log(error);
                    });
                })

            });
        </script>
    @endsection
