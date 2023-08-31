<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class diskusiM extends Model
{
    use HasFactory;
    protected $table = "diskusi";
    protected $primaryKey = "iddiskusi";
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class, "iduser", "id");
    }
}
