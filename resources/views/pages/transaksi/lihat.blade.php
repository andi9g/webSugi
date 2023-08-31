@extends('layouts.master')

@section("judul", "Data transaksi")
@section("warnatransaksi", "active")
@section("title", "transaksi")

@section('content')
    

    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <a href="{{ url('transaksi', []) }}" class="btn btn-danger">Kembali</a>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body {{ $warna }} text-center">
                        <h2 class="my-0 py-0">{{ $invoice }}</h2>

                    </div>
                </div>


                @php
                    $total = 0;
                @endphp
                @foreach ($detail as $item)
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="{{ url('gambar/produk', [$item->produk->gambar]) }}" width="100%" class="rounded-lg" alt="">
                                </div>
                                <div class="col-md-8">
                                    <h5>{{ strtoupper($item->produk->namaproduk) }}</h5>
                                    <p class="my-0 py-0">{{ $item->produk->deskripsi1 }}</p>
                                    
                                    <table class="table table-sm table-striped text-md">
                                        <tr>
                                            <td width="40%">Jumlah Beli</td>
                                            <td class="text-bold">x{{ $item->jumlah }}</td>
                                        </tr>
                                        <tr>
                                            <td width="40%">Harga</td>
                                            <td class="text-bold">Rp{{ number_format($item->produk->harga,0,',','.') }}</td>
                                        </tr>
                                        @php
                                            $total = $total + ($item->jumlah * $item->produk->harga);
                                        @endphp
                                    </table>
                                    
                                    <p class="my-0 py-0 badge badge-secondary">{{ $item->produk->kategori->namakategori }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="card">
                    <div class="card-body text-bold">
                        <h1>TOTAL : Rp{{ number_format($total,0,',','.') }}</h1>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
@endsection