@extends('layouts.frontend') 

@section('content')
<div class="container py-120">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0 text-white">Forgot Password</h4>
                </div>
                <div class="card-body">

                    <p class="text-muted mb-4">
                        Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
                    </p>

                    {{-- Session Status --}}
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                Email Password Reset Link
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
