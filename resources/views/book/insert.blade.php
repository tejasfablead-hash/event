@extends('index')
@section('container')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h5 class="page-title pr-5">
                    <div id="message" class="alert alert-success text-center d-none" role="alert"></div>
                </h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Event</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Event</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add Booking</h4>
                        <br>
                        <form class="form-sample" id="addform" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <table>
                                    <tr>
                                        <td><label class="col-form-label">Customer</label><select class="form-control"
                                                name="customer">
                                                <option value="">Select customer....</option>
                                                @foreach ($customer as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error" id="customer_error"></span>
                                        </td>

                                        <td class="gap-2"><label class="col-form-label">Event</label>
                                            <select class="form-control " name="event">
                                                <option value="">Select Event....</option>
                                                @foreach ($event as $item)
                                                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error" id="event_error"></span>
                                        </td>
                                        <td>
                                            <label class="col-form-label">Start_date</label>
                                            <input type="date" name="startdate" class="form-control ">
                                            <span class="text-danger error" id="startdate_error"></span>
                                        </td>
                                        <td>
                                            <label class="col-form-label">End_date</label>
                                            <input type="date" name="startdate" class="form-control">
                                            <span class="text-danger error" id="enddate_error"></span>
                                        </td>
                                        <td>
                                            <label class="col-form-label">Qty</label>
                                            <input type="text" name="qty" class="form-control"
                                                placeholder="enter qty">
                                            <span class="text-danger error" id="qty_error"></span>
                                        </td>
                                          <td>
                                            <label class="col-form-label">Pice</label>
                                            <input type="text" name="price" class="form-control"
                                                placeholder="enter price">
                                            <span class="text-danger error" id="price_error"></span>
                                        </td>
                                        <td>
                                            <label class="col-form-label mt-3"></label>
                                            <i class="mdi mdi-plus " id="add"></i>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-2">
                                    <input type="submit"  name="submit" class="btn btn-gradient-primary mr-2" value="Submit">
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://code.jquery.com/jquery-3.7.1.js" crossorigin="anonymous"></script>
        <script src="{{ asset('ajax.js') }}"></script>
        <script>
            $(document).ready(function() {


                // $('#eventform').submit(function(e) {
                //     e.preventDefault();
                //     var data = $('#eventform')[0];
                //     var formData = new FormData(data);
                //     var url = "{{ route('EventStorePage') }}";
                //     $('.error').text('');
                //     reusableAjaxCall(url, 'POST', formData, function(response) {
                //         console.log(response.message);
                //         if (response.status == true) {
                //             $('#message').removeClass('d-none').html(response.message).fadeIn();
                //             setTimeout(function() {
                //                 $('#message').addClass('d-none').html('').fadeOut();
                //                 window.location.href = "{{ route('EventViewPage') }}";
                //             }, 4000);
                //         }
                //         $('#eventform')[0].reset();
                //         $(".error").empty();
                //     }, function(error) {
                //         console.log(error);
                //     });

                // });
            });
        </script>
    @endsection
