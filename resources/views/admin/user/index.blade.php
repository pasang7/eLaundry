@extends('layouts.dashboard')
@section('content')

    @include('layouts.alerts')

    <div class="col-6">
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Create Users</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('admin.store.user') }}" method="POST">

                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter name" value="{{old('name')}}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" value="{{old('email')}}">
                    </div>
                    <div class="form-group">
                        <label for="role">Select Role</label>
                        <select class="form-control" name="role">
                            <option disabled selected>Select Role</option>
                            @foreach ($roles as $item)
                                <option value="{{ $item->id }}">{{ $item->role_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Password" value="{{old('password')}}">
                    </div>
                    <div class="form-group">
                        <label for="confirmpassword">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" id="passwordConfirm"
                            placeholder="Confirm Password">
                    </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-secondary">Create</button>
                </div>
            </form>
        </div>
    </div>




    <div class="card">
        <div class="card-header">
            <h3 class="card-title">List of Users</h3>
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
                                    aria-label="Rendering engine: activate to sort column descending">S/N
                                </th>
                                <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1"
                                    colspan="1" aria-sort="ascending"
                                    aria-label="Rendering engine: activate to sort column descending">Name
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                    aria-label="Browser: activate to sort column ascending">Username/Email</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                    aria-label="Browser: activate to sort column ascending">Role</th>
                                    @if (Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin'))
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                    aria-label="Browser: activate to sort column ascending">Actions</th>
                                    @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                {{-- <tr class="odd">
                                    <td class="dtr-control sorting_1" tabindex="0">{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>
                                        @foreach ($item->roles as $role)
                                            <span class="badge badge-success">{{ $role->role_name }}</span>
                                        @endforeach
                                    </td> --}}


                                <tr class="odd">
                                    <td class="dtr-control sorting_1" tabindex="0">{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>

                                    <td>
                                        @foreach ($user->roles as $role)
                                            <span class="badge badge-success">{{ $role->role_name }}</span>
                                        @endforeach
                                    </td>
                                        @if (Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin'))
                                    <td>
                                        <button type="button" class="btn btn-outline-success" data-toggle="modal"
                                            data-target="#edit_user{{ $user->id }}"><i
                                                class="fa fa-edit"></i>Edit</button>
                                        <button type="button" class="btn btn-outline-danger" data-toggle="modal"
                                            data-target="#delete_user{{ $user->id }}"><i
                                                class="fa fa-trash"></i>Delete</button>
                                    </td>
                                    @endif
                                </tr>
                                <!-- Edit Modal -->

                                <div class="modal fade" id="edit_user{{ $user->id }}">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit User:{{ $user->name }}</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin.update.user', ['id' => $user->id]) }}"
                                                    method="POST">

                                                    @csrf
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="name">Name</label>
                                                            <input type="text" name="name" class="form-control" id="name"
                                                                placeholder="Enter name" value="{{ $user->name }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Email address</label>
                                                            <input type="email" name="email" class="form-control"
                                                                id="email" placeholder="Enter email"
                                                                value="{{ $user->email }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="role">Select Role</label>
                                                            <select class="form-control" name="role">

                                                                @foreach ($roles as $item)
                                                                    <option value="{{ $item->id }}" >{{ $item->role_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="password">Password</label>
                                                            <input type="password" name="password" class="form-control"
                                                                id="password" placeholder="Password">
                                                        </div>

                                                    </div>


                                                    <div class="card-footer">
                                                        <button type="submit" class="btn btn-secondary">Update</button>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                                <!-- Edit Modal Ends -->
                                <!-- Delete Modal -->
                                <div class="modal fade" id="delete_user{{ $user->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content bg-danger">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Delete user<b> {{ $user->name }}</b></h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete this user?</p>
                                            </div>

                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-outline-light"
                                                    data-dismiss="modal">No</button>

                                                <a href="{{ route('admin.users.delete', ['id' => $user->id]) }}"><button
                                                        type="button" class="btn btn-outline-light">Yes</button></a>
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
                    </table>
                </div>
            </div>

        </div>
    </div>




@endsection
