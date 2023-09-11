@extends('layouts.umum')

@section("anotifikasi", "active")

@section('content')
<div class="row">
  <div class="col-md-12">
    <h3>NOTIFIKASI</h3>
    <a href="{{ url('/beranda', []) }}" class="btn btn-secondary">Back to Beranda</a>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    @foreach ($notifikasi as $item)
      <div class="card mb-3">
        <div class="card-body">
          <div class="row my-0 py-0">
            <div class="col-md-6 my-0 py-0">
              <h4 class="my-0 py-0">
                <b>{{ $item->invoice }}</b>
              </h4></div>
            <div class="col-md-6 my-0 py-0 text-right">
              <p class="py-0 my-0">{{ \Carbon\Carbon::parse($item->created_at)->isoFormat("dddd, DD MMMM Y") }} {{ date("H:i", strtotime($item->created_at)) }}</p>
            </div>
          </div>
          
          <h5><?php echo $item->status ?></h5>
          @php
              $cek = strpos($item->invoice, "INV");
          @endphp
          @if ($cek !== false)
            <a href="{{ route('lihat.invoiceku', [$item->invoice]) }}" class="btn btn-success">Lihat Data Pembelian</a>
              
          @endif
        </div>
      </div>
        
    @endforeach
  </div>
</div>
@endsection