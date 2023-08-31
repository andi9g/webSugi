<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\produkM;

class keranjangM extends Model
{
    use HasFactory;
    protected $table = "keranjang";
    protected $primaryKey = "idkeranjang";
    protected $guarded = [];


    public function produk() {
        return $this->belongsTo(produkM::class, "idproduk", "idproduk");
    }
}
