@extends('layouts.dashboard')
@php
use App\Models\Customer;
use App\Models\Product;
@endphp
@section('content')
@include('layouts.alerts')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Total Sales</h3>
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
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Product Name</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Quantity</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Amount</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Delivery Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales as $item)
                        <tr class="odd">
                            <td class="dtr-control sorting_1" tabindex="0">{{ $loop->iteration }}</td>
                            <td>{{ $item->receipt_number}}</td>
                            <td>{{ Customer::where('id',$item->customer_id)->first()->name }}</td>
                            <td>{{ Product::where('id',$item->product_id)->first()->name }}</td>
                            <td class="salesQuantity">{{ $item->product_quantity }}</td>
                            <td class="salesAmount">{{ $item->item_total }}</td>
                            <td>{{ $item->estimated_delivery_date }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                    </tfoot>
                    <tr>
                        <th rowspan="1" colspan="4">Total</th>
                        <th id="salesQuantity" rowspan="1" colspan="1"></th>
                        <th id="salesAmount" rowspan="1" colspan="1"></th>
                        <th id="" rowspan="1" colspan="1"></th>
                        <!--   <th rowspan="1" colspan="1">Action</th> -->
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.card-body -->
@endsection
