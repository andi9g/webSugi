@extends('layouts.umum')

@section("aberanda", "active")

@section('content')
    <div class="row mb-2">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <form action="{{ url()->current() }}" method="GET">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Cari.." aria-label="Recipient's username" name="keyword" value="{{ $keyword }}" aria-describedby="button-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-success" type="submit" id="button-addon2">
                        <i class="fa fa-user"></i> Pencarian
                      </button>
                    </div>
                  </div>
            </div>
            
            </form>
        
    </div>

    <div class="row">
        @foreach ($produk as $item)
        <div class="col-md-4">
            <div class="card" style="width: 18rem;">
                <img src="{{ url('gambar/produk', [$item->gambar]) }}" class="card-img-top" style="max-height: 450px" alt="...">
                <div class="card-body">
                  <small class="badge badge-secondary">{{ $item->kategori->namakategori }}</small>
                    <h4><a href="{{ route('detail.produk', [$item->idproduk]) }}" class="link pl-0 ml-0" style="text-decoration: none">{{ $item->namaproduk }}</a></h4>
                    @if ($item->diskon > 0)
                    <h5>
                    <strike>Rp{{ number_format($item->harga, 0,",",".") }}</strike>
                    @php
                        $hargasetelahdiskon = $item->harga - ($item->harga * ($item->diskon/100));

                    @endphp
                    
                    Rp{{ number_format($hargasetelahdiskon, 0, ",",".") }}
                    </h5>
                        
                    @else 
                      <h5>Rp{{ number_format($item->harga, 0,",",".") }}</h5>
                    @endif
                    
                    
                  <p class="card-text">{{ $item->deskripsi1 }}</p>
                  
                  <a href="{{ route('detail.produk', [$item->idproduk]) }}" class="text-dark" style="text-decoration: none">Selengkapnya..</a>
                </div>
              </div>
        </div>
            
        @endforeach
    </div>
    <div class="row">
        <div class="col-md-12">
            {{ $produk->links("vendor.pagination.bootstrap-4") }}
        </div>
    </div>
@endsection