@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">News</h3>
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
                        <a href="">News</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item active">
                        <a>Status</a>
                    </li>
                </ul>
            </div>
            {{-- Content --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Status News</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="basic-datatables" class="display table table-striped table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Author</th>
                                            <th>Updated At</th>
                                            <th style="width: 5%">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Author</th>
                                            <th>Updated At</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($draftNews as $news)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $news->id }}</td>
                                                <td>{{ $news->title }}</td>
                                                <td>{{ $news->category->name }}</td>
                                                <td>{{ $news->author->name }}</td>
                                                <td>{{ $news->updated_at->translatedFormat('m/d/Y H:i') }}</td>
                                                <td>
                                                    <div
                                                        class="form-button-action d-flex justify-content-center align-items-center">
                                                        <span data-bs-toggle="tooltip" title="View">
                                                            <a href="{{ route('news.view', $news->id) }}"
                                                                class="btn btn-link btn-primary btn-lg">
                                                                <i class="far fa-eye"></i>
                                                            </a>
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
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
