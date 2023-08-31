<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pointM extends Model
{
    use HasFactory;
    protected $table = "point";
    protected $primaryKey = "idpoint";
    protected $guarded = [];
    
}
