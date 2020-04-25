@extends('layouts.auth')

@section('pageTitle', 'Verifikasi Email')

@section('style')
    <!-- CSS Libraries -->
@endsection

@section('content')
    <div class="card card-primary">
        <div class="card-header"><h4>Verifikasi Email Anda</h4></div>

        <div class="card-body">
            @if (session('resent'))
                <div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
                        Link baru untuk verifikasi email telah dikirimkan ke email Anda.
                    </div>
                </div>
            @endif
            <p>
                Silahkan melakukan konfirmasi email yang telah kami kirimkan ke email Anda terlebih dahulu.<br><br>
                Bila dalam beberapa menit Anda belum juga menerima email tersebut, mohon periksa folder spam/bulk/junk pada email Anda.<br><br>
                Atau klik tombol di bawah untuk melakukan <i>request</i> ulang.
            </p>
            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                @csrf        
                <button type="submit" class="btn btn-primary btn-lg btn-block">
                    Kirim Ulang
                </button>                
            </form>
        </div>
    </div>
@endsection

@section('script')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endsection