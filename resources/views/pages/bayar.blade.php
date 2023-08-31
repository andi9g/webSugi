@extends('layouts.umum')

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
<div class="row">
  <div class="col-md-12">
    <h3>Checkout</h3>
    <a href="{{ url('/beranda', []) }}" class="btn btn-secondary">Back to Beranda</a>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header text-center">
        @php
            if ($invoice->status == "pending") {
              $txt = "text-warning";
              $pesan = "BELUM MELAKUKAN PEMBAYARAN";
            }else if ($invoice->status == "success") {
              $txt = "text-success";
              $pesan = "PEMBAYARAN SELESAI";
            }else {
              $txt = "text-danger";
              $pesan = "PEMBAYARAN EXPIRED";
            }
        @endphp
        <h3 class="{{ $txt }}">{{ $pesan }}</h3>
        @if ($invoice->status=="success")
            <p>Pembayaran berhasil, silahkan menunggu konfirmasi dan menunggu pesan di menu <b><a href="{{ url('notifikasi', []) }}">Notifikasi</b></a></p>
        @endif
      </div>
      <div class="card-body">
        <table class="table table-hover table-striped table-bordered text-bold" style="font-weight: bold">
          <tr>
            <td>NAMA PELANGGAN</td>
            <td>:</td>
            <td>{{ Auth::user()->name }}</td>
          </tr>
          <tr>
            <td>Email</td>
            <td>:</td>
            <td>{{ Auth::user()->email }}</td>
          </tr>
          <tr>
            <td>NOMOR INVOICE</td>
            <td>:</td>
            <td>{{ $invoice->invoice }}</td>
          </tr>
          <tr>
            <td colspan="3" class="text-center"><h3><b>TOTAL BAYAR</b></h3></td>
          </tr>
          <tr>
            <td colspan="3" class="text-center"><h2><b>Rp{{ number_format($invoice->total, 0,",",".") }}</b></h2></td>
          </tr>
        </table>
        @if ($invoice->status=="pending")
          <button type="button" class="btn btn-block btn-primary py-3 " id="pay-button">BAYAR SEKARANG</button>
        @else
          <button class="btn btn-block btn-secondary disabled py-3" disabled>
            PEMBAYARAN SELESAI
          </button>
        @endif
      </div>
    </div>

  
  </div>
  
</div>
@endsection

@section('script')


<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>

<script>
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>

@if ($invoice->status=="pending")
<script type="text/javascript">

  document.getElementById('pay-button').onclick = function(){
      snap.pay('{{ $snaptoken }}', {
          onSuccess: function(result){
              // Proses jika pembayaran sukses
              var ket = 'success';
                $.ajax({
                    type:'POST',
                    url:"{{ route('ajax.post', $invoice->idinvoice) }}",
                    data:{ket:ket},
                    success:function(data){
                        alert(data.success);
                        location.reload();
                    }
                });
          },
          onPending: function(result){
            var ket = 'pending';
                $.ajax({
                    type:'POST',
                    url:"{{ route('ajax.post', $invoice->idinvoice) }}",
                    data:{ket:ket},
                    success:function(data){
                        alert(data.success);
                        location.reload();
                    }
                });
          },
          onError: function(result){
            var ket = 'fail';
                $.ajax({
                    type:'POST',
                    url:"{{ route('ajax.post', $invoice->idinvoice) }}",
                    data:{ket:ket},
                    success:function(data){
                        alert(data.success);
                        location.reload();
                    }
                });
          },
          onClose: function(){
              // Proses jika pembayaran ditutup
          }
      });
  };
</script>
    
@endif
@endsection