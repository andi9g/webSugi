@extends('layouts.umum')

@section("akeranjang", "active")

@section('content')
<div class="row">
  <div class="col-md-8">
    <h3>Keranjang Belanjaan</h3>
    <a href="{{ url('/beranda', []) }}" class="btn btn-secondary">Back to Beranda</a>
  </div>
  <div class="col-md-4 mt-3">
    <h4>
      <form action="{{ route('gunakan.point', []) }}" method="post">
        @csrf
        <div class="form-check">
          <input id="gunakanpoint" class="form-check-input" style="width:30px;height:30px" type="checkbox" onchange="submit()" @if (Session::get('point')==true)
              checked
          @endif>
          <label for="gunakanpoint" class="form-check-label ml-3 mt-1">Gunakan Point?</label>
        </div>
      </form>
      

    </h4>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
      <table class="table table-hover table-striped table-bordered">
        <thead>
          <th width="2px">No</th>
          <th>Nama Produk</th>
          <th>Jumlah</th>
          <th>Stok</th>
          <th>Harga Bayar</th>
        </thead>
        <tbody>
          @php
              $total = 0;

              $point = 0;
              $idku = Auth::user()->id;
              if (!empty(Auth::user())) {
                $pointku = DB::table("point")->where("iduser", $idku);
                if($pointku->count() == 1) {
                  $point = $pointku->first()->point;
                }
              }
          @endphp
          
          @foreach ($keranjang as $item)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->produk->namaproduk }}</td>
                <td width="20%">
                  <form action="{{ route('ubah.stok.keranjang', [$item->idproduk]) }}" method="post">
                    @csrf
                      <input type="number" name="jumlah" value="{{ $item->jumlah }}" id="" class="w-100 text-center" onchange="submit()">
                  </form>
                </td>
                <td>
                  

                  {{ $item->produk->stok - $item->jumlah }}
                </td>
                <td>
                  @php
                      if($item->produk->diskon >0 ) {
                        $diskon = $item->produk->harga - ($item->produk->harga * ($item->produk->diskon / 100));
                      }else {
                        $diskon = $item->produk->harga;

                      }
                  @endphp
                  Rp{{ number_format(($item->jumlah * $diskon), 0,",",".") }}</td>
                <td width="1px">
                  <form action="{{ route('keranjang.destroy.satuan', [$item->idkeranjang]) }}" method="post" class="d-inline">
                    @csrf
                    <button type="submit" onclick="return confirm('yakin ingin dihapus?')" class="badge badge-danger border-0 py-1">
                      <i class="fa fa-trash"></i>
                    </button>
                  </form>
                </td>
                @php
                  
                    if($item->produk->diskon >0 ) {
                      $diskon = $item->produk->harga - ($item->produk->harga * ($item->produk->diskon / 100));
                      $total = $total + ($item->jumlah * $diskon);
                    }else {
                      $total = $total + ($item->jumlah * $item->produk->harga);

                    }
                @endphp
              </tr>
          @endforeach
          @if (count($keranjang)===0)
              <tr>
                <td colspan="5" class="text-center">Tidak ada data pada keranjang anda</td>
              </tr>
          @endif
          @if (Session::get('point')==true)
              @php
                  $hitung = $total - $point;
                  if($hitung < 0) {
                    $total = 0;
                    $sisa = $hitung * -1;
                  }else {
                    $sisa = 0;
                    $total = $hitung;
                  }
              @endphp
              <tr>
                <th colspan="4" class="text-center">POINT YANG DIGUNAKAN</th>
                <th colspan="2">Rp{{ number_format($point,0,",",".") }}</th>
              </tr>

              <tr>
                <th colspan="4" class="text-center">SISA POINT</th>
                <th colspan="2">Rp{{ number_format($sisa,0,",",".") }}</th>
              </tr>
          @else
            @php
                $point = $total * 0.03;
            @endphp
              <tr>
                <th colspan="4">POINT YANG DIDAPATKAN</th>
                <th colspan="2">Rp{{ number_format($point, 0, ",",".") }}</th>
              </tr>
          @endif
          <tr>
            <th colspan="4" class="text-center"><b>TOTAL BAYAR</b></th>
            <th colspan="2"><b>Rp{{ number_format($total, 0,",",".") }}</b></th>
          </tr>
        </tbody>
      </table>
    <div class="card">
      <div class="card-footer text-right">
        <form action="{{ route('keranjang.destroy.semua', []) }}" method="POST" class="d-inline">
          @csrf
          <button type="submit" onclick="return confirm('yakin ingin mengosongkan keranjang?')" class="btn btn-secondary">KOSONGKAN KERANJANG BELANJAAN</button>

        </form>
        <form action="{{ route('buat.invoice') }}" method="post" class="d-inline">
          @csrf
          <button type="submit" onclick="return confirm('Lanjutkan proses?')" class="btn btn-primary">BUAT INVOICE</button>
        </form>
      </div>
    </div>
  </div>
  
</div>
@endsection