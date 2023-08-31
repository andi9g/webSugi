<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class produkM extends Model
{
    use HasFactory;
    protected $table = "produk";
    protected $primaryKey = "idproduk";
    protected $guarded = [];


    public function kategori() {
        return $this->belongsTo(kategoriM::class, "idkategori", "idkategori");
    }
}
