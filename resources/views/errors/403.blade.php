@extends('layouts.error')

@section('pageTitle', '403')

@section('content')
    <div class="page-error">
        <div class="page-inner">
            <h1>403</h1>
            <div class="page-description">
                Maaf, Anda tidak memiliki <i>permission</i> untuk mengakases halaman ini.
            </div>
            <div class="page-search">
                <div class="mt-3">
                    <a href="{{ url('/') }}">Kembali ke Dashboard</a>
                </div>
            </div>
        </div>
    </div>
@endsection