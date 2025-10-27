@extends('layouts.frontend')

@section('content')
<div class="container py-120">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0 text-white">Confirm Password</h4>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">
                        This is a secure area of the application. Please confirm your password before continuing.
                    </p>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        {{-- Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" 
                                class="form-control @error('password') is-invalid @enderror"
                                name="password" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn--base">
                                Confirm
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
