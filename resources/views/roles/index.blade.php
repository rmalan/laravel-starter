@extends('layouts.app')

@section('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
        </div>

        @if(session('message'))
        <div class="alert alert-success alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>×</span>
                </button>
                {{ session('message') }}
            </div>
        </div>
        @endif

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Roles</h4>
                            @can('roles-create')
                                <div class="card-header-action">
                                    <a href="{{ url('roles/create') }}" class="btn btn-icon btn-primary"><i class="fas fa-plus"></i></a>
                                </div>
                            @endcan
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="datatable">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                No.
                                            </th>
                                            <th>Nama</th>
                                            <th>Permissions</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1
                                        @endphp
                                        
                                        @foreach ($roles as $role)
                                        <tr>
                                            <td class="text-center">{{ $no++ }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td>
                                                @foreach ($role->permissions as $permission)
                                                    <span class="badge badge-light">{{ $permission->name }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                @can('roles-update')
                                                    <a href="{{ url('/roles/' .$role->id. '/edit') }}" class="btn btn-icon btn-warning"><i class="far fa-edit"></i></a>
                                                @endcan
                                                @can('roles-delete')
                                                    <button class="btn btn-icon btn-danger" data-confirm="Yakin?|Apakah Anda yakin akan menghapus data ini?" data-confirm-yes="event.preventDefault(); document.getElementById('delete-{{ $role->id }}').submit();"><i class="fas fa-times"></i></button>
                                                    <form id="delete-{{ $role->id }}" action="{{ url('/roles/' .$role->id) }}" method="post" style="display: none;">
                                                        @method('delete')
                                                        @csrf
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <!-- JS Libraies -->
    <script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('assets/modules/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>
@endsection