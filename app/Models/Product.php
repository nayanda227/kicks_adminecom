<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'stock',
        'brand_name',
        'supplier',
    ];

    /**
     * Satu Produk MILIK SATU Kategori
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Satu Produk punya BANYAK Gambar
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Satu Produk bisa punya BANYAK Tag
     * (Relasi Many-to-Many)
     */
    public function tags(): BelongsToMany
    {
        // 'product_tag' adalah nama tabel jembatan/pivot
        return $this->belongsToMany(Tag::class, 'product_tag');
    }
    /**
     * Satu Produk punya BANYAK OrderItem
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}