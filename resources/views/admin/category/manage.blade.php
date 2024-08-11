@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Category</h3>
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
                        <a href="{{ route('admin.category.manage') }}">Category</a>
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
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Manage Category</h4>
                                <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal"
                                    data-bs-target="#createCategoryModal">
                                    <i class="fa fa-plus"></i>
                                    Add Category
                                </button>

                                <!-- Create Modal -->
                                <div class="modal fade" id="createCategoryModal" tabindex="-1" role="dialog"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header border-0">
                                                <h5 class="modal-title">
                                                    <span class="fw-mediumbold">Create
                                                    </span>
                                                    <span class="fw-light">Category</span>
                                                </h5>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <form action="{{ route('admin.category.store') }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <p class="small">
                                                        Create a new category using this form, make sure you
                                                        fill them all
                                                    </p>

                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group form-group-default">
                                                                <label>Name</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Fill Name" name="name">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0">
                                                    <button type="submit" id="submitButton" class="btn btn-primary">
                                                        Add
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                                        Close
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                {{-- End Create Modal --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="add-row" class="display table table-striped table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Total News</th>
                                            <th style="width: 5%">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Total News</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($allCategory as $categories)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $categories->id }}</td>
                                                <td>{{ $categories->name }}</td>
                                                <td>{{ $categories->news->count() }}</td>
                                                <td>
                                                    <div
                                                        class="form-button-action d-flex justify-content-center align-items-center">
                                                        <span data-bs-toggle="tooltip" title="Edit">
                                                            <button type="button" data-bs-toggle="modal"
                                                                class="btn btn-link btn-primary btn-lg"
                                                                data-bs-target="#editCategoryModal{{ $categories->id }}">
                                                                <i class="fa fa-edit"></i>
                                                            </button>
                                                        </span>

                                                        <span data-bs-toggle="tooltip" title="Delete">
                                                            <form
                                                                action="{{ route('admin.category.destroy', $categories->id) }}"
                                                                id="deleteButton" data-id="{{ $categories->id }}">
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
                                            {{-- Edit Modal --}}
                                            <div class="modal fade" id="editCategoryModal{{ $categories->id }}"
                                                tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header border-0">
                                                            <h5 class="modal-title">
                                                                <span class="fw-mediumbold">Edit
                                                                </span>
                                                                <span class="fw-light">Category</span>
                                                            </h5>
                                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <form id="editForm"
                                                            action="{{ route('admin.category.update', $categories->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <p class="small">
                                                                    Update a category using this form, make sure you fill
                                                                    them all
                                                                </p>
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group form-group-default">
                                                                            <label>Name</label>
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Fill name" name="name"
                                                                                value="{{ $categories->name }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer border-0">
                                                                <button type="submit" class="btn btn-primary">
                                                                    Update
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
                                            {{-- End Modal Edit --}}
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
        $("#add-row").DataTable({
            pageLength: 5,
        });
    </script>
@endsection
