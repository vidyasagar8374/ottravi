@extends('layouts.auth')

@section('content')
    <x-auth-card>
        <div class="container">
           <a href="{{ route('frontend.index') }}"> <img src="{{ asset('dashboard/images/') }}" alt=""></a>
        </div>

        <div class="my-4">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="mt-1" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="d-flex align-items-center justify-content-center mt-4">
                <x-button class="w-100">
                    {{ __('Email Password Reset Link') }}
                </x-button>
            </div>
        </form>
        <div class="container pt-2">
          <p>return to <a href="{{ route('login') }}">Login</a></p>
        </div>
    </x-auth-card>
@endsection
