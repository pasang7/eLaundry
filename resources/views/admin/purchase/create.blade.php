@extends('layouts.dashboard')
@section('content')
@include('layouts.alerts')
<div class="card card-secondary">
    <form action="{{ route('admin.purchase.add') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="name">Purchase Name</label>
                <input type="text" name="name" class="form-control" id="purchaseName" placeholder="Enter purchases name" value="{{ old('name') }}">
            </div>
            <hr>
            <div class="row">
                <div class="col-6">   
                    <label class="radio-inline">
                        <input type="radio" name="purchaseType" value="cash">Cash
                    </label>
                </div>
                <div class="col-6">
                    <label class="radio-inline">
                        <input type="radio" name="purchaseType" value="bank">Bank
                    </label>
                </div>
            </div>
            <hr>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" name="amount" class="form-control" id="amount" placeholder="Enter amount" value="{{ old('amount') }}">
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea class="form-control" name="description" rows="3" placeholder="Enter description ..."></textarea>
              </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-secondary">Create</button>
        </div>
    </form>
</div>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Purchase List</h3>
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
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Purchase Name</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Amount</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Description</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchases as $item)
                        <tr class="odd">
                            <td class="dtr-control sorting_1" tabindex="0">{{ $loop->iteration }}</td>
                            <td>{{ $item->name}}</td>
                            <td class="salesQuantity">{{ $item->amount}}</td>
                            <td>{{ $item->description}}</td>
                            <td>{{ $item->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                    </tfoot>
                    <tr>
                        <th rowspan="1" colspan="2">Total</th>
                        <th id="salesQuantity" rowspan="1" colspan="1"></th>
                        <th  rowspan="1" colspan="2"></th>
                        <!--   <th rowspan="1" colspan="1">Action</th> -->
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
