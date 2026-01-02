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
                                <table id="table" class="table 
                            table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Customer</th>
                                            <th>Event</th>
                                            <th>Select Date</th>
                                            <th>Qty</th>
                                            <th>Price</th>
                                            <th colspan="2">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="booking-row">
                                            <td>
                                                <select class="form-control customer text-capitalize" name="customer[]">
                                                    <option value="">Select customer....</option>
                                                    @foreach ($customer as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error customererror"></span>
                                            </td>

                                            <td class="gap-2">
                                                <select class="form-control event" name="event[]">
                                                    <option value="">Select Event....</option>
                                                    @foreach ($event as $item)
                                                        <option value="{{ $item->id }}"
                                                            data-price="{{ $item->price }}">
                                                            {{ $item->title }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error eventerror"></span>
                                            </td>
                                            <td>
                                                <input type="text" name="eventdate[]" class="form-control event_dates"
                                                    placeholder="Select dates">
                                                <span class="text-danger error eventdateerror"></span>
                                            </td>

                                            <td>
                                                <input type="number" name="qty[]" value="1" class="form-control qty"
                                                    placeholder="enter qty">
                                                <span class="text-danger error qtyerror"></span>
                                            </td>
                                            <td>
                                                <input type="number" name="price[]" class="form-control price" readonly>
                                                <span class="text-danger error priceerror"></span>
                                            </td>
                                            <td>
                                                <input type="text" name="total[]" class="form-control total">
                                                <span class="text-danger error totalerror"></span>
                                            </td>
                                            <td>
                                                <i class="mdi mdi-plus-circle-outline " id="add"></i>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                                <div class="row mt-3">
                                    <div class="col-md-1">
                                        <input type="submit" name="submit" class="btn btn-gradient-primary mr-2"
                                            value="Submit">
                                    </div>

                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="row mt-1 mb-4 d-flex justifly-content-space-between">
                        <div class="col-md-7"></div>
                        <div class="col-md-5">
                            <div class="row "><b class="mt-2">Grand Total : </b>
                                <div class="col-md-9"> <input type="text" class="form-control" value="0.00" readonly
                                        id="grandtotal">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://code.jquery.com/jquery-3.7.1.js" crossorigin="anonymous"></script>
        <script src="{{ asset('ajax.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script>
            $(document).ready(function() {

                function validateRow(row) {
                    let isValid = true;

                    if (!row.find('.customer').val()) {
                        row.find('.customererror').text('Customer is required');
                        isValid = false;
                    }

                    if (!row.find('.event').val()) {
                        row.find('.eventerror').text('Event is required');
                        isValid = false;
                    }

                    if (!row.find('.event_dates').val()) {
                        row.find('.eventdateerror').text('Event date is required');
                        isValid = false;
                    }

                    let qty = row.find('.qty').val();
                    if (!qty || qty <= 0) {
                        row.find('.qtyerror').text('Quantity is required');
                        isValid = false;
                    }
                    return isValid;
                }

                $(document).on('input change', '.customer, .event, .event_dates, .qty', function() {

                    let row = $(this).closest('.booking-row');

                    $(this).removeClass('is-invalid');

                    if ($(this).hasClass('customer')) {
                        row.find('.customererror').text('');
                    }

                    if ($(this).hasClass('event')) {
                        row.find('.eventerror').text('');
                    }

                    if ($(this).hasClass('event_dates')) {
                        row.find('.eventdateerror').text('');
                    }

                    if ($(this).hasClass('qty')) {
                        row.find('.qtyerror').text('');
                    }
                });

                initDatePicker();

                function calculateRow(row) {
                    let qty = parseFloat(row.find('.qty').val()) || 0;
                    let price = parseFloat(row.find('.price').val()) || 0;
                    let total = qty * price;

                    row.find('.total').val(total.toFixed(2));

                    calculateGrandTotal();
                }


                function calculateGrandTotal() {
                    let grandtotal = 0;

                    $('.total').each(function() {
                        grandtotal += parseFloat($(this).val()) || 0;
                    });

                    $('#grandtotal').val(grandtotal.toFixed(2));
                }


                $(document).on('input', '.qty, .price', function() {
                    let row = $(this).closest('.booking-row');
                    calculateRow(row);
                });

                $(document).on('change', '.event', function() {
                    let row = $(this).closest('.booking-row');
                    let price = $(this).find(':selected').data('price') || 0;
                    row.find('.price').val(price);
                    calculateRow(row);
                });

                $(document).on('change', '.event', function() {
                    let row = $(this).closest('.booking-row');
                    let price = $(this).find(':selected').data('price') || 0;

                    row.find('.price').val(price);
                    calculateRow(row);
                });

                function initDatePicker() {
                    flatpickr(".event_dates", {
                        mode: "multiple",
                        dateFormat: "Y-m-d",
                        minDate: "today",
                        onChange: function(selectedDates, dateStr, instance) {
                            if (selectedDates.length > 2) {
                                selectedDates.pop();
                                instance.setDate(selectedDates);
                                return;
                            }

                            if (selectedDates.length === 2) {
                                const today = new Date();
                                today.setHours(0, 0, 0, 0);

                                const sortedDates = [...selectedDates].sort((a, b) => a - b);
                                const endDate = sortedDates[1];

                                if (endDate.getTime() === today.getTime()) {
                                    alert("End date cannot be today. Please select a later date.");
                                    selectedDates.splice(selectedDates.indexOf(endDate), 1);
                                    instance.setDate(selectedDates);
                                }
                            }
                        }
                    });
                }
                $(document).on('click', '#add', function() {
                    let lastRow = $('.booking-row').last();
                    if (!validateRow(lastRow)) {
                        return;
                    }
                    $('#table').append(`
                        <tr class="booking-row">
                            <td>
                               <select class="form-control customer text-capitalize" name="customer[]">
                                                <option value="">Select customer....</option>
                                                @foreach ($customer as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                             <span class="text-danger error customererror" ></span>
                            </td>

                            <td>
                                <select class="form-control event" name="event[]">
                                                <option value="">Select Event....</option>
                                                @foreach ($event as $item)
                                                    <option value="{{ $item->id }}" data-price="{{ $item->price }}">
                                                        {{ $item->title }}</option>
                                                @endforeach
                                            </select>
                                                <span class="text-danger error eventerror" ></span>

                            </td>

                            <td>
                                <input type="text" name="eventdate[]" class="form-control event_dates" placeholder="Select dates">
                                                <span class="text-danger error eventdateerror"></span>

                            </td>

                            <td>
                                <input type="number" name="qty[]" class="form-control qty" value="1">
                                  <span class="text-danger error qtyerror" ></span>
                            </td>

                            <td>
                                <input type="number" name="price[]" class="form-control price" readonly>
                                 <span class="text-danger error priceerror" ></span>

                            </td>

                            <td>
                                <input type="text" name="total[]" class="form-control total" readonly>
                            </td>

                            <td>
                                <i class="mdi mdi-minus-circle-outline sub"></i>
                            </td>
                        </tr>
                        `);

                    initDatePicker();
                });

                $(document).on('click', '.sub', function() {
                    $(this).closest('tr').remove();
                    calculateGrandTotal();
                })
                $('#addform').submit(function(e) {
                    e.preventDefault();
                    var Data = $('#addform')[0];
                    var formData = new FormData(Data);

                    console.log(formData);
                    var url = "{{ route('EventsStorePage') }}";
                    $('.error').text('');
                    reusableAjaxCall(url, 'POST', formData, function(response) {
                            console.log(response.message);
                            if (response.status == true) {
                                $('#message').removeClass('d-none').html(response.message)
                                    .fadeIn();
                                setTimeout(function() {
                                    $('#message').addClass('d-none').html('').fadeOut();
                                    window.location.href =
                                        "{{ route('EventsBookViewPage') }}";
                                }, 4000);
                            }
                            $('#addform')[0].reset();
                            $(".error").empty();
                        }, function(error) {
                            if (error.status !== 422) return;
                            let errors = error.responseJSON.errors;
                            $('.error').text('');
                            for (let key in errors) {
                                let [field, index] = key.split('.');
                                $('.booking-row')
                                    .eq(index)
                                    .find('.' + field + 'error')
                                    .text(errors[key][0]);
                            }
                        }


                    );

                });


            });
        </script>
    @endsection
