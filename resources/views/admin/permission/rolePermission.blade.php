@extends('layouts.dashboard')

@section('content')
    @include('layouts.alerts')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Assign User Roles and Permissions</h3>
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
                                    aria-label="Browser: activate to sort column ascending">Role</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                    aria-label="Browser: activate to sort column ascending">Permissions</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                    aria-label="Browser: activate to sort column ascending">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rolePermission as $role)
                                <tr class="odd">
                                    <td class="dtr-control sorting_1" tabindex="0">{{ $loop->iteration }}</td>
                                    <td>{{ $role->role_name }}</td>
                                    <td>
                                        @foreach ($role->rolePermission as $permission)
                                            <span
                                                class="badge badge-success">{{ $permission->permissionName->permission_name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-outline-success" data-toggle="modal"
                                            data-target="#edit_permission{{ $role->id }}"><i
                                                class="fa fa-edit"></i>Edit</button>
                                    </td>
                                </tr>
                                <!-- Edit User Permission Modal -->
                                <div class="modal fade" id="edit_permission{{ $role->id }}">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Permission for Role:
                                                    <b class="badge badge-warning">{{ $role->role_name }}</b>
                                                </h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Content Goes here -->
                                                <form action="{{ route('admin.update.role.permissions') }}" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label>Select Permissions</label>
                                                        <input type="hidden" name="update_id" value="{{ $role->id }}">

                                                        <select name='permissions[]' class="select2"
                                                            multiple="multiple" data-placeholder="Select Permissions"
                                                            style="width: 100%;">
                                                            @foreach ($permissions as $item)
                                                                <option value="{{ $item->id }}">
                                                                    {{ $item->permission_name }}</option>

                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <button class="btn btn-success" type="submit">Update</button>
                                                </form>


                                                <!-- Content Ends here -->
                                            </div>

                                        </div>

                                    </div>

                                </div>
                                <!-- Edit User Permission Modal Ends -->
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <th rowspan="1" colspan="1">S.N</th>
                                <th rowspan="1" colspan="1">Role</th>
                                <th rowspan="1" colspan="1">Permission</th>
                                <th rowspan="1" colspan="1">Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
