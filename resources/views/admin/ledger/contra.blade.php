@extends('layouts.dashboard')

@section('content')
    @include('layouts.alerts')

    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Contra Entry</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form action="{{ route('admin.contra.make') }}" method="POST">

                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <label class="radio-inline">
                                <input type="radio" name="contraType" value="cashToBank">Cash to Bank
                            </label>
                        </div>
                        <div class="col-6">
                            <label class="radio-inline">
                                <input type="radio" name="contraType" value="bankToCash">Bank to Cash
                            </label>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" name="amount" class="form-control" id="amount" placeholder="Amount"
                            value="{{ old('amount') }}">
                    </div>
               
                </div>
                <!-- /.card-body -->
    
                <div class="card-footer">
                    <button type="submit" class="btn btn-secondary">Make Contra</button>
                </div>
            </form>

        </div>
    </div>
    <!-- /.card-body -->
@endsection
