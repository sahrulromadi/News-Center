<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="{{ asset('loginForm/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('loginForm/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('loginForm/css/style.css') }}" rel="stylesheet">

    <title>Register</title>
</head>

<body>
    <section class="form-02-main">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="_lk_de">
                        <div class="form-03-main">
                            <div class="logo">
                                <img src="{{ asset('img/user.png') }}">
                            </div>
                            <form method="POST" action="{{ route('register.submit') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control _ge_de_ol"
                                        placeholder="Enter Name" aria-required="true" required>
                                </div>

                                <div class="form-group">
                                    <input type="email" name="email" class="form-control _ge_de_ol" type="text"
                                        placeholder="Enter Email" aria-required="true" required>
                                </div>

                                <div class="form-group">
                                    <input type="password" name="password" class="form-control _ge_de_ol" type="text"
                                        placeholder="Enter Password" aria-required="true" required>
                                    <i class="fa fa-eye position-absolute" id="togglePassword"
                                        style="cursor: pointer; right: 20px; top: 50%; transform: translateY(-50%);"></i>
                                </div>

                                <div class="form-group">
                                    <input type="password" name="password_confirmation" class="form-control _ge_de_ol"
                                        type="text" placeholder="Confirm Password" aria-required="true" required>
                                    <i class="fa fa-eye position-absolute" id="toggleConfirmPassword"
                                        style="cursor: pointer; right: 20px; top: 50%; transform: translateY(-50%);"></i>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="_btn_04" id="loginButton">Register</button>
                                </div>

                                <div class="form-group nm_lk">
                                    <p>Or Login With</p>
                                </div>

                                <div class="form-group pt-0">
                                    <div class="_social_04">
                                        <ol>
                                            <li><i class="fa fa-facebook"></i></li>
                                            <li><i class="fa fa-twitter"></i></li>
                                            <li>
                                                <a href="{{ route('login') }}">
                                                    <i class="fa fa-google-plus"></i>
                                                </a>
                                            </li>
                                            <li><i class="fa fa-instagram"></i></li>
                                            <li><i class="fa fa-linkedin"></i></li>
                                        </ol>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('components.admin-footer')
    <script src="{{ asset('js/togglePassword.js') }}"></script>
</body>

</html>
