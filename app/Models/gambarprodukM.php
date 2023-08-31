<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gambarprodukM extends Model
{
    use HasFactory;
    protected $table = "gambarproduk";
    protected $primaryKey = "idgambarproduk";
    protected $guarded = [];
}
