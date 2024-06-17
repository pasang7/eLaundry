@extends('layouts.dashboard')

@section('content')
    @include('layouts.alerts')

    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Ledgers</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">

            <div class="row">
                <div class="col-sm-12">
                    <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" role="grid"
                        aria-describedby="example1_info">
                        <thead>
                            <tr role="row">
                                <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                    aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">
                                    S.N
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                    aria-label="Browser: activate to sort column ascending">Ledger Name</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                    aria-label="Browser: activate to sort column ascending">Opening Balance</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                    aria-label="Browser: activate to sort column ascending">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ledgers as $item)
                                <tr class="odd">
                                    <td class="dtr-control sorting_1" tabindex="0">{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->opening_balance }}</td>
                                    <td>
                                        <button type="button" class="btn btn-outline-success" data-toggle="modal"
                                            data-target="#edit_opening_balance{{ $item->id }}"><i
                                                class="fa fa-edit"></i></button>
                                    </td>
                                </tr>
                                <!-- Edit Opening Balance Modal Modal -->
                                <div class="modal fade" id="edit_opening_balance{{ $item->id }}">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Opening Balance for:
                                                    <b class="badge badge-warning">{{ $item->name }}</b>
                                                </h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Content Goes here -->
                                                <form action="{{ route('admin.ledgers.update', ['id' => $item->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label>Opening Balance</label>
                                                        <input type="number" name="opening_balance"
                                                            value="{{ $item->opening_balance }}">
                                                    </div>
                                                    <button class="btn btn-success" type="submit">Update</button>
                                                </form>


                                                <!-- Content Ends here -->
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th rowspan="1" colspan="1">S.N</th>
                                <th rowspan="1" colspan="1">Ledger Name</th>
                                <th rowspan="1" colspan="1">Opening Balance</th>
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
