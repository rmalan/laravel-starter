@extends('layouts.error')

@section('pageTitle', '503')

@section('content')
    <div class="page-error">
        <div class="page-inner">
            <h1>503</h1>
            <div class="page-description">
                Layanan tidak tersedia.
            </div>
            <div class="page-search">
                <div class="mt-3">
                    <a href="{{ url('/') }}">Kembali ke Dashboard</a>
                </div>
            </div>
        </div>
    </div>
@endsection