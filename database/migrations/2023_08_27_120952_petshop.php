<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Petshop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->bigIncrements('idproduk');
            $table->string("namaproduk");
            $table->integer("idkategori");
            $table->integer("stok");
            $table->decimal("harga", 8,2);
            $table->string("deskripsi1");
            $table->longText("deskripsi2");
            $table->string("gambar");
            $table->double("diskon")->default(0);
            $table->timestamps();
        });

        Schema::create('gambarproduk', function (Blueprint $table) {
            $table->bigIncrements('idgambarproduk');
            $table->integer("idproduk");
            $table->String("gambar");
            $table->timestamps();
        });

        Schema::create('point', function (Blueprint $table) {
            $table->bigIncrements('idpoint');
            $table->integer("iduser");
            $table->decimal("point", 8,2);
            $table->timestamps();
        });

        Schema::create('keranjang', function (Blueprint $table) {
            $table->bigIncrements('idkeranjang');
            $table->integer("idproduk");
            $table->integer("iduser");
            $table->integer("jumlah");
            $table->timestamps();
        });

        Schema::create('invoice', function (Blueprint $table) {
            $table->bigIncrements('idinvoice');
            $table->enum("status", ["pending", "success", "fail"])->default("pending");
            $table->string("snap")->unique();
            $table->string("invoice")->unique();
            $table->integer("iduser");
            $table->decimal("total", 8,2);
            $table->timestamps();
        });

        Schema::create('detailinvoice', function (Blueprint $table) {
            $table->bigIncrements('iddetailinvoice');
            $table->string("invoice");
            $table->integer("idproduk");
            $table->integer("jumlah");
            $table->timestamps();
        });

        Schema::create('notifikasi', function (Blueprint $table) {
            $table->bigIncrements('idnotifikasi');
            $table->integer("iduser");
            $table->string("invoice");
            $table->string("status");
            $table->timestamps();
        });

        Schema::create('topikdiskusi', function (Blueprint $table) {
            $table->bigIncrements('idtopikdiskusi');
            $table->string("judultopikdiskusi");
            $table->integer("iduser");
            $table->boolean("ket")->default(0);
            $table->timestamps();
        });

        Schema::create('diskusi', function (Blueprint $table) {
            $table->bigIncrements('iddiskusi');
            $table->string("idtopikdiskusi");
            $table->integer("iduser");
            $table->longText("diskusi");
            $table->timestamps();
        });

        Schema::create('kategori', function (Blueprint $table) {
            $table->bigIncrements('idkategori');
            $table->string("namakategori");
            $table->timestamps();
        });

        $kategori = [
            "Wet Food",
            "Dry Food",
            "Aksesoris",
        ];

        foreach ($kategori as $k) {
            # code...
            DB::table("kategori")->insert([
                "namakategori" => $k,
            ]);
        }

        

        Schema::create('identitas', function (Blueprint $table) {
            $table->bigIncrements('ididentitas');
            $table->string("name");
            $table->string("alamat");
            $table->date("tanggallahir");
            $table->string("tempatlahir");
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
