@extends('layouts.master')

@section("judul", "Data Produk")
@section("warnaproduk", "active")
@section("title", "Produk")

@section('content')
    <div id="tambahproduk" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Form Tambah Produk</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('produk.store', []) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="namaproduk">Nama Produk</label>
                            <input id="namaproduk" class="form-control" type="text" name="namaproduk">
                        </div>
                        <div class="form-group">
                            <label for="deskripsi1">Penjelasan Singkat</label>
                            <input id="deskripsi1" class="form-control" type="text" name="deskripsi1">
                        </div>
                        <div class="form-group">
                            <label for="namaproduk">Deskripsi</label>
                            <textarea name="deskripsi2" id="" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <select id="kategori" class="form-control" name="idkategori">
                                @foreach ($kategori as $item)
                                <option value="{{ $item->idkategori }}">{{ $item->namakategori }}</option>
                                    
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga Produk</label>
                            <input id="harga" class="form-control" type="number" name="harga">
                        </div>
                        <div class="form-group">
                            <label for="stok">Stok Produk</label>
                            <input id="stok" class="form-control" type="number" name="stok">
                        </div>
    
                        <div class="form-group">
                            <label for="gambar">Gambar Produk</label>
                            <input id="gambar" class="form-control" type="file" name="gambar">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Tambah Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-secondary">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-8">
                                <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#tambahproduk">Tambah Produk</button>
                            </div>
                            <div class="col-md-4">
                                <form action="{{ url()->current() }}" method="get">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="berdasarkan nama" aria-label="Recipient's username" aria-describedby="button-addon2" name="keyword">
                                        <div class="input-group-append">
                                          <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Cari</button>
                                        </div>
                                      </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-hover table-striped table-bordered">
                            <thead>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Gambar</th>
                                <th>Harga</th>
                                <th>Diskon</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </thead>

                            <tbody>
                                @foreach ($produk as $item)
                                    <tr>
                                        <td width="1px">{{ $loop->iteration + $produk->firstItem() - 1 }}</td>
                                        <td>{{ $item->namaproduk }}</td>
                                        <td>{{ $item->kategori->namakategori }}</td>
                                        <td>
                                            <button class="badge py-1 border-0 badge-info" type="button" data-toggle="modal" data-target="#gambar{{ $item->idproduk }}">
                                                <i class="fa fa-eye"></i> Lihat
                                            </button>
                                        </td>
                                        <td>
                                            Rp{{ number_format($item->harga, 0, ",",".") }}
                                        </td>
                                        <td width="5px">
                                            <form action="{{ route('ubahdiskon', [$item->idproduk]) }}" method="post">
                                                @csrf
                                                <input type="number" onchange="submit()" value="{{ $item->diskon }}" class="form-control-sm form-control d-inline" style="width: 70px !important">
                                            </form>
                                        </td>
                                        <td>
                                            <button class="badge py-1 border-0 badge-secondary" type="button" data-toggle="modal" data-target="#detail{{ $item->idproduk }}">
                                                <i class="fa fa-eye"></i> Deskripsi
                                            </button>
                                        </td>

                                        <td>
                                            <form action="{{ route('produk.destroy', [$item->idproduk]) }}" method="post" class="d-inline">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" class="badge badge-danger border-0 py-1" onclick="return confirm('yakin ingin dihapus?')">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>

                                            <button class="badge py-1 border-0 badge-primary" type="button" data-toggle="modal" data-target="#ubah{{ $item->idproduk }}">
                                                <i class="fa fa-edit"></i> Ubah
                                            </button>
                                        </td>
                                    </tr>

                                    <div id="ubah{{ $item->idproduk }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="my-modal-title">Ubah Data</h5>
                                                    <button class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('produk.update', [$item->idproduk]) }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    @method("PUT")
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="namaproduk">Nama Produk</label>
                                                            <input id="namaproduk" class="form-control" type="text" value="{{ $item->namaproduk }}" name="namaproduk">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="kategori">Kategori</label>
                                                            <select id="kategori" class="form-control" name="idkategori">
                                                                @foreach ($kategori as $it)
                                                                <option value="{{ $it->idkategori }}" @if ($item->idkategori == $it->idkategori)
                                                                    selected
                                                                @endif>{{ $it->namakategori }}</option>
                                                                    
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="deskripsi1">Penjelasan Singkat</label>
                                                            <input id="deskripsi1" class="form-control" type="text" value="{{ $item->deskripsi1 }}" name="deskripsi1">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="namaproduk">Deskripsi</label>
                                                            <textarea name="deskripsi2" id="" class="form-control" rows="3">{{ $item->deskripsi2 }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="harga">Harga Produk</label>
                                                            <input id="harga" class="form-control" value="{{ $item->harga }}" type="number" name="harga">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="stok">Stok Produk</label>
                                                            <input id="stok" class="form-control" type="number" value="{{ $item->stok }}" name="stok">
                                                        </div>
                                    
                                                        <div class="form-group">
                                                            <label for="gambar">Gambar Produk</label>
                                                            <input id="gambar" class="form-control" type="file" name="gambar">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success">Ubah Data</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="detail{{ $item->idproduk }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="my-modal-title">Deskripsi</h5>
                                                    <button class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><b>{{ $item->deskripsi1 }}</b></p>
                                                    <p>{{ $item->deskripsi2 }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="gambar{{ $item->idproduk }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="my-modal-title">View Gambar</h5>
                                                    <button class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <img src="{{ url('/gambar/produk', [$item->gambar]) }}" width="100%" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer">
                        {{ $produk->links("vendor.pagination.bootstrap-4") }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection