@extends('layouts.dashboard')
@section('content')
@include('layouts.alerts')

@php
use App\Models\ExpenseLedger;
@endphp

<div class="card card-secondary">
    <form action="{{ route('admin.expenseLedger.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="expenseName">Expense Ledger Name</label>
                <input type="text" name="expenseName" class="form-control" id="expenseName" placeholder="Enter expense ledger name" value="{{ old('name') }}">
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-secondary">Create</button>
        </div>
    </form>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Active Expenses</h3>
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

                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Expense Ledger Name</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Expense Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expenses as $item)
                        <tr class="odd">
                            <td class="dtr-control sorting_1" tabindex="0">{{ $loop->iteration }}</td>
                            @if(isset(ExpenseLedger::where('id',$item->expid)->first()->name))
                            <td>{{ExpenseLedger::where('id',$item->expid)->first()->name}}</td>
                            @else
                            <td>NA</td>
                            @endif
                            <td class="salesQuantity">{{$item->amount}}</td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th rowspan="1" colspan="2">Total</th>
                            <th id="salesQuantity" rowspan="1" colspan="1"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Expenses Ledgers</h3>
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

                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Expense Ledger Name</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expenseLedgers as $item)
                        <tr class="odd">
                            <td class="dtr-control sorting_1" tabindex="0">{{ $loop->iteration }}</td>
                            <td>{{$item->name}}</td>
                        
                            
                        </tr>
                        @endforeach
                    </tbody>
              
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
