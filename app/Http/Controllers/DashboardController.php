<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController; // extends BaseController
use Illuminate\Http\Request;

class DashboardController extends BaseController 
{
    /**
     * Menampilkan halaman dashboard dengan DUMMY DATA.
     */
    public function index()
    {
        // 1. Data Dummy untuk Kartu Statistik
        $totalOrderValue = 126500;
        $activeOrderValue = 126500;
        $shippedOrderValue = 126500;

        // 2. Data Dummy untuk Best Sellers
        // Kita sesuaikan path gambarnya dengan file Blade kamu
        $bestSellers = [
            (object)['name' => 'Adidas Ultra Boost', 'price' => 126.50, 'order_items_count' => 999, 'images' => collect([(object)['image_path' => 'assets/product-images/adidas.jpg']])],
            (object)['name' => 'Adidas Ultra Boost', 'price' => 126.50, 'order_items_count' => 999, 'images' => collect([(object)['image_path' => 'assets/product-images/adidas.jpg']])],
        ];

        // 3. Data Dummy untuk Recent Orders (sesuai Blade kamu)
        $recentOrders = [
            (object)['order_number' => '#25466', 'created_at' => '2025-11-08', 'status' => 'Delivered', 'total_amount' => 200.00, 'user' => (object)['name' => 'Leo Gouse']],
            (object)['order_number' => '#25445', 'created_at' => '2025-11-07', 'status' => 'Canceled', 'total_amount' => 200.00, 'user' => (object)['name' => 'Jaxson Kargaard']],
            (object)['order_number' => '#25425', 'created_at' => '2025-11-07', 'status' => 'Delivered', 'total_amount' => 200.00, 'user' => (object)['name' => 'Talan Botosh']],
            (object)['order_number' => '#25423', 'created_at' => '2025-11-05', 'status' => 'Delivered', 'total_amount' => 200.00, 'user' => (object)['name' => 'Ryan Philips']],
            (object)['order_number' => '#25421', 'created_at' => '2025-11-04', 'status' => 'Canceled', 'total_amount' => 200.00, 'user' => (object)['name' => 'Emerson Baptista']],
            (object)['order_number' => '#25421', 'created_at' => '2025-11-10', 'status' => 'Delivered', 'total_amount' => 200.00, 'user' => (object)['name' => 'Jasson Calzoni']],
        ];

        // 4. Data Dummy untuk Sale Graph
        $saleGraphData = [
            'Jan' => 12000, 'Feb' => 19000, 'Mar' => 30000, 'Apr' => 50000, 
            'May' => 20000, 'Jun' => 30000, 'Jul' => 45000, 'Aug' => 40000, 
            'Sep' => 55000, 'Oct' => 65000, 'Nov' => 70000, 'Dec' => 80000
        ];

        // 5. Kirim semua data DUMMY ini ke view
        return view('dashboard', compact(
            'totalOrderValue',
            'activeOrderValue',
            'shippedOrderValue',
            'bestSellers',
            'recentOrders',
            'saleGraphData'
        ));
    }
}