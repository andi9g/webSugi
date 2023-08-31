@extends('layouts.umum')


@section("adiskusi", 'active')

@section('content')


<div id="diskusidua" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Tambah Diskusi</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('tambah.topik', []) }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="topic">Topik Pembahasan</label>
                        <input id="topic" class="form-control" type="text" name="judultopikdiskusi" placeholder="masukan judul pembahasan">
                    </div>
                    <div class="form-group">
                        <label for="diskusi">Pesan</label>
                        <textarea id="diskusi" class="form-control" name="diskusi" rows="3" placeholder="masukan pesan anda disini"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        TAMBAH TOPIK
                    </button>
                </div>
            </form>
            
        </div>
    </div>
</div>

    <div class="card">
        <div class="card-header">
            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#diskusidua">Tambah Diskusi</button>

            
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            @foreach ($topik as $item)
            <div class="card">
                <div class="card-body card-outline ">
                    <blockquote class="my-0 py-0">
                        <a href="{{ route('diskusi', [$item->idtopikdiskusi]) }}"><h3>{{ ucwords($item->judultopikdiskusi) }}</h3></a>
                    </blockquote>
                    <p class="my-0 py-0">{{ \Carbon\Carbon::parse($item->created_at)->isoFormat("dddd, DD MMMM Y")." ".date("H:i", strtotime($item->created_at)) }}</p>
                    @if ($item->ket == false)
                        <small class="badge badge-danger">Belum Terselesaikan</small>    
                    @else
                        <small class="badge badge-success">Selesai</small>  
                    @endif
                </div>
            </div>
                
            @endforeach
        </div>
    </div>
@endsection