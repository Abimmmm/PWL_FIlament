<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    //
    use HasFactory;

    /**
     * Kolom yang boleh diisi secara massal (mass assignment).
     * Sesuaikan dengan field di migrasi.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'sku',
        'description',
        'price',
        'stock',
        'image',
        'is_active',
        'is_featured',
    ];

    /**
     * Casting tipe data otomatis.
     * Laravel akan mengkonversi tipe data dari string database ke tipe asli.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active'    => 'boolean',
        'is_featured'  => 'boolean',
        'price'        => 'integer',
        'stock'        => 'integer',
    ];
}
