@extends('layouts.admin')

@section('custom-header')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Profile</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    {{-- ?? --}}
                    <li class="nav-item">
                        <a href="{{ route('profile.edit', $user->id) }}">Profile</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item active">
                        <a>Edit Profile</a>
                    </li>
                </ul>
            </div>
            {{-- Content --}}
            <form method="POST" action="{{ route('profile.update', $user->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-xl-4">
                        <div class="card mb-4 mb-xl-0">
                            <div class="card-header">Profile Picture</div>
                            <div class="card-body text-center">
                                <img class="img-account-profile rounded-circle mb-3"
                                    src="{{ $user->image ? asset('storage/images/' . $user->image) : asset('img/default.jpeg') }}"
                                    alt="Profile Picture" id="pictPreview">
                                <div class="small font-italic text-muted mb-4">JPEG, JPG, or PNG no larger than 2 MB</div>
                                <label class="btn btn-dark text-light">
                                    Upload new image
                                    <input type="file" class="d-none" name="image" id="pictInput">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="card mb-4">
                            <div class="card-header">Account Details</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputUsername">Full Name</label>
                                    <input class="form-control" id="inputUsername" type="text"
                                        value="{{ $user->name }}" placeholder="Enter your new name" name="name">
                                </div>
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputBio">Bio</label>
                                    <textarea class="form-control" id="inputBio" rows="5" placeholder="Enter your new bio" name="bio">{{ $user->bio }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputEmailAddress">Email</label>
                                    <input class="form-control" id="inputEmailAddress" type="email"
                                        value="{{ $user->email }}" placeholder="Enter your new email" name="email">
                                </div>
                                <div class="row gx-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputPassword">New Password</label>
                                        <div class="position-relative">
                                            <input class="form-control pe-5" id="inputPassword" type="password"
                                                placeholder="Enter your new password" name="password">
                                            <i class="fa fa-eye position-absolute top-50 end-0 translate-middle-y pe-3"
                                                id="togglePassword"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputConfirmPassword">Confirm Password</label>
                                        <div class="position-relative">
                                            <input class="form-control" id="inputConfirmPassword" type="password"
                                                placeholder="Enter your confirm password" name="password_confirmation">
                                            <i class="fa fa-eye position-absolute top-50 end-0 translate-middle-y pe-3"
                                                id="toggleConfirmPassword"></i>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-success" type="submit" id="submitButton">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('custom-footer')
    <script src="{{ asset('js/togglePassword.js') }}"></script>
@endsection
