@extends('layouts.umum')

@section("judul", "Pembelian ({{ $invoice }})")
@section("anotifikasi", "active")
{{-- @section("title", "Data") --}}

@section('content')
    

    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <a href="{{ url('notifikasi', []) }}" class="btn btn-danger">Kembali</a>
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
                
                    <div class="card">
                        <div class="card-body">
                            @foreach ($detail as $item)
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="{{ url('gambar/produk', [$item->produk->gambar]) }}" width="100%" class="rounded-lg" alt="">
                                </div>
                                <div class="col-md-8">
                                    <h5>{{ strtoupper($item->produk->namaproduk) }}</h5>
                                    <p class="my-0 py-0">{{ $item->produk->deskripsi1 }}</p>
                                    
                                    <table class="table table-sm table-striped text-md my-0 py-0">
                                        <tr>
                                            <td width="40%">Jumlah Beli</td>
                                            <td class="text-bold">x{{ $item->jumlah }}</td>
                                        </tr>
                                        <tr>
                                            <td width="40%">Harga</td>
                                            <td class="text-bold">Rp{{ number_format(($item->produk->harga * $item->jumlah),0,',','.') }}</td>
                                        </tr>

                                    <p class="my-1 py-1 badge badge-secondary">{{ $item->produk->kategori->namakategori }}</p>
                                        @php
                                            $total = $total + ($item->jumlah * $item->produk->harga);
                                        @endphp
                                    </table>
                                    
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>

                <div class="card">
                    <div class="card-body text-bold">
                        <h1>TOTAL : Rp{{ number_format($total,0,',','.') }}</h1>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
@endsection