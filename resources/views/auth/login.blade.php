@extends('layouts.initial')
@section('content')

<div class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="/"><img alt="logo" src="{{ asset('dist/img/logo.png') }}" height="100" width="100"> </a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                {{--  <div class="card-header">{{ __('Login') }}
            </div> --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="input-group mb-2">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        placeholder="Email" name="email" value="{{ old('email') }}" required autocomplete="email"
                        autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="Password" name="password" required autocomplete="current-password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="icheck-primary">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-6">
                       <div class="row">                         
                            <div class="col-md-6 p-0 m-0">
                                {{-- <a type="button" class="btn btn-danger" href="{{ route('register') }}">Sign Up</a>                                 --}}
                            </div>
                            <div class="col-md-6 p-0 m-0">
                                <button type="submit" class="btn btn-primary ">Sign In</button>
                            </div>
                       </div>

                    </div>

                    <!-- /.col -->
                </div>
                {{--  <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Login') }}
                </button>

                @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
                @endif
        </div>
    </div> --}}
    </form>
</div>
</div>
</div>
</div>
</div>

@endsection