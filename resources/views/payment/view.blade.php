@extends('index')
@section('container')
    <style>

    </style>
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title">

                </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Payment</a></li>
                        <li class="breadcrumb-item active" aria-current="page">View Payment</li>
                    </ol>
                </nav>
            </div>

            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card shadow-sm rounded-4">
                    <div class="card-body">
                        <div class="bg-white d-flex flex-wrap justify-content-between align-items-center">
                            <!-- Title -->
                            <h4 class=" fw-bold text-dark"> Payment Details</h4>
                        </div>
                        <br>
                        <table class="table  table-hover " id="myTable">

                            <thead>
                                <tr>
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        Payment Method
                                    </th>
                                    <th>
                                        Payment_Id
                                    </th>
                                    <th>
                                        Amount
                                    </th>
                                    <th>
                                        Currency
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($payment as $item)
                                    <tr class="text-capitalize">
                                        <td class="py-1">

                                            {{ $item->getcustomer->name }}

                                        </td>
                                        <td class="text-capitalize">
                                            {{ $item->method }}
                                        </td>
                                        <td class="text-capitalize">
                                            {{ $item->payment_id }}
                                        </td>
                                        <td>
                                            {{ $item->amount }}
                                        </td>
                                        <td>
                                            {{ $item->currency }}
                                        </td>
                                        <td>
                                            {{ $item->status }}
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                    var url = "/user-delete/" + id;
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



            });
        </script>
    @endsection
