@extends('layouts.master')

@section("judul", "Data chatingan")
@section("warnachatingan", "active")
@section("title", "chatingan")

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            @foreach ($topik as $item)
            <div class="card">
                <div class="card-body card-outline ">
                    <blockquote class="my-0 py-0">
                        <a target="_blank" href="{{ route('diskusi', [$item->idtopikdiskusi]) }}"><h3>{{ ucwords($item->judultopikdiskusi) }}</h3></a>
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
</div>



@endsection