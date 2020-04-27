@extends('layouts.error')

@section('pageTitle', '419')

@section('content')
    <div class="page-error">
        <div class="page-inner">
            <h1>419</h1>
            <div class="page-description">
                Maaf, halaman kadaluarsa.
            </div>
            <div class="page-search">
                <div class="mt-3">
                    <a href="{{ url('/') }}">Kembali ke Dashboard</a>
                </div>
            </div>
        </div>
    </div>
@endsection