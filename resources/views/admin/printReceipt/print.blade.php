@extends('layouts.dashboard')

@section('content')
@include('layouts.alerts')

@php
use App\Models\Product;
use App\Models\Customer;
@endphp
<!-- this row will not appear when printing -->
<div class="row no-print">
<div class="col-12">
        <button class="btn btn-danger" onclick="window.print()"><i class="fas fa-print"></i> Print</button>&nbsp;
        <a href="https://fastlaundry.pocketstudionepal.com/" class="btn btn-info"><i class="fas fa-dash"></i> Go to Dashboard</a>
    </div>
</div>

<hr>
<div class="invoice p-3 mb-3">
    <!-- title row -->
    <div class="row">
        <div class="col-12">
            <h4>
                <i class="fas fa-shopping-basket"></i> {{$settings->name}}
                <small class="float-right">{{date('Y-m-d')}}</small>
            </h4>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            From
            <address>
                <strong>{{$settings->name}}</strong><br>
                {{$settings->address}}<br>
                Phone: {{$settings->phone}}<br>
                Email: {{$settings->email}}
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            To
            <address>
                <strong>{{Customer::where('id',$saleEntry->first()->customer_id)->first()->name}}</strong><br>

                Phone:{{Customer::where('id',$saleEntry->first()->customer_id)->first()->phone_number}} <br>
                Delivery Date: {{$saleEntry->first()->estimated_delivery_date}}

            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <b>Receipt #{{$saleEntry->first()->receipt_number}}</b><br>
            <br>
            @if($saleEntry->first()->is_full_cash)
            <b>Payment Type:</b> Full Cash <br>
            @elseif($saleEntry->first()->is_full_bank)
            <b>Payment Type:</b> Full Bank <br>
            @elseif($saleEntry->first()->is_full_credit)
            <b>Payment Type:</b> Full Credit <br>
            @elseif($saleEntry->first()->is_partial_cash)
            <b>Payment Type:</b> Partial Cash <br>
            @elseif($saleEntry->first()->is_partial_bank)
            <b>Payment Type:</b> Partial Bank <br>
            @endif
            <b class="text-danger">Paid Amount: {{$totalPaid}}</b>

        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Rate</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($saleEntry as $sale)
                    <tr>

                        <td>{{$loop->iteration}}</td>
                        <td>{{Product::where('id',$sale->product_id)->first()->name}}</td>
                        <td>{{$sale->product_quantity}}</td>

                        <td>{{$sale->product_rate}}</td>
                        <td class="itemTotal">{{$sale->product_rate*$sale->product_quantity}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <th colspan="4">Total</th>
                    @php
                    $total=0;
                    foreach($saleEntry as $entry){
                    $total+=$entry->product_rate*$entry->product_quantity;
                    }
                    @endphp
                    <th>{{$total}}</th>
                </tfoot>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->



</div>
<div class="invoice p-3 mb-3">
    <!-- title row -->
    <div class="row">
        <div class="col-12">
            <h4>
                <i class="fas fa-shopping-basket"></i> {{$settings->name}}
                <small class="float-right">{{date('Y-m-d')}}</small>
            </h4>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            From
            <address>
                <strong>{{$settings->name}}</strong><br>
                {{$settings->address}}<br>

                Phone: {{$settings->phone}}<br>
                Email: {{$settings->email}}
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            To
            <address>
                <strong>COUNTER</strong><br><br>
                Delivery Date: {{$saleEntry->first()->estimated_delivery_date}}

            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <b>Receipt #{{$saleEntry->first()->receipt_number}}</b><br>
            <br>
            @if($saleEntry->first()->is_full_cash)
            <b>Payment Type:</b> Full Cash <br>
            @elseif($saleEntry->first()->is_full_bank)
            <b>Payment Type:</b> Full Bank <br>
            @elseif($saleEntry->first()->is_full_credit)
            <b>Payment Type:</b> Full Credit <br>
            @elseif($saleEntry->first()->is_partial_cash)
            <b>Payment Type:</b> Partial Cash <br>
            @elseif($saleEntry->first()->is_partial_bank)
            <b>Payment Type:</b> Partial Bank <br>
            @endif
              <b class="text-danger">Paid Amount: {{$totalPaid}}</b>

        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Rate</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($saleEntry as $sale)
                    <tr>

                        <td>{{$loop->iteration}}</td>
                        <td>{{Product::where('id',$sale->product_id)->first()->name}}</td>
                        <td>{{$sale->product_quantity}}</td>

                        <td>{{$sale->product_rate}}</td>
                        <td class="itemTotal">{{$sale->product_rate*$sale->product_quantity}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <th colspan="4">Total</th>
                    @php
                    $total=0;
                    foreach($saleEntry as $entry){
                    $total+=$entry->product_rate*$entry->product_quantity;
                    }
                    @endphp
                    <th>{{$total}}</th>
                </tfoot>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
<div class="invoice p-3 mb-3">
    <!-- title row -->
    <div class="row">
        <div class="col-12">
            <h4>
                <i class="fas fa-shopping-basket"></i> {{$settings->name}}
                <small class="float-right">{{date('Y-m-d')}}</small>
            </h4>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            From
            <address>
                <strong>{{$settings->name}}</strong><br>
                {{$settings->address}}<br>

                Phone: {{$settings->phone}}<br>
                Email: {{$settings->email}}
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            To
            <address>
                <strong>WASHER</strong><br>
                Delivery Date: {{$saleEntry->first()->estimated_delivery_date}}

                <br>

            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <b>Receipt #{{$saleEntry->first()->receipt_number}}</b><br>
            <br>
            @if($saleEntry->first()->is_full_cash)
            <b>Payment Type:</b> Full Cash <br>
            @elseif($saleEntry->first()->is_full_bank)
            <b>Payment Type:</b> Full Bank <br>
            @elseif($saleEntry->first()->is_full_credit)
            <b>Payment Type:</b> Full Credit <br>
            @elseif($saleEntry->first()->is_partial_cash)
            <b>Payment Type:</b> Partial Cash <br>
            @elseif($saleEntry->first()->is_partial_bank)
            <b>Payment Type:</b> Partial Bank <br>
            @endif
            <b class="text-danger">Paid Amount: {{$totalPaid}}</b>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Rate</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($saleEntry as $sale)
                    <tr>

                        <td>{{$loop->iteration}}</td>
                        <td>{{Product::where('id',$sale->product_id)->first()->name}}</td>
                        <td>{{$sale->product_quantity}}</td>

                        <td>{{$sale->product_rate}}</td>
                        <td class="itemTotal">{{$sale->product_rate*$sale->product_quantity}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <th colspan="4">Total</th>
                    @php
                    $total=0;
                    foreach($saleEntry as $entry){
                    $total+=$entry->product_rate*$entry->product_quantity;
                    }
                    @endphp
                    <th>{{$total}}</th>
                </tfoot>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    @endsection
