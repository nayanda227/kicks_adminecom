<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Order; // <-- 1. Kita 'use' Model Order lagi
use Illuminate\Http\Request;
// Hapus 'use Illuminate\Support\Collection;'

class OrderController extends BaseController 
{
    /**
     * Menampilkan halaman daftar order (Order List) dari DATABASE.
     */
    public function index()
    {
        // 2. Ganti array dummy dengan query database
        $orders = Order::query()
            // 'with()' ini Eager Loading, sangat penting biar nggak lemot.
            // Dia sekaligus ambil data 'user' (customer) dan 'items.product' (produk di order itu)
            ->with('user', 'items.product') 
            ->latest() // Urutkan dari yang paling baru
            ->paginate(10); // Tampilkan 10 order per halaman

        // 3. Kirim data Paginator $orders ke view
        return view('orders.index', compact('orders'));
    }
}