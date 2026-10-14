<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SparePart extends Model
{
    // Mengizinkan kolom ini untuk diisi data
    protected $fillable = ['sku', 'name', 'stock', 'price'];
}