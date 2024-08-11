@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Users</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="">Users</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item active">
                        <a>Manage</a>
                    </li>
                </ul>
            </div>
            {{-- Content --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Manage Users</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="basic-datatables" class="display table table-striped table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Count News</th>
                                            <th>Role</th>
                                            <th>Created At</th>
                                            <th>Status</th>
                                            <th style="width: 5%">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Count News</th>
                                            <th>Role</th>
                                            <th>Created At</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($allUsers as $user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->news->count() }}</td>
                                                <td>{{ $user->getRoleNames()->implode(', ') }}</td>
                                                <td>{{ $user->created_at->translatedFormat('m/d/Y H:i') }}</td>
                                                <td>
                                                    @if ($user->isOnline())
                                                        <span class="badge bg-success">Online</span>
                                                    @else
                                                        <span class="badge bg-danger">{{ $user->lastSeenHuman() }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div
                                                        class="form-button-action d-flex justify-content-center align-items-center">
                                                        <span data-bs-toggle="tooltip" title="Assign Role">
                                                            <a href="#" class="btn btn-link btn-primary btn-lg"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#roleModal-{{ $user->id }}">
                                                                <i class="far fa-address-card"></i>
                                                            </a>
                                                        </span>

                                                        <span data-bs-toggle="tooltip" title="Delete">
                                                            <form action="{{ route('admin.users.destroy', $user->id) }}"
                                                                id="deleteButton" data-id="{{ $user->id }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-link btn-danger">
                                                                    <i class="fa fa-times"></i>
                                                                </button>
                                                            </form>
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                            {{-- Role Modal --}}
                                            <div class="modal fade" id="roleModal-{{ $user->id }}" tabindex="-1"
                                                role="dialog" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header border-0">
                                                            <h5 class="modal-title">
                                                                <span class="fw-light">Assign </span>
                                                                <span class="fw-mediumbold">Role</span>
                                                            </h5>
                                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('admin.users.assignRole', $user->id) }}"
                                                            method="POST" id="editForm">
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="modal-body">
                                                                <p class="small">Assign role to user</p>
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group form-group-default">
                                                                            <label>Select</label>
                                                                            <select class="form-select" name="role">
                                                                                @foreach ($roles as $role)
                                                                                    <option value="{{ $role->id }}">
                                                                                        {{ $role->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer border-0">
                                                                <button type="submit" class="btn btn-primary"
                                                                    id="valueButton">
                                                                    Add
                                                                </button>
                                                                <button type="button" class="btn btn-danger"
                                                                    data-bs-dismiss="modal">
                                                                    Close
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- End Role Modal --}}
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-footer')
    <script>
        $(document).ready(function() {
            $("#basic-datatables").DataTable({});
        });
    </script>
@endsection
