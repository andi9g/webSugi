<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detailinvoiceM extends Model
{
    use HasFactory;
    protected $table = "detailinvoice";
    protected $primaryKey = "iddetailinvoice";
    protected $guarded = [];

    public function produk() {
        return $this->belongsTo(produkM::class, "idproduk", "idproduk");
    }
}
