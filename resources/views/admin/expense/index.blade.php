@extends('layouts.dashboard')
@section('content')

@include('layouts.alerts')
<div class="card-header">
    <a href="{{ route('admin.expense.create') }}"><button class="btn btn-success btn-lg float-right"><i class="fas fa-plus"></i></button></a>
</div>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Expenses</h3>
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

                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Description</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Amount</th>
                            <!--   <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                                                        aria-label="Browser: activate to sort column ascending">Actions</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expense as $item)

                        <tr class="odd">
                            <td class="dtr-control sorting_1" tabindex="0">{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                           
                         
                            <td>{{ $item->description }}</td>
                            <td class="purchaseAmount">{{ $item->amount }}</td>

                        </tr>
                        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th rowspan="1" colspan="3">Total</th>
                <th rowspan="1" id="totalPurchase" colspan="1"></th>
              
            </tr>
        </tfoot>
        </table>
    </div>
</div>

</div>
</div>




@endsection
