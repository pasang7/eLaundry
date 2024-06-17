@extends('layouts.dashboard')

@section('content')

@include('layouts.alerts')

<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-success">

        <!-- /.card-header -->
        <!-- form start -->
        <form method="POST" action="{{route('admin.sales.store')}}">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Estimated Delivery Date</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control float-right" id="date" name="estimated_delivery_date">
                    </div>
                    <!-- /.input group -->
                </div>
                
                <div class="form-group">
                    <label for="receipt_no">Receipt Number</label>
                    <input name="receipt_no" type="number" class="form-control" id="receipt_no" value="{{$new_receipt_number}}" disabled>
                </div>
                <div class="form-group">
                    <label for="receipt_no">Search Customer</label>
                    <div class="input-group mb-3">
                        <input type="text" id="search-box" placeholder="Search Customer Phone" name="search_key" class="form-control" required autocomplete="off" />
                        <div class="input-group-append">
                            <span class="input-group-text" data-toggle="modal" data-target="#create_customer"><i class="fas fa-plus"></i></span>
                        </div>
                    </div>
                    <div id="suggesstion-box"></div>
                </div>

                <!-- Repeater Content -->

                <!-- Repeater Items -->

                <div class="orderlist">
                    <div class="repeater-heading">
                        <button data-repeater-create type="button" class="btn btn-primary pt-2 pull-right repeater-add-btn m-l-15">
                            <i class="fas fa-plus"></i> Add Items
                        </button>
                    </div>
                    <div data-repeater-list="arrayName" class="repeateList">
                        <div data-repeater-item>
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group repeatItems">
                                        <label for="product_name">Select Product</label>
                                        <select class="form-control" name="product_id" required onchange="productDetail(this.value)">
                                            <option disabled selected>Select Product</option>
                                            @foreach ($products as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="rate">Rate</label>
                                        <input name="rate" type="number" class="form-control sales_rate" id="rate" disabled>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="quantity">Quantity</label>
                                        <input name="quantity" type="text" class="form-control" id="quantity" onchange="itemTotal(this.value)">
                                    </div>
                                </div>
                                <div class=" col-3">
                                    <div class="form-group">
                                        <label for="item_total">Total</label>
                                        <input name="item_total" type="number" class="form-control prc" id="item_total" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="pull-right repeater-remove-btn">
                                    <button data-repeater-delete type="button" class="btn btn-danger remove-btn">
                                        Remove
                                    </button>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                <!-- Repeater End -->

                <div class="row">
                    <div class="col-9">
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="item_total">Total Payable</label>
                            <input type="text" class="form-control" id="total_payable" value="0" disabled>
                        </div>

                    </div>
                </div>
                <hr>
                <!-- Payment Radio-->
                <div class="form-group">
                    <label for="item_total">Payment Option</label>
                    <div class="row">
                        <div class="col-3">
                            <label class="radio-inline">
                                <input type="radio" name="paymentOption" onclick="cashOption()" value="cashFull">Cash(Full)
                            </label>
                        </div>
                        <div class="col-3">
                            <label class="radio-inline">
                                <input type="radio" name="paymentOption" onclick="showBankOption()" value="bankFull">Bank/E-Payment(Full)
                            </label>
                        </div>
                        <div class="col-3">
                            <label class="radio-inline">
                                <input type="radio" name="paymentOption" onclick="partialOption() " value="partial">Partial
                            </label>
                        </div>
                        <div class="col-3">
                            <label class="radio-inline">
                                <input type="radio" name="paymentOption" value="creditFull">Credit(Full)
                            </label>
                        </div>
                    </div>
                </div>
                <hr>
                <!-- Payment Radio Ends -->
                <div id="radio_and_form">
                    <!-- Bank Form -->
                    <div class="row" id="bank_form" style="display: none">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="bank_name">Bank Name</label>
                                <input type="text" class="form-control" id="bank_name" name="fullBankName">
                            </div>
                            <div class="form-group">
                                <label for="bank_amount">Amount</label>
                                <input type="number" class="form-control" id="bank_amount" disabled>
                            </div>
                            <div class="form-group">
                                <label for="bank_code">Code</label>
                                <input type="text" class="form-control" id="bank_code" name="fullBankCode">
                            </div>
                        </div>
                        <div class="col-6">

                        </div>
                    </div>
                    <!-- Bank Form Ends -->

                    <!-- Partial Payment Options Bank or Cash RADIO -->
                    <div class="form-group" id="partial_option" style="display: none">
                        <div class="row">
                            <div class="col-3">
                            </div>
                            <div class="col-3">
                                <label class="radio-inline">
                                    <input type="radio" name="partialPaymentOption" value="partialCash" onclick="cashPartialOption()">Cash
                                </label>
                            </div>
                            <div class="col-3">
                            </div>
                            <div class="col-3">
                                <label class="radio-inline">
                                    <input type="radio" name="partialPaymentOption" value="partialBank" onclick="bankPartialOption()">Bank/E-Payment
                                </label>
                            </div>


                        </div>
                    </div>
                    <!-- Partial Payment Options Bank or Cash Ends RADIO -->

                    <!-- CASH PARTIAL OPTION -->
                    <div class="row" id="cash_partial_form" style="display: none">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="totalAmount">Total Payable</label>
                                <input type="text" class="form-control" id="partialCashPayable" disabled>
                            </div>
                            <div class="form-group">
                                <label for="partial_cash_amount">Amount Paid</label>
                                <input name="partialCashPaid" type="number" class="form-control" id="partial_paid_cash_amount" onchange="cashPartialCalculation()">
                            </div>
                            <div class="form-group">
                                <label for="remaining_amount">Remaining Amount</label>
                                <input type="text" class="form-control" id="remaining_cash_amount" disabled>
                            </div>
                        </div>
                        <div class="col-6">

                        </div>
                    </div>
                    <!-- CASH PARTIAL OPTION ENDS -->
                    <!--BANK PARTIAL OPTION -->
                    <div class="row" id="bank_partial_form" style="display: none">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="totalAmount">Bank Name</label>
                                <input name="partialBankName" type="text" class="form-control" id="totalAmount">
                            </div>
                            <div class="form-group">
                                <label for="totalAmount">Bank Code</label>
                                <input name="partialBankCode" type="text" class="form-control" id="totalAmount">
                            </div>
                            <div class="form-group">
                                <label for="totalAmount">Total Payable</label>
                                <input type="text" class="form-control" id="partialBankPayable" disabled>
                            </div>
                            <div class="form-group">
                                <label for="partial_cash_amount">Amount Paid</label>
                                <input  name="partialBankPaid" type="number" class="form-control" id="partial_bank_amount" onchange="bankPartialCalculation()">
                            </div>
                            <div class="form-group">
                                <label for="remaining_amount">Remaining Amount</label>
                                <input type="text" class="form-control" id="remaining_bank_amount" disabled>
                            </div>
                        </div>
                        <div class="col-6">

                        </div>
                    </div>
                    <!-- BANK PARTIAL OPTION ENDS -->
                </div>
            </div> <!-- WHITE CARD BODY ENDS HERE -->

            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Add</button>
            </div>

        </form>
        <!-- Form Ends -->
    </div>
    <!-- /.card -->
</div>


<!-- Create Customer Modal -->


<div class="modal fade" id="create_customer">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create Customer:

                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Content Goes here -->
                <form action="{{ route('admin.customer.store.modal') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Customer Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter customer name" value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Phone Number</label>
                            <input type="text" name="phone_number" class="form-control" id="name" placeholder="Enter phone number" value="{{ old('phone_number') }}">
                        </div>
                        <div class="form-group">
                            <label for="pan">PAN Number</label>
                            <input type="text" name="pan" class="form-control" id="pan" placeholder="Personal Account Number" value="{{ old('pan') }}">
                        </div>
                        <div class="form-group">
                            <label>Additional Information</label>
                            <textarea class="form-control" rows="3" placeholder="Preference ,Instructions ..." name="other_details">{{ old('other_details') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="opening_balance">Opening Balance</label>
                            <input type="number" name="opening_balance" class="form-control" id="opening_balance" placeholder="Opening Balance" value="{{ old('opening_balance') }}">
                        </div>
                    </div>

                    <button class="btn btn-success" type="submit">Add</button>
                </form>


                <!-- Content Ends here -->
            </div>

        </div>

    </div>

</div>
<!-- Create Customer Modal Ends -->
@endsection
