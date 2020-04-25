@extends('layouts.app')

@section('style')
    <!-- CSS Libraries -->
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
        </div>

        @if (session('status'))
            <div class="alert alert-success alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>×</span>
                    </button>
                    Kata sandi telah berhasil diatur ulang.
                </div>
            </div>
        @endif

        <div class="section-body">
        </div>
    </section>
@endsection

@section('script')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endsection