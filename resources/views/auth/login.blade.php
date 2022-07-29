@extends('app.layout')
@section('content')

    <div class="row justify-content-center">
        <div class="col-5">
            <h1 class="text-center my-4">Login</h1>
            <form action="{{ route('login')}}" method="POST" class="form-control p-4 bg-light text-dark">
                <div class="row ">
                    @if (session('error'))
                        <div class="col-12 alert alert-danger mb-4">
                            {{ session('error') }}
                        </div>
                    @endif
                    @csrf
                    <div class="col-12 mb-4">
                        <input type="email" name="email" id="email" placeholder="Enter your email" class="form-control form-control-lg">
                        @error('email')
                            <p class="text-danger mt-2">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="col-12 mb-4">
                        <input type="password" name="password" id="password" placeholder="Enter your password" class="form-control form-control-lg">
                        @error('email')
                            <p class="text-danger mt-2">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="col-12 mb-4 text-center">
                        <button class="btn btn-secondary w-50">Login </button>
                    </div>
                    <div class="col-12 mb-4 text-center">
                        <a href="{{ route('facebook.redirect') }}" class="btn btn-primary w-50">Login with facebook </a>
                    </div>
                    <div class="col-12 text-center">
                        <a href='{{route("register")}}' class="btn btn-outline-primary w-50">Create Account</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
@endsection