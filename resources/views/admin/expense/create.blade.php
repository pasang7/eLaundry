@extends('layouts.dashboard')
@section('content')

    @include('layouts.alerts')

    <div class="card card-secondary">
        {{-- <div class="card-header">
            <h3 class="card-title">Create Expense</h3>
        </div> --}}
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('admin.expense.store') }}" method="POST">

            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Expense Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter expense name"
                        value="{{ old('expenseName') }}">
                </div>
                <hr>
                <div class="row">
                    <div class="col-6">   
                        <label class="radio-inline">
                            <input type="radio" name="expenseType" value="cash">Cash
                        </label>
                    </div>
                    <div class="col-6">
                        <label class="radio-inline">
                            <input type="radio" name="expenseType" value="bank">Bank
                        </label>
                    </div>
                </div>
                <hr>
              

                <div class="form-group">
                    <label for="expense_ledger_id">Expense Ledger</label><a href="#" data-toggle="modal" data-target="#createExpenseLedger"><code>.click-to-create-expense-ledger.</code></a>
                    <select class="form-control" name="expense_ledger_id">
                        <option disabled selected>Select Expense Ledger</option>
                        @foreach ($expenseLedgers as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="number" name="amount" class="form-control" id="amount" placeholder="Amount"
                        value="{{ old('amount') }}">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" rows="3" placeholder="Description ..."
                        name="description">{{ old('description') }}</textarea>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-secondary">Create</button>
            </div>
        </form>
    </div>

             <!-- Payment Method Modal -->
             <div class="modal fade" id="createExpenseLedger">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Create Expense Ledger
                            </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Content Goes here -->
                            <form action="{{ route('admin.expense.expenseLedger.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Expense Ledger Name</label>
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter expense name"
                                        value="{{ old('name') }}">
                                </div>
                                <button class="btn btn-success" type="submit">Create</button>
                            </form>
                            <!-- Content Ends here -->
                        </div>

                    </div>

                </div>

            </div>
            <!--Payment Method Modal Ends -->

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
