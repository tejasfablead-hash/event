{{-- @extends('index')

@section('container')
    <div class="main-panel">
        <div class="content-wrapper">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h6 class="page-title pr-5">
                    <div id="message" class="alert alert-success text-center d-none"></div>
                </h6>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Booking</li>
                        <li class="breadcrumb-item active">Update Booking</li>
                    </ol>
                </nav>
            </div>

            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Update Booking</h4>
                        <br>

                        <form id="updatebook">
                            @csrf
                            <input type="hidden" name="id" value="{{ $single->id }}">

                            <!-- EVENT + CUSTOMER -->
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Event</label>
                                        <div class="col-sm-9">
                                            <select class="form-control event" name="event">
                                                <option value="">Select Event...</option>
                                                @foreach ($event as $item)
                                                    <option value="{{ $item->id }}" data-price="{{ $item->price }}"
                                                        {{ $item->id == $single->event ? 'selected' : '' }}>
                                                        {{ $item->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error eventerror"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Customer</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"
                                                value="{{ $single->getcustomer->name }}" readonly>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- QTY + STATUS -->
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Qty</label>
                                        <div class="col-sm-9">
                                            <input type="number" name="qty" class="form-control qty"
                                                value="{{ $single->qty }}" min="1">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Status</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="status">
                                                <option value="pending"
                                                    {{ $single->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="confirmed"
                                                    {{ $single->status == 'confirmed' ? 'selected' : '' }}>Confirmed
                                                </option>
                                                <option value="cancelled"
                                                    {{ $single->status == 'cancelled' ? 'selected' : '' }}>Cancelled
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- START + END DATE -->
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Start Date</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="startdate" value="{{ $single->start_date }}"
                                                class="form-control startdate" placeholder="Select start date">
                                            <span class="text-danger error startdate-error"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">End Date</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="enddate" value="{{ $single->end_date }}"
                                                class="form-control enddate" placeholder="Select end date">
                                            <span class="text-danger error enddate-error"></span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- TOTAL -->
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Price</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="total" id="total" value="{{ $single->total }}" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Grand Total</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="grandtotal" id="grandtotal" value="{{ $single->grandtotal }}" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- SUBMIT -->
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="submit" class="btn btn-gradient-primary" value="Update Booking">
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset('ajax.js') }}"></script>

    <script>
        $(document).ready(function() {

            function calculateTotal() {
                let qty = parseInt($('.qty').val()) || 0;
                let price = $('.event option:selected').data('price') || 0;

                $('#total').val(price);
                $('#grandtotal').val(qty * price);
            }

            $('.qty, .event').on('input change', calculateTotal);
            calculateTotal();
       

            let endPicker;

            flatpickr(".startdate", {
                dateFormat: "Y-m-d",
                minDate: "today",
                onChange: function(selectedDates) {
                    if (selectedDates.length) {
                        let minEnd = new Date(selectedDates[0]);
                        minEnd.setDate(minEnd.getDate());
                        endPicker.set("minDate", minEnd);
                        endPicker.clear();
                    }
                }
            });

            endPicker = flatpickr(".enddate", {
                dateFormat: "Y-m-d",
                minDate: "today"
            });

            $('#updatebook').submit(function(e) {
                e.preventDefault();
                let isValid = true;
                let start = $('.startdate').val();
                let end = $('.enddate').val();
                if (!start) {
                    $('.startdate-error').text('Start date is required');
                    isValid = false;
                }
                if (!end) {
                    $('.enddate-error').text('End date is required');
                    isValid = false;
                }
                if (!isValid) return;

                var data = $('#updatebook')[0];
                var formData = new FormData(data);
                $('.error').text('');
                var url = "{{ route('EventsBooksUpdatePage') }}";
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
                    $('#updatebook')[0].reset();
                    $(".error").empty();
                });
            });

        });
    </script>
@endsection --}}


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

        .bordered-dark {
            border: 1px solid #a39f9f;
            border-radius: 6px;
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
                        <li class="breadcrumb-item active" aria-current="page">Update Event</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Update Booking</h4>
                        <br>

                        <form class="form-sample" id="updateform" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <label for=""> Customer</label>
                                    <input type="text" name="customer" class="form-control customer"
                                        placeholder="Select customer" value="{{ $single->getcustomer->name }}" readonly>
                                    <span class="text-danger error customererror" id="customer_error"></span>
                                    <input type="hidden" name="id" class="form-control id" placeholder="Select id"
                                        value="{{ $single->id }}" readonly>
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
                                    @php
                                        $events = $single->event ?? [];
                                        $dates = $single->start_date ?? [];
                                        $qtys = $single->qty ?? [];
                                        $totals = $single->total ?? [];

                                        $priceTotal = 0;
                                        $grandTotal = 0;
                                    @endphp
                                    <tbody>
                                        @foreach ($events as $key => $val)
                                            @php
                                                $price = $event->where('id', $val)->first()->price ?? 0;
                                                $qty = $qtys[$key] ?? 0;
                                                $rowTotal = $qty * $price;

                                                $priceTotal += $price;
                                                $grandTotal += $rowTotal;
                                            @endphp
                                            <tr class="booking-row">
                                                <td class="gap-2">
                                                    <select class="form-control event border-redius" name="event[]">
                                                        <option value="">Select Event....</option>
                                                        @foreach ($event as $item)
                                                            <option value="{{ $item->id }}"
                                                                data-price="{{ $item->price }}"
                                                                {{ $item->id == $val ? 'selected' : '' }}>
                                                                {{ $item->title }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger error eventerror"></span>
                                                </td>
                                                <td>
                                                    <input type="text" name="eventdate[]"
                                                        class="form-control event_dates" placeholder="Select dates"
                                                        value="{{ $dates[$key] }}">
                                                    <span class="text-danger error eventdateerror"></span>
                                                </td>

                                                <td>
                                                    <input type="number" name="qty[]" class="form-control qty"
                                                        value="{{ $qty }}" placeholder="enter qty">
                                                    <span class="text-danger error qtyerror"></span>
                                                </td>
                                                <td>
                                                    <input type="number" name="price[]" value="{{ $price }}"
                                                        class="form-control price" readonly>
                                                    <span class="text-danger error priceerror"></span>
                                                </td>
                                                <td>
                                                    <input type="text" name="total[]"
                                                        value="{{ number_format($rowTotal) }}" class="form-control total">
                                                    <span class="text-danger error totalerror"></span>
                                                </td>
                                                <td>
                                                    @if ($key == 0)
                                                        <i class="mdi mdi-plus-circle-outline mdi-24px" id="add"></i>
                                                    @else
                                                        <i class="mdi mdi-minus-circle-outline mdi-24px sub"></i>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                                <div class="row mt-2">
                                    <div class="col-md-1">
                                        <input type="submit" name="submit" class="btn btn-gradient-primary mr-2"
                                            value="Update">
                                    </div>

                                </div>
                            </div>
                            <div class="row mt-3 mb-2 justify-content-end">
                                <div class="col-md-5">
                                    <div class="d-flex align-items-center">
                                        <!-- Label -->
                                        <div class="fw-bold me-2" style="width: 30%;">Discount (%)</div>
                                        <!-- Inputs -->
                                        <div class="d-flex gap-2" style="width: 70%;">
                                            <input type="text" class="form-control bordered-dark" id="discount"
                                                placeholder="%" style="width: 30%;">&nbsp;
                                            <input type="text" class="form-control bordered-dark" id="totaldiscount"
                                                placeholder="Amount" style="width: 70%;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-end">
                                <div class="col-md-5">
                                    <div class="d-flex align-items-center">
                                        <!-- Label -->
                                        <div class="fw-bold me-2" style="width: 30%;">Grand Total</div>
                                        <!-- Input -->
                                        <div style="width: 70%;">
                                            <input type="text" name="grandtotal[]" class="form-control"
                                                value="{{ number_format($grandTotal) }}" readonly id="grandtotal">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-end">
                                <div class="col-md-5">
                                    <div class="d-flex align-items-center">
                                        <!-- Label -->
                                        <div class="fw-bold me-2" style="width: 90%;"></div>
                                        <div style="width:20%;">
                                            <button type="button" id="cancel" class="btn btn-sm btn-gradient-dark">
                                                Cancel
                                            </button>
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

            function calculatePriceTotal() {
                let priceTotal = 0;

                $('.price').each(function() {
                    priceTotal += parseFloat($(this).val()) || 0;
                });

                $('#total').val(priceTotal.toFixed(2));
            }

            function calculateGrandTotal() {
                let totalSum = 0;

                $('.total').each(function() {
                    let val = parseFloat($(this).val()) || 0;
                    totalSum += val;
                });

                let discountAmount = parseFloat($('#totaldiscount').val()) || 0;

                let grandTotal = totalSum - discountAmount;
                if (grandTotal < 0) grandTotal = 0;

                $('#grandtotal').val(grandTotal.toFixed(2));
            }

            function calculateDiscountFromPercent() {
                let totalSum = 0;
                $('.total').each(function() {
                    totalSum += parseFloat($(this).val()) || 0;
                });

                let discountPercent = parseFloat($('#discount').val()) || 0;
                let discountAmount = (totalSum * discountPercent) / 100;

                $('#totaldiscount').val(discountAmount.toFixed(2));
                calculateGrandTotal();
            }

            function calculateDiscountFromAmount() {
                let totalSum = 0;
                $('.total').each(function() {
                    totalSum += parseFloat($(this).val()) || 0;
                });

                let discountAmount = parseFloat($('#totaldiscount').val()) || 0;
                let discountPercent = totalSum > 0 ? (discountAmount / totalSum) * 100 : 0;

                $('#discount').val(discountPercent.toFixed(2));
                calculateGrandTotal();
            }

            $(document).on('input', '#discount', function() {
                calculateDiscountFromPercent();
            });

            $(document).on('input', '#totaldiscount', function() {
                calculateDiscountFromAmount();
            });

            $(document).on('input', '.qty, .price', function() {
                let row = $(this).closest('.booking-row');
                calculateRow(row);
            });

            function calculateRow(row) {
                let qty = parseFloat(row.find('.qty').val()) || 0;
                let price = parseFloat(row.find('.price').val()) || 0;
                let total = qty * price;

                row.find('.total').val(total.toFixed(2));

                calculateDiscountFromPercent();
            }

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

                            const sortedDates = selectedDates.sort((a, b) => a - b);
                            const startDate = sortedDates[0];
                            const endDate = sortedDates[1];

                            if (endDate.getTime() === today.getTime()) {
                                alert("End date must be after today.");
                                instance.setDate([startDate]);
                                return;
                            }

                            if (endDate <= startDate) {
                                alert("End date must be after start date.");
                                instance.setDate([startDate]);
                                return;
                            }

                            instance.setDate(sortedDates);
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
            $('.booking-row').each(function() {
                calculateRow($(this));
            });

            $(document).on('click', '#cancel', function() {

                $('#discount').val(0);
                $('#totaldiscount').val(0);

                let totalRowSum = 0;
                $('.total').each(function() {
                    totalRowSum += parseFloat($(this).val()) || 0;
                });

                $('#grandtotal').val(totalRowSum.toFixed(2));
            });
            $('#updateform').submit(function(e) {
                e.preventDefault();
                var Data = $('#updateform')[0];
                var formData = new FormData(Data);
                console.log(formData);
                var url = "{{ route('EventsBooksUpdatePage') }}";
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
                    $('#updateform')[0].reset();
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
