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
                            <h4>Data Grup Pengguna</h4>
                            <div class="card-header-action">
                                <button class="btn btn-icon btn-primary create-user-group" data-toggle="modal" data-target="#dataModal"><i class="fas fa-plus"></i></button>
                            </div>
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
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1
                                        @endphp
                                        
                                        @foreach ($userGroups as $userGroup)
                                        <tr>
                                            <td class="text-center">{{ $no++ }}</td>
                                            <td>{{ $userGroup->name }}</td>
                                            <td>
                                                <button class="btn btn-icon btn-warning edit-user-group" data-toggle="modal" data-target="#dataModal" data-id="{{ $userGroup->id }}"><i class="far fa-edit"></i></button>
                                                <button class="btn btn-icon btn-danger" data-confirm="Yakin?|Apakah Anda yakin akan menghapus data ini?" data-confirm-yes="event.preventDefault(); document.getElementById('delete').submit();"><i class="fas fa-times"></i></button>
                                                <form id="delete" action="{{ url('/user-groups/' .$userGroup->id) }}" method="post" style="display: none;">
                                                    @method('delete')
                                                    @csrf
                                                </form>
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

    <div class="modal fade" tabindex="-1" role="dialog" id="dataModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="#">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama</label>
                            <input id="nama" name="nama" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="submit" class="btn btn-icon icon-left btn-primary"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>    
@endsection

@section('script')
    <!-- JS Libraies -->
    <script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('assets/modules/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>
    <script>
        $('.create-user-group').click(function(){
            $('.modal-title').html('Tambah Data Grup Pengguna');
            $('#edit').remove();
            $('.modal-content form').attr('action', '{{ url('/user-groups/') }}');
            $('#nama').val('');
        });

        $('.edit-user-group').click(function(){
            let id = $(this).data('id');

            $('.modal-title').html('Ubah Data Grup Pengguna');  
            $('#edit').remove();
            $('.modal-content form').prepend('<input id="edit" type="hidden" name="_method" value="patch">');
            $('.modal-content form').attr('action', '{{ url('/user-groups/') }}/' +id);
            
            $.ajax({
                type: 'get',
                url: '{{ url('/user-groups/') }}/' +id,
                dataType: 'json',
                success: function(data) {
                    $('#nama').val(data.userGroup.name);
                }
            });
        });
    </script>
@endsection