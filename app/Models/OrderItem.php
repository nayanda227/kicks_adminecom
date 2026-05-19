<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    public $timestamps = false;

    // Nama tabelnya 'order_items' (plural), jadi Laravel otomatis tahu.
    
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    /**
     * Satu OrderItem MILIK SATU Order
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Satu OrderItem MILIK SATU Produk
     */
    public function product(): BelongsTo
    {
        // Kita set '->withDefault()' untuk jaga-jaga
        // kalau produknya dihapus, aplikasinya tidak error
        return $this->belongsTo(Product::class)->withDefault([
            'name' => '[Produk Dihapus]'
        ]);
    }
}