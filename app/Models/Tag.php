<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Satu Tag bisa dimiliki BANYAK Produk
     * (Relasi Many-to-Many)
     */
    public function products(): BelongsToMany
    {
        // 'product_tag' adalah nama tabel jembatan/pivot
        return $this->belongsToMany(Product::class, 'product_tag');
    }
}