@extends('index')
@section('container')
    <style>
        .gst-toggle {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 46px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            inset: 0;
            background-color: #d1d5db;
            transition: 0.3s;
            border-radius: 30px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: 0.3s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #4f46e5;
           
        }

        input:checked+.slider:before {
            transform: translateX(22px);
        }

        .gst-label {
            font-weight: 600;
            font-size: 14px;
        }

        .table,
        tr {
            border: 1px solid black;
            border-radius: 10px;
        }
    </style>
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h6 class="page-title pr-5">
                    <div id="message" class="alert alert-success text-center d-none" role="alert"></div>
                </h6>
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
                                <div class="col-md-4">
                                    <label for=""> Select Customer</label>
                                    <select class="form-control  customer text-capitalize border-redius" name="customer">
                                        <option value="">Select customer....</option>
                                        @foreach ($customer as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error customererror" id="customer_error"></span>
                                </div>
                            </div>
                            <br>

                            <div class="row ">
                                <table id="table" class="table  
                            table-bordered rounded">
                                    <thead class="thead-dark  ">
                                        <tr>
                                            <th>Event</th>
                                            <th>Select Date</th>
                                            <th>Qty</th>
                                            <th>Price</th>
                                            <th colspan="2">Main Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="booking-row">

                                            <td class="gap-2">
                                                <select class="form-control event border-redius" name="event[]">
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
                                                <i class="mdi mdi-plus-circle-outline mdi-24px" id="add"></i>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                                <div class="row mt-2">
                                    <div class="col-md-1">
                                        <input type="submit" name="submit" class="btn btn-gradient-primary mr-2"
                                            value="Submit">
                                    </div>

                                </div>
                            </div>

                            <div class="row mt-1 mb-1 d-flex justifly-content-space-between">
                                <div class="col-md-7"></div>
                                <div class="col-md-5">
                                    <div class="row "><b class="mt-2"> Total :
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </b>
                                        <div class="col-md-9"> <input type="text" class="form-control" value="0.00"
                                                readonly id="total">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3 mb-1 d-flex justifly-content-space-between">
                                <div class="col-md-7"></div>
                                <div class="col-md-5">
                                    <div class="row "><b class="mt-2">Grand Total : </b>
                                        <div class="col-md-9"> <input type="text" name="grandtotal[]"
                                                class="form-control" value="0.00" readonly id="grandtotal">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
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

                calculatePriceTotal();
                calculateGrandTotal();

            }

            function calculatePriceTotal() {
                let priceTotal = 0;

                $('.price').each(function() {
                    priceTotal += parseFloat($(this).val()) || 0;
                });

                $('#total').val(priceTotal.toFixed(2));
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


            function initDatePicker() {
                flatpickr(".event_dates", {
                    mode: "range",
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
                                <i class="mdi mdi-minus-circle-outline mdi-24px sub"></i>
                            </td>
                        </tr>
                        `);

                initDatePicker();
            });

            $(document).on('click', '.sub', function() {
                $(this).closest('tr').remove();
                calculatePriceTotal();
                calculateGrandTotal();
            });

            $('#addform').submit(function(e) {
                e.preventDefault();
                var Data = $('#addform')[0];
                var formData = new FormData(Data);
                console.log(formData);
                var url = "{{ route('EventsStorePage') }}";
                $('.error').text('');
                $('.customererror').text('');
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
                    $('.customererror').text('');
                    for (let key in errors) {
                        let [field, index] = key.split('.');
                        $('.booking-row')
                            .eq(index)
                            .find('.' + field + 'error')
                            .text(errors[key][0]);
                    }
                });
            });
        });
    </script>
@endsection
