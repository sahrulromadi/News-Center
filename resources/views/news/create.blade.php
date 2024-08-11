@extends('layouts.admin')

@section('custom-header')
    {{-- CKEditor --}}
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/42.0.1/ckeditor5.css" />
    <script type="importmap">
   {
       "imports": {
           "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/42.0.1/ckeditor5.js",
           "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/42.0.1/"
       }
   }
   </script>
    <script type="module" src="{{ asset('js/ckeditor.js') }}"></script>
@endsection

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
                        <a href="{{ route('admin.news.manage') }}">News</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item active">
                        <a>Create</a>
                    </li>
                </ul>
            </div>
            {{-- Content --}}
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Create News</div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data"
                                        id="form">
                                        @csrf
                                        <div class="col-12 mx-auto">
                                            <div class="form-group row">
                                                <label for="inlineinput" class="col-12 col-form-label">Title</label>
                                                <div class="col-12">
                                                    <input type="text" class="form-control input-full" id="inlineinput"
                                                        placeholder="Enter Input" name="title" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="editor" class="col-12">Content</label>
                                                <textarea class="form-control col-12" id="editor" name="content"></textarea>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="exampleFormControlSelect1">Category</label>
                                                <select class="form-select" id="exampleFormControlSelect1"
                                                    name="category_id">
                                                    @foreach ($allCategory as $categories)
                                                        <option value="{{ $categories->id }}">{{ $categories->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>Image</label>
                                                <input type="file" class="form-control" id="imageInput" name="image" />
                                                <img id="imagePreview" src="#" alt="Preview"
                                                    style="max-width: 200px; display: none;" class="img-fluid mt-4">
                                            </div>
                                            <div class="card-footer mt-3 d-flex justify-content-start">
                                                <button type="submit" class="btn btn-success me-1"
                                                    id="CKsubmitButton">Submit</button>
                                                <button class="btn btn-danger" id="CKdiscardButton">Discard</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
