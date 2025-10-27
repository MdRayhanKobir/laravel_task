@extends('layouts.frontend')

@section('content')
<div class="container py-120">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Login</h4>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                name="password" required>
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                       
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                            <label class="form-check-label" for="remember_me">Remember me</label>
                        </div>

                
                        <div class="d-flex justify-content-end align-items-center mb-3">
                            <button type="submit" class="btn btn--base">Log in</button>
                        </div>

                        <div class="text-center">
                            <p class="mb-0">
                                Don’t have an account? 
                                <a href="{{ route('register') }}" class="text-decoration-none fw-bold">Register here</a>
                            </p>
                        </div>
                        <hr>
                        <div class="text-center">
                            <h5>Demo Access</h5>
                            <p>Email: testuser@gmail.com</p>
                            <p>Password: 12345678</p>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
