@extends('layouts.dashboard')

@section('content')
    @include('layouts.alerts')

    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title">Create Categories</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('admin.categories.store') }}" method="POST">

            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="category_name">Category Name</label>
                    <input name="category_name" type="text" class="form-control" id="category_name"
                        placeholder="Enter Category Name">

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
            <h3 class="card-title">List Categories</h3>
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
                                    aria-label="Browser: activate to sort column ascending">Category Name</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $item)
                                <tr class="odd">
                                    <td class="dtr-control sorting_1" tabindex="0">{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>


                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th rowspan="1" colspan="1">S.N</th>
                                <th rowspan="1" colspan="1">Category Name</th>

                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>
    <!-- /.card-body -->








@endsection
