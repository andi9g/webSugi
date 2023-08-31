<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notifikasiM extends Model
{
    use HasFactory;
    protected $table = "notifikasi";
    protected $primaryKey = "idnotifikasi";
    protected $guarded = [];
}
