@extends('layouts.dashboard')

@section('content')
    @include('layouts.alerts')
<div class="row">
    <div class="col-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add Balance</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form action="{{ route('admin.balance.add') }}" method="POST">
    
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <label class="radio-inline">
                                    <input type="radio" name="balanceType" value="addToCash">Add to Cash
                                </label>
                            </div>
                            <div class="col-6">
                                <label class="radio-inline">
                                    <input type="radio" name="balanceType" value="addToBank">Add to Bank
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
                        <button type="submit" class="btn btn-secondary">Add Balance</button>
                    </div>
                </form>
    
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <div class="col-4">
       
            <div class="info-box mb-3 bg-success">
                <span class="info-box-icon"><i class="fas fa-money-bill-wave"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">Available Cash Amount</span>
                  <span class="info-box-number">{{$cash}}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <div class="info-box mb-3 bg-info">
                <span class="info-box-icon"><i class="fas fa-piggy-bank"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">Available Bank Amount</span>
                  <span class="info-box-number">{{$bank}}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
    
    </div>
</div>
    
@endsection
