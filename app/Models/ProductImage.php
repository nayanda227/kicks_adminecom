<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    use HasFactory;

    public $timestamps = false;

    // Nama tabelnya 'product_images' (plural), jadi Laravel otomatis tahu.
    
    protected $fillable = [
        'product_id',
        'image_path',
        'is_featured',
    ];

    /**
     * Satu Gambar MILIK SATU Produk
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}