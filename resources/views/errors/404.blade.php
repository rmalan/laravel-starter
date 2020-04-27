@extends('layouts.error')

@section('pageTitle', '404')

@section('content')
    <div class="page-error">
        <div class="page-inner">
            <h1>404</h1>
            <div class="page-description">
                Maaf, halaman ini ditemukan.
            </div>
            <div class="page-search">
                <div class="mt-3">
                    <a href="{{ url('/') }}">Kembali ke Dashboard</a>
                </div>
            </div>
        </div>
    </div>
@endsection