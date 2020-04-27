@extends('layouts.error')

@section('pageTitle', '429')

@section('content')
    <div class="page-error">
        <div class="page-inner">
            <h1>429</h1>
            <div class="page-description">
                Terlalu banyak <i>requests</i>.
            </div>
            <div class="page-search">
                <div class="mt-3">
                    <a href="{{ url('/') }}">Kembali ke Dashboard</a>
                </div>
            </div>
        </div>
    </div>
@endsection