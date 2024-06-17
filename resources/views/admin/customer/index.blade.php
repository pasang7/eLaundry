@extends('layouts.dashboard')
@section('content')

@include('layouts.alerts')
<div class="card-header">
    <a href="{{ route('admin.customer.create') }}"><button class="btn btn-success btn-lg float-right"><i class="fas fa-plus"></i></button></a>
</div>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">List of Customers</h3>
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
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">PAN</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Preferance</th>

                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Opening Balance</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $item)

                        <tr class="odd">
                            <td class="dtr-control sorting_1" tabindex="0">{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->phone_number }}</td>
                            <td>{{ $item->other_details }}</td>

                            <td>{{ $item->pan }}</td>

                            <td>{{ $item->opening_balance }}</td>
                            <td><button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#edit_customer{{$item->id}}"><i class="fa fa-edit"></i>Edit</button></td>
                        </tr>

                        <!-- Edit Modal -->

                        <div class="modal fade" id="edit_customer{{$item->id}}">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Edit Customer:{{ $item->name }}</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.customer.update',['id'=>$item->id]) }}" method="POST">

                                            @csrf
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="name">Customer Name</label>
                                                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter customer name" value="{{ $item->name}}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="phone_number">Phone Number</label>
                                                    <input type="text" name="phone_number" class="form-control" id="name" placeholder="Enter phone number" value="{{ $item->phone_number }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="pan">PAN Number</label>
                                                    <input type="text" name="pan" class="form-control" id="pan" placeholder="Personal Account Number" value="{{ $item->pan}}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Additional Information</label>
                                                    <textarea class="form-control" rows="3" placeholder="Preference ,Instructions ..." name="other_details">{{ $item->other_details }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="opening_balance">Opening Balance</label>
                                                    <input type="number" name="opening_balance" class="form-control" id="opening_balance" placeholder="Opening Balance" value="{{ $item->opening_balance }}">
                                                </div>
                                            </div>
                                            <!-- /.card-body -->

                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-secondary">Update</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>

                            </div>

                        </div>
                        <!-- Edit Modal Ends -->
                        @endforeach
                        <!-- Edit Modal -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <th rowspan="1" colspan="1">S.N</th>
                            <th rowspan="1" colspan="1">Name</th>
                            <th rowspan="1" colspan="1">Phone</th>
                            <th rowspan="1" colspan="1">PAN</th>
                            <th rowspan="1" colspan="1">Preferance</th>
                            <th rowspan="1" colspan="1">Opening Balance</th>
                            <th rowspan="1" colspan="1">Action</th>
                            <!--   <th rowspan="1" colspan="1">Action</th> -->

                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>
</div>




@endsection
