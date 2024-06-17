@extends('layouts.dashboard')

@section('content')
@include('layouts.alerts')
<div class="col-12">
    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title">Application Settings</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Company Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter company name" value="{{$setting->name}}">
                </div>
                <div class="form-group">
                    <label for="email_address">Email address</label>
                    <input type="text" name="email_address" class="form-control" id="email_address" placeholder="Enter email" value="{{$setting->email}}">
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" class="form-control" id="address" placeholder="Enter address" value="{{$setting->address}}">
                </div>
                <div class="form-group">
                    <label for="pan">VAT/PAN Number</label>
                    <input type="text" name="pan" class="form-control" id="pan" placeholder="Enter VAT/PAN" value="{{$setting->pan}}">
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" name="phone" class="form-control" id="phone" placeholder="Enter phone" value="{{$setting->phone}}">
                </div>
                @if(Auth::user()->hasRole('superadmin'))
                <div class="form-group">
                    <label for="logo">Logo</label><code> &nbsp;for-best-results-select-277*249-resolution-image</code>
                    <input type="file" class="form-control-file" name="logo">
                </div>
                <div class="form-group">
                    <label for="banner">Banner</label><code>&nbsp;for-best-results-select-standard-monitor-resolution-image</code>
                    <input type="file" class="form-control-file" name="banner">
                </div>
                @endif
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-secondary">Update</button>
            </div>
        </form>
    </div>
</div>





@endsection
