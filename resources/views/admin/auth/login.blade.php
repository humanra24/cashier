@extends('admin.auth.base')

@section('content')
    <div class="col-lg-5">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header">
                <h3 class="text-center font-weight-light my-4">Admin Login</h3>
            </div>
            <div class="card-body">
                @error('error')
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <strong>{{ $message }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @enderror
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <strong>{{ session('success') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form method="post" action="{{ route('admin-login') }}">
                    @csrf
                    <div class="form-floating mb-3">
                        <input class="form-control @error('email') is-invalid @enderror" id="inputEmail" name="email"
                            type="email" placeholder="name@example.com" value="{{ old('email') }}" />
                        <label for="inputEmail">Email address</label>
                        @error('email')
                            <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control @error('password') is-invalid @enderror" id="inputPassword"
                            name="password" type="password" placeholder="Password" autocomplete="off" />
                        <label for="inputPassword">Password</label>
                        @error('password')
                            <div id="passwordHelp" class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" name="remember" id="inputRememberPassword" type="checkbox" />
                        <label class="form-check-label" for="inputRememberPassword">Remember
                            Password</label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <a class="small" href="password.html">Forgot Password?</a>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center py-3">
                <div class="small"><a href="register.html">Need an account? Sign up!</a></div>
            </div>
        </div>
    </div>
@endsection
