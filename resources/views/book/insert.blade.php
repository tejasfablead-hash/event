@extends('index')
@section('container')
    <style>
        .bordered-dark {
            border: 1px solid #a39f9f !important;
            border-radius: 6px;
        }

        .tbody-border td,
        th {
            border: 1px solid #b3afaf !important;
        }

        .border {
            border: 1px solid #b3afaf !important;
            border-radius: 6px;
            outline: none;
            transition: 0.3s;
        }

        .loader-overlay {
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, 0.85);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loader-box {
            text-align: center;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #ddd;
            border-top: 4px solid #4b49ac;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
            margin: 0 auto 10px;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
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
                                    <select class="form-control  customer text-capitalize border border-redius"
                                        name="customer">
                                        <option value="">Select customer....</option>
                                        @foreach ($customer as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger error customererror" id="customer_error"></small>
                                </div>
                            </div>
                            <br>

                            <div class="row ">
                                <table id="table"
                                    class="table  tbody-border
                            table-bordered rounded">
                                    <thead class="thead-dark tbody-border bordered-dark">
                                        <tr>
                                            <th>Event</th>
                                            <th>Select Date</th>
                                            <th>Qty</th>
                                            <th>Price</th>
                                            <th colspan="2">Main Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bordered-dark tbody-border">
                                        <tr class="booking-row bordered-dark">

                                            <td class="gap-2">
                                                <select class="form-control event border" name="event[]">
                                                    <option value="">Select Event....</option>
                                                    @foreach ($event as $item)
                                                        <option value="{{ $item->id }}"
                                                            data-price="{{ $item->price }}">
                                                            {{ $item->title }}</option>
                                                    @endforeach
                                                </select>
                                                <small class="text-danger error eventerror"></small>
                                            </td>
                                            <td>
                                                <input type="text" name="eventdate[]"
                                                    class="form-control border  event_dates" placeholder="Select dates">
                                                <small class="text-danger error eventdateerror"></small>
                                            </td>

                                            <td>
                                                <input type="number" name="qty[]" value="1"
                                                    class="form-control qty border" placeholder="enter qty">
                                                <small class="text-danger error qtyerror"></small>
                                            </td>
                                            <td>
                                                <input type="number" name="price[]" class="form-control price border"
                                                    readonly>
                                                <small class="text-danger error priceerror"></small>
                                            </td>
                                            <td>
                                                <input type="text" name="total[]" class="form-control total border">
                                                <small class="text-danger error totalerror"></small>
                                            </td>
                                            <td>
                                                <i class="mdi mdi-plus-circle-outline mdi-24px" id="add"></i>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>

                            </div>
                            <div class="row mt-3 mb-2 justify-content-end">
                                <div class="col-md-5">
                                    <div class="d-flex align-items-center">
                                        <!-- Label -->
                                        <div class="fw-bold me-2" style="width: 30%;">Discount (%)</div>
                                        <!-- Inputs -->
                                        <div class="d-flex gap-2" style="width: 70%;">
                                            <input type="text" class="form-control bordered-dark " name="discount"
                                                id="discount" placeholder="%" style="width: 30%;">&nbsp;&nbsp;
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
                                                class="form-control bordered-dark fw-bold border" id="grandtotal"
                                                value="0.00" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <!-- PAY BUTTON -->

                            <div class="row justify-content-end">
                                <div class="col-md-5 text-end">

                                    <button type="button" id="cancel" class="btn btn-sm btn-gradient-dark ms-2">
                                        Cancel
                                    </button>
                                    <button type="button" class="btn btn-gradient-primary btn-sm" id="openPaymentModal">
                                        Pay Now
                                    </button>
                                    <button type="button" class="btn btn-gradient-primary btn-sm" id="openPaypalModal">
                                        PayPal
                                    </button>
                                </div>
                            </div>

                            <!-- Stripe Payment Modal -->
                            <div class="modal fade" id="stripeModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-md">
                                    <div class="modal-content stripe-modal">

                                        <!-- Header -->
                                        <div class="modal-header stripe-header">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="mdi mdi-credit-card-outline fs-4"></i>
                                                <h5 class="modal-title fw-semibold mb-0">Secure Payment</h5>
                                            </div>
                                            <button type="button" class="btn-close border-0"
                                                data-bs-dismiss="modal">x</button>
                                        </div>

                                        <div class="modal-body text-capitalize">
                                            <div id="payment-success" class="alert alert-success text-center d-none ">
                                                Payment completed successfully
                                            </div>
                                            <div class="loader-overlay d-none" id="paymentLoader">
                                                <div class="loader-box">
                                                    <div class="spinner"></div>
                                                    <p>Processing payment...</p>
                                                </div>
                                            </div>


                                            <div class="payment-summary mb-3">
                                                <div class="d-flex justify-content-between">
                                                    <span>Customer : </span>
                                                    <strong id="modalCustomerName">-</strong>
                                                </div><br>
                                                <div class="d-flex justify-content-between mt-1">
                                                    <span>Total : </span>
                                                    <strong class="">₹ <span id="modalAmount">0.00</span></strong>
                                                </div>

                                            </div>

                                            <label class="form-label fw-semibold">Card details : </label>
                                            <div id="card-element" class="stripe-card-input "></div>
                                            <small id="card-errors" class="text-danger mt-2 d-block"></small>

                                            <div class="secure-note mt-3">
                                                <i class="mdi mdi-lock-outline"></i>
                                                Secured by Stripe • 256-bit encryption
                                            </div>
                                        </div>

                                        <div class="modal-footer stripe-footer">

                                            <button type="button" class="btn btn-gradient-dark ms-2"
                                                data-bs-dismiss="modal">
                                                Cancel
                                            </button>
                                            <button type="button" class="btn btn-gradient-primary px-4"
                                                id="confirmPayBtn">
                                                Confirm Pay <span id="payBtnAmount"></span>
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- PayPal Payment Modal -->
                            <div class="modal fade" id="paypalModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-md">
                                    <div class="modal-content">

                                        <!-- Header -->
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-semibold">
                                                <i class="mdi mdi-paypal"></i> PayPal Payment
                                            </h5>
                                            <button type="button" class="btn-close border-0"
                                                data-bs-dismiss="modal">x</button>
                                        </div>

                                        <!-- Body -->
                                        <div class="modal-body text-capitalize">

                                            <div class="payment-summary mb-3">
                                                <div class="d-flex justify-content-between">
                                                    <span>Customer :</span>
                                                    <strong id="paypalCustomerName">-</strong>
                                                </div>
                                                <br>
                                                <div class="d-flex justify-content-between">
                                                    <span>Total :</span>
                                                    <strong> <span id="paypalAmount">0.00</span></strong>
                                                </div>
                                            </div>

                                            <hr>

                                            <div id="paypal-button-container"></div>
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
    <script src="https://js.stripe.com/v3/"></script>
    <script
        src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.sandbox.client_id') }}&currency={{ config('services.paypal.currency') }}">
    </script>


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
                        <tr class="booking-row tbody-border">
                            <td>
                                <select class="form-control event" name="event[]">
                                                <option value="">Select Event....</option>
                                                @foreach ($event as $item)
                                                    <option value="{{ $item->id }}" data-price="{{ $item->price }}">
                                                        {{ $item->title }}</option>
                                                @endforeach
                                            </select>
                                                <small class="text-danger error eventerror" ></small>

                            </td>

                            <td>
                                <input type="text" name="eventdate[]" class="form-control event_dates" placeholder="Select dates">
                                                <small class="text-danger error eventdateerror"></small>

                            </td>

                            <td>
                                <input type="number" name="qty[]" class="form-control qty" value="1">
                                  <small class="text-danger error qtyerror" ></small>
                            </td>

                            <td>
                                <input type="number" name="price[]" class="form-control price" readonly>
                                 <small class="text-danger error priceerror" ></small>

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


            let loaderTimeout = null;

            function showPaymentLoader() {
                $('#paymentLoader').removeClass('d-none');
                $('#confirmPayBtn').prop('disabled', true);
                $('#card-errors').text('');
                loaderTimeout = setTimeout(function() {
                    hidePaymentLoader();
                    $('#card-errors').text('Payment taking too long. Please try again.');
                    paymentProcessing = false;
                }, 15000);
            }

            function hidePaymentLoader() {
                $('#paymentLoader').addClass('d-none');
                $('#confirmPayBtn').prop('disabled', false);
                if (loaderTimeout) {
                    clearTimeout(loaderTimeout);
                    loaderTimeout = null;
                }
            }


            $('#openPaymentModal').click(function() {

                let amount = $('#grandtotal').val();
                let customerId = $('.customer').val();
                let event = $('.event').val();
                let eventdate = $('.event_dates').val();
                let customerName = $('.customer option:selected').text();
                $('.customererror, .eventerror, .eventdateerror, .amounterror').text('');

                if (!customerId) {
                    $('.customererror').text('Customer is required');
                    return;
                }
                if (!event) {
                    $('.eventerror').text('Event is required');
                    return;

                }
                if (!eventdate) {
                    $('.eventdateerror').text('Eventdate is required');
                    return;

                }
                if (!amount || amount <= 0) {
                    $('.amountrerror').text('Amount is required');
                    return;
                }


                $('#modalAmount').text(amount);
                $('#modalCustomerName').text(customerName);

                $('#stripeModal').modal('show');
            });

            let paymentProcessing = false;
            const stripe = Stripe("{{ config('services.stripe.key') }}");
            const elements = stripe.elements();
            const card = elements.create('card');
            card.mount('#card-element');

            $('#confirmPayBtn').click(async function() {
                if (paymentProcessing) return;
                paymentProcessing = true;
                showPaymentLoader();
                const {
                    token,
                    error
                } = await stripe.createToken(card);

                if (error) {
                    $('#card-errors').text(error.message);
                    paymentProcessing = false;
                    return;
                }
                let formData = new FormData($('#addform')[0]);
                formData.append('stripeToken', token.id);
                formData.append('amount', $('#grandtotal').val());
                var url = "{{ route('StripePayment') }}";
                reusableAjaxCall(url, 'POST', formData,

                    function(response) {
                        hidePaymentLoader();
                        if (response.status == true) {
                            $('#card-element').hide();
                            $('#confirmPayBtn').hide();
                            $('#card-errors').hide();
                            $('#payment-success').removeClass('d-none');
                            $('#addform')[0].reset();
                            $(".error").empty();
                            setTimeout(function() {
                                $('#stripeModal').modal('hide');
                                window.location.href =
                                    "{{ route('EventsBookViewPage') }}";
                            }, 2000);
                        }
                    },
                    function(error) {
                        hidePaymentLoader();
                        paymentProcessing = false;
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



            $('#openPaypalModal').click(function() {
                let customerId = $('.customer').val();
                let amount = $('#grandtotal').val();
                let event = $('.event').val();
                let eventdate = $('.event_dates').val();
                let customerName = $('.customer option:selected').text();
                $('.customererror, .eventerror, .eventdateerror, .amounterror').text('');
                if (!customerId) {
                    $('.customererror').text('Customer is required');
                    return;
                }
                if (!event) {
                    $('.eventerror').text('Event is required');
                    return;

                }
                if (!eventdate) {
                    $('.eventdateerror').text('Eventdate is required');
                    return;

                }
                if (!amount || amount <= 0) {
                    $('.amountrerror').text('Amount is required');
                    return;
                }

                $('#paypalAmount').text(amount);
                $('#paypalCustomerName').text(customerName);

                $('#paypalModal').modal('show');

                setTimeout(() => {
                    renderPaypalButtons(amount, customerId);
                }, 300);
            });

            function renderPaypalButtons(amount, customerId) {

                $('#paypal-button-container').html('');

                paypal.Buttons({

                    createOrder: function(data, actions) {
                        return actions.order.create({
                            purchase_units: [{
                                amount: {
                                    value: amount
                                }
                            }]
                        });
                    },
                    onApprove: function(data, actions) {
                        return actions.order.capture().then(function(details) {
                            let formData = new FormData($('#addform')[0]);
                            formData.append('orderID', data.orderID);
                            formData.append('customer_id', customerId);
                            formData.append('grand_total', amount);
                            $.ajax({
                                url: "{{ route('paypal.success') }}",
                                type: "POST",
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(response) {
                                    console.log('message',response);
                                    if (response.status == true) {
                                        $('#paypalModal').modal('hide');
                                        alert('PayPal Payment Successful');
                                        window.location.href =
                                            "{{ route('EventsBookViewPage') }}";
                                    }
                                },
                                error: function(err) {
                                    console.error(err);
                                    alert(
                                        'Something went wrong while saving payment.'
                                    );
                                }
                            });

                        });
                    },

                    onError: function(err) {
                        console.error(err);
                        alert('PayPal error occurred');
                    }

                }).render('#paypal-button-container');
            }

        });
    </script>
@endsection
