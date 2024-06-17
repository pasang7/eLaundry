@extends('layouts.dashboard')

@section('content')
    @include('layouts.alerts')
    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title">Create Products</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('admin.product.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <input name="name" type="text" class="form-control" id="product_name" value="{{ old('name') }}"
                        placeholder="Enter Product Name">

                </div>
                <div class="form-group">
                    <label for="product_name">Product Category</label>
                    <select class="form-control" name="category_id">
                        <option disabled selected>Select Category</option>
                        @foreach ($categories as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="rate">Product Rate</label>
                    <input type="number" class="form-control" name="rate" value="{{ old('rate') }}">
                </div>
                <div class="form-group">
                    <label for="product_name">Status</label>
                    <select class="form-control" name="status">
                        <option disabled selected>Select Status</option>

                        <option value="1">Active</option>
                        <option value="0">Inactive</option>

                    </select>
                </div>

            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-secondary">Create</button>
            </div>
        </form>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">List Products</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">

            <div class="row">
                <div class="col-sm-12">
                    <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" role="grid"
                        aria-describedby="example1_info">
                        <thead>
                            <tr role="row">
                                <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1"
                                    colspan="1" aria-sort="ascending"
                                    aria-label="Rendering engine: activate to sort column descending">S.N
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                    aria-label="Browser: activate to sort column ascending">Product Name</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                    aria-label="Browser: activate to sort column ascending">Category</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                    aria-label="Browser: activate to sort column ascending">Rate</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                    aria-label="Browser: activate to sort column ascending">Status</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                    aria-label="Browser: activate to sort column ascending">Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $item)
                                <tr class="odd">
                                    <td class="dtr-control sorting_1" tabindex="0">{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->getCategory->name }}</td>
                                    <td>{{ $item->rate }}</td>
                                    @if ($item->status == 1)
                                        <td><small class="badge badge-success"></i>Active</small></td>
                                    @else
                                        <td><small class="badge badge-danger"></i>Inactive</small></td>
                                    @endif
                                    <td>
                                        <button type="button" class="btn btn-outline-success" data-toggle="modal"
                                            data-target="#edit_product{{ $item->id }}"><i
                                                class="fa fa-edit"></i>Edit</button>
                                        <button type="button" class="btn btn-outline-danger" data-toggle="modal"
                                            data-target="#delete_product{{ $item->id }}"><i
                                                class="fa fa-trash"></i>Delete</button>
                                    </td>
                                </tr>

                                <!-- Product Edit Modal -->
                                <div class="modal fade" id="edit_product{{ $item->id }}">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Product:{{ $item->name }}</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin.product.update', ['id' => $item->id]) }}"
                                                    method="POST">

                                                    @csrf
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="product_name">Product Name</label>
                                                            <input name="name" type="text" class="form-control"
                                                                id="product_name" value="{{ $item->name }}"
                                                                placeholder="Enter Product Name">

                                                        </div>
                                                        <div class="form-group">
                                                            <label for="product_name">Product Category</label>
                                                            <select class="form-control" name="category_id">

                                                                @foreach ($categories as $category)
                                                                    @if ($category->id == $item->category_id)
                                                                        <option value="{{ $category->id }}" selected>
                                                                            {{ $category->name }}</option>
                                                                    @else
                                                                        <option value="{{ $category->id }}">
                                                                            {{ $category->name }}</option>
                                                                    @endif

                                                                @endforeach

                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="rate">Product Rate</label>
                                                            <input type="number" class="form-control" name="rate"
                                                                value="{{ $item->rate }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="product_name">Status</label>
                                                            <select class="form-control" name="status">
                                                                @if ($item->status == 1)
                                                                    <option value="1" selected>Active</option>
                                                                    <option value="0">Inactive</option>
                                                                @else
                                                                    <option value="0" selected>Inactive</option>
                                                                    <option value="1">Active</option>
                                                                @endif
                                                            </select>
                                                        </div>
                                                        <button type="submit" class="btn btn-secondary">Update</button>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                                <!-- Product Edit Modal Ends -->

                                <!-- Delete Modal -->
                                <div class="modal fade" id="delete_product{{ $item->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content bg-danger">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Delete product<b> {{ $item->name }}</b></h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete this product?</p>
                                            </div>

                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-outline-light"
                                                    data-dismiss="modal">No</button>

                                                <a href="{{route('admin.product.delete',['id'=>$item->id])}}"><button type="button"
                                                        class="btn btn-outline-light">Yes</button></a>
                                            </div>
                                        </div>

                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->

                                <!-- Delete Modal Ends -->

                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th rowspan="1" colspan="1">S.N</th>
                                <th rowspan="1" colspan="1">Product Name</th>
                                <th rowspan="1" colspan="1">Category</th>
                                <th rowspan="1" colspan="1">Rate</th>
                                <th rowspan="1" colspan="1">Status</th>
                                <th rowspan="1" colspan="1">Actions</th>

                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>
    <!-- /.card-body -->
@endsection
