@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex flex-row">
        <div class="pt-2"><img class="img-fluid py-2" src="{{asset('assets/iconKunci.png')}}" alt="iconLock"></div>
        <div class="p-2">
            <h1 style="font-size: 2em;">Forgot Password ?</h1>
        </div>
    </div>
    <p class="description-text">Please enter the email address you used to create account and well send you al link to reset password</p>
    <hr class="ruler">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="form-outline mb-4">
            <label for="email" class="form-label">{{ __('Email Address') }}<span style="color:red;font-weight:bold"> *</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter your email" required autocomplete="email" autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary btn-block" style="width:100%;">
            {{ __('Send Password Reset Link') }}
        </button>
    </form>
</div>
@endsection
