<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class topikdiskusiM extends Model
{
    use HasFactory;
    protected $table = "topikdiskusi";
    protected $primaryKey = "idtopikdiskusi";
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class, "iduser", "id");
    }
}
