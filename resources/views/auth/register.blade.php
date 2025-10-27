@extends('layouts.frontend') 

@section('content')
<div class="container py-120">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0 text-white">Register</h4>
                </div>
                <div class="card-body">

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input id="name" type="text" 
                                class="form-control @error('name') is-invalid @enderror" 
                                name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                name="email" value="{{ old('email') }}" required autocomplete="username">
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input id="password_confirmation" type="password" 
                                class="form-control @error('password_confirmation') is-invalid @enderror" 
                                name="password_confirmation" required autocomplete="new-password">
                            @error('password_confirmation')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('login') }}" class="text-decoration-none">
                                Already registered?
                            </a>
                            <button type="submit" class="btn btn--base">Register</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
