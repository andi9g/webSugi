<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




// Route::get('pdf', 'startController@pdf');

// Route::get('siswa/export/', 'startController@export');

Auth::routes();

Route::get("beranda", "indexC@beranda");
Route::get('/', function () {
    return redirect('login');
});



Route::middleware(['auth'])->group(function () {
    Route::post("show/{idproduk}/keranjang", "indexC@tambahkeranjang")->name("tambah.keranjang");
    Route::post("show/{idproduk}/pembelian", "indexC@pembelian")->name("tambah.pembelian");
    Route::post("keranjang/{idproduk}/ubah", "indexC@ubahkeranjang")->name("ubah.stok.keranjang");
    Route::post("keranjang/{idproduk}/hapus", "indexC@hapussatuan")->name("keranjang.destroy.satuan");
    Route::post("keranjang/hapus", "indexC@hapuskeranjang")->name("keranjang.destroy.semua");

    Route::post("invoice/create", "indexC@invoice")->name("buat.invoice");
    Route::get("notifikasi", "indexC@notifikasi")->name("notifikasi");
    Route::get("checkout/{snaptoken}/bayar", "indexC@bayar");
    Route::post("checkout/{idinvoice}/callback", "indexC@callback")->name('ajax.post');
    
    Route::get("show/{idproduk}/produk", "indexC@show")->name("detail.produk");
    
    Route::get("keranjang", "indexC@keranjang")->name("keranjang");

    Route::post("gunakanpoint", "pointC@point")->name("gunakan.point");

    Route::middleware(['GerbangAdmin'])->group(function () {
        Route::get('/home', "homeC@home")->name('home');
        Route::resource("produk", "produkC");
        Route::resource('dokter', "dokterC");
        Route::post("diskon/{idproduk}/produk", "produkC@diskon")->name("ubahdiskon");
        Route::post("sebarkan/diskon", "produkC@sebarkandiskon")->name("sebarkan.diskon");
       
        
        Route::resource("transaksi", "invoiceC");
    });
    Route::get("lihat/{invoice}/transaksi", "invoiceC@lihat")->name("lihat.invoice");
    Route::get("invoice/{invoice}/lihat", "invoiceC@lihatpembelian")->name("lihat.invoiceku");
    Route::post("kirim/{iduser}/notifikasi", "invoiceC@notifikasi")->name("kirim.notifikasi");
    
    
    Route::get("diskusi", "diskusiC@topik");
    Route::post("diskusi/tambah/data", "diskusiC@tambahtopik")->name("tambah.topik");


    
    Route::middleware(['GerbangChat'])->group(function () {
        Route::get("chatingan", "diskusiC@dokter");
        Route::get("chat/{idtopikdiskusi}", "diskusiC@diskusi")->name("diskusi");
        Route::post("chat/{idtopikdiskusi}", "diskusiC@chat")->name("kirim.diskusi");
    
        Route::post("chat/{idtopikdiskusi}/selesai", "diskusiC@selesai")->name("diskusi.selesai");
    });

});



