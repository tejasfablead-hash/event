@extends('index')
@section('container')
    <style>
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
                                    <thead class="thead-dark  bordered-dark">
                                        <tr>
                                            <th>Event</th>
                                            <th>Select Date</th>
                                            <th>Qty</th>
                                            <th>Price</th>
                                            <th colspan="2">Main Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bordered-dark">
                                        <tr class="booking-row bordered-dark">

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
                            <div class="row mt-3 mb-2 justify-content-end">
                                <div class="col-md-5">
                                    <div class="d-flex align-items-center">
                                        <!-- Label -->
                                        <div class="fw-bold me-2" style="width: 30%;">Discount (%)</div>
                                        <!-- Inputs -->
                                        <div class="d-flex gap-2" style="width: 70%;">
                                            <input type="text" class="form-control bordered-dark" name="discount"
                                                id="discount" placeholder="%" style="width: 30%;">&nbsp;
                                            <input type="text" class="form-control bordered-dark" name="totaldiscount"
                                                id="totaldiscount" placeholder="Amount" style="width: 70%;">
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
                                            <input type="text" name="grandtotal[]"
                                                class="form-control bordered-dark fw-bold" id="grandtotal" value="0.00"
                                                readonly>
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


            function calculateFinalGrandTotal() {
                let total = parseFloat($('#total').val()) || 0;
                let discountAmount = parseFloat($('#totaldiscount').val()) || 0;

                let grandTotal = total - discountAmount;
                if (grandTotal < 0) grandTotal = 0;

                $('#grandtotal').val(grandTotal.toFixed(2));
            }
            $(document).on('input', '#discount', function() {
                calculateDiscountFromPercent();
            });
            $(document).on('input', '#totaldiscount', function() {
                calculateDiscountFromAmount();
            });

            function calculateRow(row) {
                let qty = parseFloat(row.find('.qty').val()) || 0;
                let price = parseFloat(row.find('.price').val()) || 0;
                let total = qty * price;

                row.find('.total').val(total.toFixed(2));

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
                let totalRowSum = 0;

                $('.total').each(function() {
                    totalRowSum += parseFloat($(this).val()) || 0;
                });

                let discountAmount = parseFloat($('#totaldiscount').val()) || 0;

                let grandTotal = totalRowSum - discountAmount;
                if (grandTotal < 0) grandTotal = 0;

                $('#grandtotal').val(grandTotal.toFixed(2));
            }

            function calculateDiscountFromPercent() {
                let totalRowSum = 0;
                $('.total').each(function() {
                    totalRowSum += parseFloat($(this).val()) || 0;
                });

                let discountPercent = parseFloat($('#discount').val()) || 0;
                let discountAmount = (totalRowSum * discountPercent) / 100;

                $('#totaldiscount').val(discountAmount.toFixed(2));
                calculateGrandTotal();
            }

            function calculateDiscountFromAmount() {
                let totalRowSum = 0;
                $('.total').each(function() {
                    totalRowSum += parseFloat($(this).val()) || 0;
                });

                let discountAmount = parseFloat($('#totaldiscount').val()) || 0;
                let discountPercent = totalRowSum > 0 ? (discountAmount / totalRowSum) * 100 : 0;

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

            $(document).on('click', '#cancel', function() {

                $('#discount').val(0);
                $('#totaldiscount').val(0);

                let totalRowSum = 0;
                $('.total').each(function() {
                    totalRowSum += parseFloat($(this).val()) || 0;
                });

                $('#grandtotal').val(totalRowSum.toFixed(2));
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
