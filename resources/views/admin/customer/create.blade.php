@extends('layouts.dashboard')
@section('content')

    @include('layouts.alerts')

    <div class="card card-secondary">
        {{-- <div class="card-header">
            <h3 class="card-title">Create Expense</h3>
        </div> --}}
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('admin.customer.store') }}" method="POST">

            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Customer Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter customer name"
                        value="{{ old('name') }}">
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" name="phone_number" class="form-control" id="name" placeholder="Enter phone number"
                        value="{{ old('phone_number') }}">
                </div>
                <div class="form-group">
                    <label for="pan">PAN Number</label>
                    <input type="text" name="pan" class="form-control" id="pan" placeholder="Personal Account Number"
                        value="{{ old('pan') }}">
                </div>
                <div class="form-group">
                    <label>Additional Information</label>
                    <textarea class="form-control" rows="3" placeholder="Preference ,Instructions ..."
                        name="other_details">{{ old('other_details') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="opening_balance">Opening Balance</label>
                    <input type="number" name="opening_balance" class="form-control" id="opening_balance"
                        placeholder="Opening Balance" value="{{ old('opening_balance') }}">
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-secondary">Create</button>
            </div>
        </form>
    </div>
@endsection
