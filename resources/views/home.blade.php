@extends('layouts.dashboard')
@php
use App\Models\Customer;
use App\Models\Product;
use App\Models\SalesEntry;
use App\Models\Payable;
@endphp

@section('content')
<!-- Errors and Validations -->
@if (session()->has('success'))
<div class="alert alert-dismissable alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>
        {!! session()->get('success') !!}
    </strong>
</div>
@elseif(session()->has('error'))
<div class="alert alert-dismissable alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>
        {!! session()->get('error') !!}
    </strong>
</div>

@endif
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<!-- Errors and Validations End -->


<div class="row">

    <!-- ./col -->
    <div class="col-lg-2 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{$salesAmount}}<sup style="font-size: 20px"></sup></h3>
                <p>Todays Sales</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-2 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{$total_purchase}}</h3>
                <p>Todays Purchase</p>
            </div>
            <div class="icon">
                <i class="ion ion-briefcase"></i>
            </div>
            {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-2 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{$expense}}</h3>
                <p>Todays Expenses</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
        </div>
    </div>
    <div class="col-lg-2 col-6">
        <!-- small box -->
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{$cash}}</h3>
                <p>Cash Balance</p>
            </div>
            <div class="icon">
                <i class="ion ion-cash"></i>
            </div>
            {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
        </div>
    </div>
    <div class="col-lg-2 col-6">
        <!-- small box -->
        <div class="small-box bg-primary bg-maroon">
            <div class="inner">
                <h3>{{$bank}}</h3>
                <p>Bank Balance</p>
            </div>
            <div class="icon">
                <i class="ion ion-briefcase "></i>
            </div>
            {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
        </div>
    </div>

    <div class="col-lg-2 col-6">
        <!-- small box -->
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>Add</h3>
                <p>Cash/Bank Balance</p>
            </div>
            <div class="icon">
             <i class="ion ion-plus "></i>
            </div>
            <a href="{{route('admin.balance')}}" class="small-box-footer">Click to Add <i class="fas fa-plus"></i></a>
            {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
        </div>
    </div>

    <!-- ./col -->
</div>

<div class="card-header">
    <a href="{{route('admin.sales.create')}}"><button class="btn btn-success btn-lg float-right"><i class="fas fa-plus"></i></button></a>
</div>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Open Sales</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">

        <div class="row">
            <div class="col-sm-12">
                <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" role="grid" aria-describedby="example1_info">
                    <thead>
                        <tr role="row">
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">S.N
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Receipt No</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Customer Name</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Paid</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Remaining</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Delivery Date</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($openSales as $item)
                        <tr class="odd">
                            <td class="dtr-control sorting_1" tabindex="0">{{ $loop->iteration }}</td>
                            <td>{{ $item->receipt_id}}</td>
                            <td>{{Customer::where('id',SalesEntry::where('receipt_number',$item->receipt_id)->first()->customer_id)->first()->name}}</td>
                            @if($item->total_paid==null)
                            <td class="openPaid">0</td>
                            @else
                            <td class="openPaid">{{$item->total_paid}}</td>
                            @endif
                            <td class="remainingTotal">{{ $item->total_payable-$item->total_paid}}</td>

                            @if(isset(SalesEntry::where('receipt_number',$item->receipt_id)->first()->new_delivery_date))
                            <td>{{SalesEntry::where('receipt_number',$item->receipt_id)->first()->new_delivery_date}}</td>
                            @else
                            <td>{{SalesEntry::where('receipt_number',$item->receipt_id)->first()->estimated_delivery_date}}</td>
                            @endif
                            <td>
                                @if(SalesEntry::where('receipt_number',$item->receipt_id)->first()->is_complete!=1)
                                <a href="{{route('admin.sales.report.markcomplete',['receipt_id'=>$item->receipt_id])}}"><button class="btn btn-primary btn-xs"><i class="fa fa-check" title="Mark Completed"></i></button></a>
                                @endif

                                @if(SalesEntry::where('receipt_number',$item->receipt_id)->first()->is_complete=1 && Payable::where('receipt_id',$item->receipt_id)->first()->total_paid!=Payable::where('receipt_id',$item->receipt_id)->first()->total_payable)
                                <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#payment_{{ $item->receipt_id }}"><i class="fa fa-balance-scale" title="Mark Paid"></i></button>
                                @endif

                                <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#changeDate_{{ $item->receipt_id }}"><i class="fa fa-retweet" title="Change Delivery Date"></i></button>

                            </td>
                        </tr>
                        <!-- Payment Method Modal -->
                        <div class="modal fade" id="payment_{{ $item->receipt_id }}">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Pay Via:
                                            <b class="badge badge-danger">Receipt:{{ $item->receipt_id }}</b>
                                        </h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Content Goes here -->
                                        <form action=" {{route('admin.sales.report.payment',['receipt_id'=>$item->receipt_id])}}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="radio-inline">
                                                            <input type="radio" name="paymentOption" value="cash">Cash
                                                        </label>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="radio-inline">
                                                            <input type="radio" name="paymentOption" value="bank">Bank
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-success" type="submit">Pay</button>
                                        </form>
                                        <!-- Content Ends here -->
                                    </div>

                                </div>

                            </div>

                        </div>
                        <!--Payment Method Modal Ends -->
                        <!-- Delivery Date Change Modal Starts -->
                        <div class="modal fade" id="changeDate_{{ $item->receipt_id }}">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Change Delivery Date for:
                                            <b class="badge badge-danger">Receipt:{{ $item->receipt_id }}</b>
                                        </h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Content Goes here -->
                                        <form action=" {{route('admin.sales.change.deliveryDate',['receipt_id'=>$item->receipt_id])}}" method="POST">
                                            @csrf

                                            <div class="form-group">
                                                <label>New Delivery Date</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="far fa-calendar-alt"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control float-right date" name="new_delivery_date">
                                                </div>
                                                <!-- /.input group -->
                                            </div>

                                            <button class="btn btn-success" type="submit">Update</button>
                                        </form>
                                        <!-- Content Ends here -->
                                    </div>

                                </div>

                            </div>

                        </div>
                        <!--Delivery Date Change Modal Ends -->
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th rowspan="1" colspan="3">Total</th>
                            <th id="paid" rowspan="1" colspan="1"></th>
                            <th id="remainingTotal" rowspan="1" colspan="1"></th>

                            <th rowspan="1" colspan="2"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- CLOSED SALES TABLE  -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Closed Sales</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <table id="closedSalesTable" class="table table-bordered table-striped dataTable dtr-inline" role="grid" aria-describedby="example1_info">
                    <thead>
                        <tr role="row">
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">S.N
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Receipt No</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Customer Name</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Paid</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Delivery Date</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($closedSales as $item)
                        <tr class="odd">
                            <td class="dtr-control sorting_1" tabindex="0">{{ $loop->iteration }}</td>
                            <td>{{ $item->receipt_id}}</td>
                            <td>{{Customer::where('id',SalesEntry::where('receipt_number',$item->receipt_id)->first()->customer_id)->first()->name}}</td>
                            @if($item->total_paid==null)
                            <td class="openPaid">0</td>
                            @else
                            <td class="closedPaid">{{$item->total_paid}}</td>
                            @endif
                            @if(isset(SalesEntry::where('receipt_number',$item->receipt_id)->first()->new_delivery_date))
                            <td>{{SalesEntry::where('receipt_number',$item->receipt_id)->first()->new_delivery_date}}</td>
                            @else
                            <td>{{SalesEntry::where('receipt_number',$item->receipt_id)->first()->estimated_delivery_date}}</td>
                            @endif
                            <td>
                                @if(SalesEntry::where('receipt_number',$item->receipt_id)->first()->is_complete!=1)
                                <a href="{{route('admin.sales.report.markcomplete',['receipt_id'=>$item->receipt_id])}}"><button class="btn btn-primary btn-xs"><i class="fa fa-check" title="Mark Completed"></i></button></a>
                                @endif
                                <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#changeDate_{{ $item->receipt_id }}"><i class="fa fa-retweet" title="Change Delivery Date"></i></button>
                                <a href="{{route('admin.sales.delivered',['receipt_id'=>$item->receipt_id])}}"> <button class="btn btn-success btn-xs"><i class="fa fa-truck" title="Mark as Delivered"></i></button></a>
                            </td>
                        </tr>
                        <!-- Payment Method Modal -->
                        <div class="modal fade" id="payment_{{ $item->receipt_id }}">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Pay Via:
                                            <b class="badge badge-danger">Receipt:{{ $item->receipt_id }}</b>
                                        </h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Content Goes here -->
                                        <form action=" {{route('admin.sales.report.payment',['receipt_id'=>$item->receipt_id])}}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="radio-inline">
                                                            <input type="radio" name="paymentOption" value="cash">Cash
                                                        </label>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="radio-inline">
                                                            <input type="radio" name="paymentOption" value="bank">Bank
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-success" type="submit">Pay</button>
                                        </form>
                                        <!-- Content Ends here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Payment Method Modal Ends -->
                        <!-- Delivery Date Change Modal Starts -->
                        <div class="modal fade" id="changeDate_{{ $item->receipt_id }}">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Change Delivery Date for:
                                            <b class="badge badge-danger">Receipt:{{ $item->receipt_id }}</b>
                                        </h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Content Goes here -->
                                        <form action=" {{route('admin.sales.change.deliveryDate',['receipt_id'=>$item->receipt_id])}}" method="POST">
                                            @csrf

                                            <div class="form-group">
                                                <label>New Delivery Date</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="far fa-calendar-alt"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control float-right" id="date" name="new_delivery_date">
                                                </div>
                                                <!-- /.input group -->
                                            </div>

                                            <button class="btn btn-success" type="submit">Update</button>
                                        </form>
                                        <!-- Content Ends here -->
                                    </div>

                                </div>

                            </div>

                        </div>
                        <!--Delivery Date Change Modal Ends -->
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th rowspan="1" colspan="3">Total</th>
                            <th id="closedPaid" rowspan="1" colspan="1"></th>
                            <th rowspan="1" colspan="1"></th>

                            <th rowspan="1" colspan="2"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
