{{-- resources/views/products/show.blade.php --}}

@extends('layouts.app')

@section('title', 'Product Details')
@section('page-title', 'Product Details')

@section('content')
<div class="max-w-6xl mx-auto">
    {{-- Ini adalah breadcrumb (penunjuk halaman) --}}
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">@yield('page-title', 'Products Details')</h1>
            <p class="text-sm text-gray-500 mt-1">Home > All Products > @yield('page-title', 'Products Details')</p>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-6">
        
        <div class="bg-white p-6 rounded-lg shadow-md">
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <div class="space-y-6">
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                        {{-- 
                          Kita pakai <input> tapi 'disabled' agar tampilannya sama seperti form edit.
                          'bg-gray-100' ditambahkan untuk memberi kesan "tidak bisa diedit".
                        --}}
                        <input type="text" name="name" id="name" disabled 
                               value="{{ $product->name }}"
                               class="mt-1 block w-full rounded-md border-black py-3 px-4 shadow-sm focus:border-black focus:ring-black bg-gray-100">
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" id="description" rows="4" disabled
                                  class="mt-1 block w-full rounded-md border-black py-3 px-4 shadow-sm focus:border-black focus:ring-black bg-gray-100">{{ $product->description }}</textarea>
                    </div>

                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        {{-- 
                          Kita ganti <select> jadi <input> biasa karena user tidak perlu memilih.
                          Kita pakai '?? 'N/A'' (Null Coalescing) untuk jaga-jaga
                          jika $product->category tidak ada (null), agar halaman tidak crash.
                        --}}
                        <input type="text" name="category" id="category" disabled 
                               value="{{ $product->category->name ?? 'N/A' }}"
                               class="mt-1 block w-full rounded-md border-black py-3 px-4 shadow-sm focus:border-black focus:ring-black bg-gray-100">
                    </div>

                    <div>
                        <label for="brand_name" class="block text-sm font-medium text-gray-700 mb-1">Brand Name</label>
                        <input type="text" name="brand_name" id="brand_name" disabled 
                               value="{{ $product->brand_name }}"
                               class="mt-1 block w-full rounded-md border-black py-3 px-4 shadow-sm focus:border-black focus:ring-black bg-gray-100">
                    </div>

                    <div>
                        <label for="supplier" class="block text-sm font-medium text-gray-700 mb-1">Supplier</label>
                        <input type="text" name="supplier" id="supplier" disabled 
                               value="{{ $product->supplier }}"
                               class="mt-1 block w-full rounded-md border-black py-3 px-4 shadow-sm focus:border-black focus:ring-black bg-gray-100">
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity</label>
                            <input type="number" name="stock" id="stock" disabled 
                                   value="{{ $product->stock }}"
                                   class="mt-1 block w-full rounded-md border-black py-3 px-4 shadow-sm focus:border-black focus:ring-black bg-gray-100">
                        </div>
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Regular Price</label>
                            {{-- Kita format harganya pakai 'number_format()' biar rapi --}}
                            <input type="text" name="price" id="price" disabled 
                                   value="${{ number_format($product->price, 2) }}"
                                   class="mt-1 block w-full rounded-md border-black py-3 px-4 shadow-sm focus:border-black focus:ring-black bg-gray-100">
                        </div>
                    </div>

                    <div>
                        <label for="tags" class="block text-sm font-medium text-gray-700 mb-1">Tag</label>
                        {{-- 
                          Sama seperti di 'edit.blade.php', kita panggil relasi 'tags',
                          ambil 'name'-nya saja (pluck), lalu gabungkan (implode).
                        --}}
                        <input type="text" name="tags" id="tags" disabled
                               value="{{ $product->tags->pluck('name')->implode(', ') }}"
                               class="mt-1 block w-full rounded-md border-black py-3 px-4 shadow-sm focus:border-black focus:ring-black bg-gray-100">
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <h4 class="text-lg font-medium text-gray-800 mb-4">Product Gallery</h4>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Main Image (Featured)</label>
                            @php
                                $featuredImage = $product->images()->where('is_featured', true)->first();
                            @endphp
                            
                            {{-- 
                              Di halaman 'show' ini, kita tidak perlu box upload.
                              Kita pakai @if untuk cek:
                              JIKA $featuredImage ada, TAMPILKAN gambarnya.
                              JIKA TIDAK, tampilkan box placeholder "No Featured Image".
                            --}}
                            @if($featuredImage)
                                <img src="{{ asset($featuredImage->image_path) }}" alt="Featured Image" class="w-full aspect-square object-cover rounded-md border-2 border-black">
                            @else
                                <div class="aspect-square w-full border-2 border-black border-dashed rounded-md flex items-center justify-center bg-gray-50">
                                    <span class="text-gray-400">No Featured Image</span>
                                </div>
                            @endif
                        </div>

                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Other Images</label>
                            @php
                                $otherImages = $product->images()->where('is_featured', false)->get();
                            @endphp

                            {{-- 
                              Sama seperti 'Main Image', kita cek dulu:
                              JIKA $otherImages->count() > 0 (ada isinya), MAKA kita loop dan tampilkan grid gambarnya.
                              JIKA TIDAK, tampilkan box placeholder "No other images."
                            --}}
                            @if($otherImages->count() > 0)
                                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-4 mt-4">
                                    @foreach($otherImages as $image)
                                        <img src="{{ asset($image->image_path) }}" alt="Product Image" class="w-full aspect-square object-cover rounded-md border border-gray-300">
                                    @endforeach
                                </div>
                            @else
                                <div class="mt-1 flex justify-center py-12 px-6 border-2 border-black border-dashed rounded-md">
                                    <span class="text-gray-400">No other images.</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div> </div> <div class="flex justify-end space-x-4 mt-8 border-t border-gray-200 pt-6">
                {{-- Tombol kembali ke halaman list --}}
                <a href="{{ route('products.index') }}" 
                   class="px-6 py-3 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    BACK TO LIST
                </a>
                {{-- Tombol untuk pindah ke halaman 'edit' --}}
                <a href="{{ route('products.edit', $product->id) }}" 
                   class="px-6 py-3 bg-black text-white rounded-lg font-medium hover:bg-gray-700 transition-colors duration-200">
                    EDIT PRODUCT
                </a>
            </div>
        </div> 
    </div>
</div>
@endsection