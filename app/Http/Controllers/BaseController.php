<?php

namespace App\Http\Controllers;

use App\Models\Category; // <-- Import Kategori
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View; // <-- Import View

class BaseController extends Controller
{
    public function __construct()
    {
        // Ambil data kategori SEKALI SAJA
        $categories = Category::withCount('products')->orderBy('name', 'asc')->get();

        // Bagikan data $categories ke SEMUA view
        View::share('categories', $categories);
    }
}