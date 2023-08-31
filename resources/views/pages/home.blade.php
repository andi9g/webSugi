@extends('layouts.master')

@section("judul", "Data home")
@section("warnahome", "active")
@section("title", "home")


@section('content')
<div class="container">
    <div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1">
                <i class="fas fa-user"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Jumlah Dokter</span>
                <span class="info-box-number">
                    {{$dokter}}
                </span>
            </div>

        </div>

    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1">
                <i class="fas fa-thumbs-up"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Jumlah Pendaftar</span>
                <span class="info-box-number">{{ $user }}</span>
            </div>

        </div>

    </div>

    <div class="clearfix hidden-md-up"></div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1">
                <i class="fas fa-database"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Jumlah Produk</span>
                <span class="info-box-number">{{ $produk }}</span>
            </div>

        </div>

    </div>

    

</div>


</div>
@endsection