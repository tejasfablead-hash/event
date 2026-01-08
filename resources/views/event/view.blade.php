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
                        <li class="breadcrumb-item"><a href="#">Event</a></li>
                        <li class="breadcrumb-item active" aria-current="page">View Event</li>
                    </ol>
                </nav>
            </div>

            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card shadow-sm rounded-4">
                    <div class="card-body">
                       
                            <div class="bg-white d-flex flex-wrap justify-content-between align-items-center">
                                <!-- Title -->
                                <h4 class=" fw-bold text-dark">Manage Event Data</h4>
                                <div class="d-flex">
                                    <a href="{{ route('EventAddPage') }}" class="btn btn-primary btn-sm shadow-sm">
                                        <i class="mdi mdi-plus"></i> Add New Record
                                    </a>
                                </div>
                            </div>
                      
                        <br>
                     <table class="table table-hover rounded-table" id="myTable">

                            <thead>
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
                                                    class=" text-decoration-none "><i class="mdi mdi-eye mdi-24px color-black"></i>
                                                </a>&nbsp;&nbsp;&nbsp;
                                                <a href="{{ route('EditEventPage', $item->id) }}"
                                                    class=" text-decoration-none  text-dark"><i class="mdi mdi-pencil-box mdi-24px"></i>
                                                </a>&nbsp;&nbsp;&nbsp;
                                                <a href="javascript:void(0)" class=" text-decoration-none  text-danger"
                                                    data-id="{{ $item->id }}"><i class="mdi mdi-delete btn-del mdi-24px"></i>
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
                    var url = "/events-delete/" + id;
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
                     var data = $('#modelform')[0];
                    var formData = new FormData(data);
                    var url = "/event-book";
                    $('.error').text('');

                    reusableAjaxCall(url, 'POST', formData, function(response) {
                        console.log(response);
                        if (response.status == true) {
                            $('#message').removeClass('d-none').html(response.message).fadeIn();
                            setTimeout(function() {
                                $('#message').addClass('d-none').html('').fadeOut();
                                window.location.href = "{{ route('EventViewPage') }}";
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
