@extends('layouts.auth')

@section('pageTitle', 'Masuk')

@section('content')
    <div class="card card-primary">
        <div class="card-header"><h4>Masuk</h4></div>

        <div class="card-body">
            <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
                @csrf
                <div class="form-group">
                    <label for="username">Nama Pengguna</label>
                    <input id="username" type="text" class="form-control" name="username" tabindex="1" value="{{ old('username') }}" required autocomplete="username" autofocus>
                    <div class="invalid-feedback">
                        Masukkan nama pengguna!
                    </div>
                </div>

                <div class="form-group">
                    <div class="d-block">
                        <label for="password" class="control-label">Kata Sandi</label>
                        @if (Route::has('password.request'))
                            <div class="float-right">
                                <a href="{{ route('password.request') }}" class="text-small">
                                    Lupa Kata Sandi?
                                </a>
                            </div>
                        @endif
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required autocomplete="current-password">
                    <div class="invalid-feedback">
                        Masukkan kata sandi!
                    </div>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="remember">Ingat Saya</label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        Masuk
                    </button>
                </div>
                @if($errors->any())
                    <div class="text-center p-t-12 text-danger">
                        <span class="txt2">
                            <p>Nama pengguna atau kata sandi yang Anda masukkan salah!</p>
                        </span>
                    </div>
                @endif
            </form>
        </div>
    </div>    
    @if (Route::has('register'))
        <div class="mt-5 text-muted text-center">
            Belum punya akun? <a href="{{ route('register') }}">Yuk buat!</a>
        </div>
    @endif
@endsection

@section('script')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endsection