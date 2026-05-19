{{-- resources/views/products/index.blade.php --}}

@extends('layouts.app')

@section('title', 'All Products - KICKS')
@section('page-title', 'All Products')

@section('content')

{{-- 
  Ini adalah blok untuk menampilkan "flash message" (pesan sukses).
  Variabel 'success' ini dikirim dari Controller (method store, update, destroy)
  saat kita melakukan redirect: ->with('success', 'Produk berhasil dihapus!')
--}}
@if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif

<div class="space-y-6">
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">@yield('page-title', 'All Products')</h1>
            <p class="text-sm text-gray-500 mt-1">Home > @yield('page-title', 'All Products')</p>
        </div>
        <div class="flex justify-end">
            {{-- route('products.create') akan otomatis mengarah ke URL '/products/create' --}}
            <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 bg-black text-white rounded-lg font-medium text-sm hover:bg-gray-700 transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                Add New Product
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        {{-- 
          @forelse adalah @foreach versi "lebih pintar".
          Dia akan me-looping $products. 
          Jika $products-nya KOSONG, dia akan otomatis menjalankan blok @empty.
          Ini jauh lebih rapi daripada pakai @if(count($products) > 0)
        --}}
        @forelse ($products as $product)
        <div class="bg-white rounded-lg shadow-md flex flex-col overflow-hidden">
            
            @php
                // '$product->images' memanggil relasi 'images()' (hasMany) di Model Product.
                // '->first()' mengambil HANYA 1 gambar (gambar pertama yang ditemukan).
                // Kita pakai @php di sini biar rapi di dalam <img> src.
                $image = $product->images->first();
            @endphp
            
            <div class="w-full aspect-square bg-white flex items-center justify-center p-4">
                {{-- 
                  Ini adalah "Ternary Operator" (if-else versi singkat).
                  Logikanya:
                  "JIKA $image ADA (true), MAKA pakai asset($image->image_path),
                   JIKA TIDAK (false), MAKA pakai link placeholder."
                  
                  'asset($image->image_path)' akan membuat URL lengkap:
                  http://.../assets/product-images/nama-file.jpg
                --}}
                <img src="{{ $image ? asset($image->image_path) : 'https://via.placeholder.com/300x200?text=No+Image' }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-full object-contain"> 
            </div>
            
            <div class="p-4 flex flex-col flex-1">
                <div class="flex justify-between items-start">
                    <div>
                        {{-- 
                          route('products.show', $product->id)
                          Ini akan mengarahkan ke halaman detail, mengirim ID produk ke URL.
                          Hasilnya: /products/1 (atau /products/2, dst)
                        --}}
                        <a href="{{ route('products.show', $product->id) }}" 
                           class="font-medium text-gray-800 hover:underline">
                            {{ $product->name }}
                        </a>
                        
                        {{-- 
                          Ini adalah "Null Coalescing Operator" (??)
                          Artinya: "Coba ambil $product->category->name. 
                          JIKA $product->category adalah NULL (misal produk nggak punya kategori),
                          MAKA tampilkan 'Uncategorized' sebagai gantinya."
                          Ini mencegah halaman CRASH / error.
                        --}}
                        <p class="text-sm text-gray-500">{{ $product->category->name ?? 'Uncategorized' }}</p>
                    </div>
                    
                    {{-- Tombol Edit dan Hapus --}}
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('products.edit', $product->id) }}" 
                           class="text-gray-700 hover:text-black">
                            <i class="fas fa-edit"></i>
                        </a>
                        
                        {{-- 
                          INI BAGIAN PENTING UNTUK DELETE
                          Tombol Hapus WAJIB ada di dalam <form> dengan method="POST".
                          Browser tidak bisa mengirim request 'DELETE' langsung dari link.
                          
                          @method('DELETE') adalah "tipuan" untuk bilang ke Laravel
                          bahwa ini sebenarnya adalah request 'DELETE', bukan 'POST'.
                          Ini adalah standar keamanan Laravel (CSRF protection).
                        --}}
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" 
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-700 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                
                <p class="font-bold text-gray-900 mt-1">${{ number_format($product->price, 2) }}</p>
                
                {{-- 'flex-1' ini penting, dia "mendorong" statistik (Sales & Remaining) ke bawah --}}
                <p class="text-sm text-gray-600 my-4 flex-1">
                    {{ Str::limit($product->description, 80) }}
                </p>

                <div class="border-t border-gray-100 pt-4">
                    <div class="flex justify-between items-center text-sm text-gray-600">
                        <span>Sales</span>
                        <span class="flex items-center text-lime-500 font-medium">
                            <i class="fas fa-arrow-up mr-1 text-xs"></i> 
                            {{-- 
                              INI ADALAH "MAGIC" DARI CONTROLLER
                              Variabel 'order_items_count' ini TIDAK ADA di tabel 'products'.
                              Variabel ini dibuat "on-the-fly" oleh Controller kita
                              saat kita memanggil '->withCount('orderItems')' di ProductController.
                            --}}
                            {{ $product->order_items_count ?? 0 }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center text-sm text-gray-600 mt-2">
                        <span>Remaining Products</span>
                        <span class="flex items-center text-gray-800 font-medium">
                            <i class="fas fa-layer-group mr-1 text-xs text-lime-500"></i> 
                            {{-- Stok Produk --}}
                            {{ $product->stock }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Ini adalah blok yang jalan JIKA $products-nya kosong --}}
        @empty
        <div class="md:col-span-2 lg:col-span-3 text-center py-12">
            <p class="text-gray-500 text-lg">Tidak ada produk yang ditemukan.</p>
            <p class="text-gray-400 text-sm mt-2">Coba tambahkan produk baru!</p>
        </div>
        @endforelse
        
    </div>

    {{-- 
      Ini adalah "magic" Paginasi Laravel.
      Kode ini otomatis membuat link halaman "1, 2, 3..."
      Ini HANYA berfungsi karena di ProductController kita pakai '->paginate(9)'
    --}}
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection