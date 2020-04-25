@extends('layouts.auth')

@section('pageTitle', 'Lupa Kata Sandi')

@section('style')
    <!-- CSS Libraries -->
@endsection

@section('content')
    <div class="card card-primary">
        <div class="card-header"><h4>Lupa Kata Sandi</h4></div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
                        Link telah dikirim ke email Anda.
                    </div>
                </div>
            @endif
            <p class="text-muted">Kami akan mengirimkan link untuk mengatur ulang kata sandi Anda</p>
            <form method="POST" action="{{ route('password.email') }}" class="needs-validation" novalidate="">
                @csrf
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    <div class="invalid-feedback">
                        Masukkan email Anda!
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        Kirim Link
                    </button>
                </div>
                @error('email')
                    <div class="text-center p-t-12 text-danger">
                        <span class="txt2">
                            <p>Email tidak terdaftar!</p>
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