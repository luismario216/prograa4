@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register.user') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <img src="/storage/imagenes/iconos/logo.jpg" alt="logo" class="img-fluid">
                            </div>
                            <div class="col-md-8">
                                @if (session('newUser'))
                                    <input type="hidden" name="name" value="{{ session('newUser')->getName() }}" >
                                    <input type="hidden" name="last_name" value=" " >
                                    <input type="hidden" name="email" value="{{ session('newUser')->getEmail() }}" >

                                    <div class="row mb-3">
                                        <label for="number" class="col-md-4 col-form-label text-md-end">{{ __('Number') }}</label>

                                        <div class="col-md-6">
                                            <input id="number" type="text" class="form-control @error('number') is-invalid @enderror" name="number" value="{{ old('number') }}" required autocomplete="number">

                                            @error('number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Register') }}
                                            </button>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-danger" role="alert">
                                        {{ __('No se pudo registrar el usuario porque no se ha encontrado la cuenta de Google.') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
