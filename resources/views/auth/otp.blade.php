@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center">

            </div>
            <div class="card">
                <div class="bg-primary text-white card-header">
                    <h3 class="text-center pt-1">One time password</h3>
                    <h4>Your one time password has been emailed to you</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('otp-auth') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right"><strong>{{ __('OTP') }}</strong></label>

                            <div class="col-md-6">
                                <input id="otp" type="text" class="form-control @error('error') is-invalid @enderror" name="otp"  required autofocus>

                                @if (Session::has('error'))
                                    <strong class="text-danger">{{ Session::get('error') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                <a href="{{ route('send-otp') }}">Resend OTP</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
