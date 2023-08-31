@extends('layouts.umum')


@section("adiskusi", 'active')

@section('content')
<a href="{{ url('diskusi', []) }}" class="btn btn-sm btn-danger">Kembali</a>
<a href="{{ url()->current() }}" class="btn-sm btn">Refresh</a>
<div class = "card direct-chat direct-chat-primary" > <div class="card-header">
    <h3 class="card-title text-lg">{{ $topik->judultopikdiskusi }}</h3>
    <div class="card-tools">
        @if ($topik->ket == false)
            <button class="btn btn-warning btn-sm" type="button" data-toggle="modal" data-target="#selesaikanmasalah">
                AKHIRI DISKUSI?
            </button>

            <div id="selesaikanmasalah" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="my-modal-title">Alert</h5>
                            <button class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Dengan menekan tombol ya dibawah, maka diskusi dinyatakan telah selesai</p>
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('diskusi.selesai', [$idtopikdiskusi]) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-success btn-lg">
                                    YA
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        @else

            <p class="text-danger text-lg">DISKUSI DIAKHIRI</p>
            
        @endif
    </div>
   
</div>

<div class="card-body" style="height: 300px">
 

    <div id="chatingan" class="direct-chat-messages p-6" style="height: 300px">
        @livewire('chat', ['idtopikdiskusi' => $idtopikdiskusi])
    </div>

                    

</div>

<script>
    document.getElementById('chatingan').scrollTo(0, 999999);
</script>
<div class="card-footer">
    <form action="{{ route('kirim.diskusi', [$idtopikdiskusi]) }}" method="POST">
        @csrf
        <div class="input-group">
                <textarea id="my-textarea" rows="2" name="diskusi"
                placeholder="Masukan pesan diskusi ..."
                class="form-control"></textarea>
                <span class="input-group-append">
                    <button type="submit" class="btn btn-primary">Send</button>
                </span>
            
            
                
                
        </div>

    </form>
</div>

</div>


@endsection