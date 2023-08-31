@extends('layouts.master')

@section("judul", "Data dokter")
@section("warnadokter", "active")
@section("title", "dokter")

@section('content')
    <div id="tambahdokter" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Form Tambah Dokter</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('dokter.store', []) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama Dokter</label>
                            <input id="name" class="form-control" type="text" name="name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" class="form-control" type="email" name="email">
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input id="username" class="form-control" type="text" name="username">
                        </div>
                        <div class="form-group">
                            <label for="username">Password</label>
                            <input id="username" class="form-control" type="password" name="password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            Tambah Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#tambahdokter">Tambah Dokter</button>
            </div>


            <div class="card-body">
                <table class="table table-hover table-striped table-sm table-bordered">
                    <thead>
                        <th>No</th>
                        <th>Nama Dokter</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>aksi</th>
                    </thead>

                    <tbody>
                        @foreach ($dokter as $item)
                            
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->username }}</td>

                            <td>
                                <form action="{{ route('dokter.destroy', [$item->id]) }}" method="post">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit" onclick="return confirm('Yakin ingin diapus?')" class="badge badge-danger py-1 border-0">
                                        <i class="fa fa-trash"></i> Hapus
                                    </button>
                                </form>

                                <button class="badge py-1 border-0 badge-info" type="button" data-toggle="modal" data-target="#ubah{{ $item->id }}">
                                <i class="fa fa-edit"></i> Ubah
                                </button>
                            </td>
                        </tr>

                        <div id="ubah{{ $item->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="my-modal-title">Ubah Data Dokter</h5>
                                        <button class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('dokter.update', [$item->id]) }}" method="post">
                                        @csrf
                                        @method("PUT")
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="name">Nama Dokter</label>
                                                <input id="name" class="form-control" type="text" name="name" value="{{ $item->name }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input id="email" class="form-control" type="email" name="email" value="{{ $item->email }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="username">Username</label>
                                                <input id="username" class="form-control" type="text" name="username" value="{{ $item->username }}">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">
                                                Ubah Data
                                            </button>
                                        </div>
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>

@endsection