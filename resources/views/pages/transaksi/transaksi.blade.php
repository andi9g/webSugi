@extends('layouts.master')

@section("judul", "Data transaksi")
@section("warnatransaksi", "active")
@section("title", "transaksi")

@section('content')
    

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-secondary">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-8">
                                
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
                                <th>INVOICE</th>
                                <th>Nama Pembeli</th>
                                <th>Total Bayar</th>
                                <th>Status</th>
                                <th>detail</th>
                                <th>aksi</th>
                            </thead>


                            <tbody>
                                @foreach ($invoice as $item)
                                    <tr>
                                        <td>{{ $loop->iteration + $invoice->firstItem() - 1}}</td>
                                        <td>{{ $item->invoice }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->total }}</td>
                                        <td>
                                            @if ($item->status == "success")
                                                <font class="text-success">TERBAYAR</font>
                                            @elseif ($item->status == "pending")
                                                <font class="text-warning">BELUM DIBAYAR</font>
                                            @elseif ($item->status == "fail")
                                                <font class="text-danger">GAGAL</font>
                                            @endif
                                        </td>
                                        <td><a href="{{ route('lihat.invoice', [$item->invoice]) }}" class="badge badge-info">
                                            <i class="fa fa-eye"></i> Detail Pembelian
                                        </a></td>

                                        <td>
                                            <button class="badge py-1 border-0 badge-success" type="button" data-toggle="modal" data-target="#ubahstatus{{ $item->idinvoice }}">
                                                <i class="fa fa-check"></i> Kirim Status
                                            </button>
                                        </td>
                                    </tr>

                                    <div id="ubahstatus{{ $item->idinvoice }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="my-modal-title">Status</h5>
                                                    <button class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('kirim.notifikasi', [$item->iduser]) }}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
    
                                                        <div class="form-group">
                                                            <label for="invoice">INVOICE</label>
                                                            <input id="invoice" readonly class="form-control" type="text" name="invoice" value="{{ $item->invoice }}">
                                                        </div>
    
                                                        <div class="form-group">
                                                            <label for="status">Status</label>
                                                            <select id="status" class="form-control" name="status">
                                                                <option value="Barang sedang dikemas">Barang sedang dikemas</option>
                                                                <option value="Barang telah dikirim">Barang telah dikirim</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success">
                                                            Kirim
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
        </div>
    </div>
    
@endsection