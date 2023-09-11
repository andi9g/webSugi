@extends('layouts.umum')

@section('content')
<div class="row">
  <div class="col-md-12">
    <a href="{{ url('/beranda', []) }}" class="btn btn-secondary">Back to Beranda</a>
  </div>
</div>
    <div class="row">
      <div class="col-md-5">
          <img src="{{ url('gambar/produk', [$produk->gambar]) }}" width="100%" alt="">
      </div>
      <div class="col-md-7">
          <h4>{{ $produk->namaproduk }}</h4>
          <p><b>{{ $produk->deskripsi1 }}</b></p>
          <p>{{ $produk->deskripsi2 }}</p>
          <h5>Stok {{ $produk->stok }}</h5>
          @php
              $diskon = $produk->harga - ($produk->harga * ($produk->diskon / 100));
          @endphp
          @if ($produk->diskon > 0)
          <h3>
            <strike>
              Rp{{ number_format($produk->harga, 0, ",",".") }}
            </strike>
            Rp{{ number_format($diskon, 0, ",",".") }}
            
          </h3>
          
          @else   

          Rp{{ number_format($produk->harga, 0, ",",".") }}
              
          @endif
          <div class="row">
            <div class="col-md-6">
              <form action="{{ route('tambah.keranjang', [$produk->idproduk]) }}" method="post" class="d-inline">
                @csrf
                    <button type="submit" class="btn btn-success btn-block">
                      <i class="fa fa-cart-shopping"></i> Tambah Keranjang
                    </button>
                </form>
              </div>

              <div class="col-md-6">
                  <form action="{{ route('tambah.pembelian', [$produk->idproduk]) }}" method="post" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-secondary btn-block">
                      <i class="fa fa-pay"></i>Beli Sekarang
                    </button>
                  </form>
              </div>

          </div>
      </div>
    </div>
@endsection