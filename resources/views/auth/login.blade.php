@extends('layouts.app')

@section('content')
<div class="row justify-content-center" style="min-height: 80vh;">
    <div class="col-md-6">

        <div class="card shadow-lg border-0 rounded-4" style="margin-top: 7rem">
            <div class="card-body p-4">

                <h3 class="text-center mb-4 fw-bold">Login</h3>

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" 
                            class="form-control form-control-lg rounded-3" 
                            placeholder="Enter your email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password</label>
                        <input type="password" name="password" 
                            class="form-control form-control-lg rounded-3" 
                            placeholder="Enter your password" required>
                    </div>

                    <button class="btn btn-primary w-100 py-2 rounded-3 fw-semibold">
                        Login
                    </button>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection