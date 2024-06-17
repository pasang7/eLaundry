@extends('layouts.dashboard')
@section('content')

@include('layouts.alerts')

@php

use App\Models\Payable;
use App\Models\SalesEntry;
use App\Models\Customer;
@endphp
<div class="card">
    <div class="card-header">
        <h3 class="card-title">List of Debtors</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" role="grid" aria-describedby="example1_info">
                    <thead>
                        <tr role="row">
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">
                                S/N
                            </th>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">
                                Name
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Phone</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($debtors as $item)

                        <tr class="odd">
                            <td class="dtr-control sorting_1" tabindex="0">{{ $loop->iteration }}</td>
                            <td>{{ $item->name}}</td>
                            <td>{{ $item->phone_number }}</td>
                            <td class="debtPayable">{{ $item->opening_balance }}</td>

                        </tr>
                        @endforeach
                        <!-- Edit Modal -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <th rowspan="1" colspan="3">Total</th>
                            <th id="totalDebt" rowspan="1" colspan="1"></th>
                            <!--   <th rowspan="1" colspan="1">Action</th> -->
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>
</div>




@endsection
