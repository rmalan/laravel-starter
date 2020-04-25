@extends('layouts.auth')

@section('pageTitle', 'Konfirmasi Kata Sandi')

@section('style')
    <!-- CSS Libraries -->
@endsection

@section('content')
    <div class="card card-primary">
        <div class="card-header"><h4>Konfirmasi Kata Sandi</h4></div>

        <div class="card-body">
            <p class="text-muted">Silahkan masukkan kata sandi Anda sebelum melanjutkan</p>
            <form method="POST" action="{{ route('password.confirm') }}" class="needs-validation" novalidate="">
                @csrf
                
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
                    <input id="password" type="password" class="form-control" name="password" tabindex="1" required autocomplete="current-password">
                    <div class="invalid-feedback">
                        Masukkan kata sandi!
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        Konfirmasi Kata Sandi
                    </button>
                </div>
                @error('password')
                    <div class="text-center p-t-12 text-danger">
                        <span class="txt2">
                            <p>Kata sandi yang Anda masukkan salah!</p>
                        </span>						
                    </div>
                @enderror
            </form>
        </div>
    </div>
@endsection

@section('script')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endsection