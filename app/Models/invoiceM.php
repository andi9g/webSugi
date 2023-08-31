<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoiceM extends Model
{
    use HasFactory;
    protected $table = "invoice";
    protected $primaryKey = "idinvoice";
    protected $guarded = [];
}
