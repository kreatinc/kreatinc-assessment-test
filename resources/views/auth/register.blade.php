@extends('app.layout')
@section('content')

<div class="row justify-content-center">
    <div class="col-5">
        <h1 class="text-center my-4">Login</h1>
        <form action="{{ route('register') }}" method="POST" class="form-control p-4 bg-light text-dark">
            <div class="row ">
                @if (session('message'))
                    <div class="col-12 alert alert-danger mb-4">
                        {{ session('message') }}
                    </div>
                @endif
                @csrf
                <div class="col-12 mb-4">
                    <input type="text" name="name" id="name" placeholder="Enter yout Full name" class="form-control form-control-lg">
                    @error('name')
                            <p class="text-danger mt-2">
                                {{ $message }}
                            </p>
                        @enderror
                </div>
                <div class="col-12 mb-4">
                    <input type="email" name="email" id="email" placeholder="Enter your email" class="form-control form-control-lg">
                    @error('email')
                            <p class="text-danger mt-2">
                                {{ $message }}
                            </p>
                        @enderror
                </div>
                <div class="col-12 mb-4">
                    <input type="password" name="password" id="password" placeholder="Create new  password" class="form-control form-control-lg">
                    @error('password')
                            <p class="text-danger mt-2">
                                {{ $message }}
                            </p>
                        @enderror
                </div>
                <div class="col-12 mb-4">
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirme password" class="form-control form-control-lg">
                    @error('password_confirmation')
                            <p class="text-danger mt-2">
                                {{ $message }}
                            </p>
                        @enderror
                </div>
                <div class="col-12 mb-4 text-center">
                    <button class="btn btn-secondary w-50">Create new account </button>
                </div>
                <div class="col-12 mb-4 text-center">
                    <a href="{{ route('facebook.redirect') }}" class="btn btn-primary w-50">Login with facebook </a>
                </div>
            </div>
        </form>
    </div>
</div>
    
@endsection