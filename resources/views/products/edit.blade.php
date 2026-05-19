{{-- resources/views/products/edit.blade.php --}}

@extends('layouts.app')

@section('title', 'Edit Product')
@section('page-title', 'Edit Product')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">@yield('page-title', 'Edit Products')</h1>
            <p class="text-sm text-gray-500 mt-1">Home > All Products > @yield('page-title', 'Edit Products')</p>
        </div>
    </div>
    {{-- 
      1. FORM ACTION & METHOD:
      - 'action' diarahkan ke route 'products.update' sambil mengirim '$product->id'
      - method="POST" (ini wajib untuk form)
      - @method('PUT') adalah "tipuan" untuk bilang ke Laravel bahwa ini adalah request 'UPDATE'
    --}}
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 gap-6">
            
            <div class="bg-white p-6 rounded-lg shadow-md">
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    
                    <div class="space-y-6">
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                            {{-- 
                              2. MENGISI VALUE:
                              'old('name', $product->name)' adalah helper Laravel yang canggih.
                              Artinya: "Coba ambil data lama dari session (jika validasi gagal),
                              JIKA TIDAK ADA, maka ambil data asli dari '$product->name'."
                            --}}
                            <input type="text" name="name" id="name" placeholder="Type name here" 
                                   value="{{ old('name', $product->name) }}"
                                   class="mt-1 block w-full rounded-md border-black py-3 px-4 shadow-sm focus:border-black focus:ring-black">
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            {{-- Textarea tidak punya atribut 'value', jadi kita isi di antara tag-nya --}}
                            <textarea name="description" id="description" rows="4" placeholder="Type description here"
                                      class="mt-1 block w-full rounded-md border-black py-3 px-4 shadow-sm focus:border-black focus:ring-black">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select name="category_id" id="category_id"
                                    class="mt-1 block w-full rounded-md border-black py-3 px-4 shadow-sm focus:border-black focus:ring-black">
                                <option value="">Type Category here</option>
                                @foreach ($categories as $category)
                                    {{-- 
                                      3. MENGISI VALUE (SELECT/DROPDOWN):
                                      Kita pakai 'if' ternary untuk mengecek.
                                      "JIKA ID kategori ini SAMA DENGAN ID kategori produk,
                                       MAKA cetak 'selected' (agar otomatis terpilih)."
                                    --}}
                                    <option value="{{ $category->id }}" 
                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="brand_name" class="block text-sm font-medium text-gray-700 mb-1">Brand Name</label>
                            <input type="text" name="brand_name" id="brand_name" placeholder="Type brand name here" 
                                   value="{{ old('brand_name', $product->brand_name) }}"
                                   class="mt-1 block w-full rounded-md border-black py-3 px-4 shadow-sm focus:border-black focus:ring-black">
                        </div>

                        <div>
                            <label for="supplier" class="block text-sm font-medium text-gray-700 mb-1">Suppliers</label>
                            <input type="text" name="supplier" id="supplier" placeholder="Type supplier name here" 
                                   value="{{ old('supplier', $product->supplier) }}"
                                   class="mt-1 block w-full rounded-md border-black py-3 px-4 shadow-sm focus:border-black focus:ring-black">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity</label>
                                <input type="number" name="stock" id="stock" placeholder="1258" 
                                       value="{{ old('stock', $product->stock) }}"
                                       class="mt-1 block w-full rounded-md border-black py-3 px-4 shadow-sm focus:border-black focus:ring-black">
                            </div>
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Regular Price</label>
                                <input type="number" name="price" id="price" placeholder="$1000" step="0.01"
                                       value="{{ old('price', $product->price) }}"
                                       class="mt-1 block w-full rounded-md border-black py-3 px-4 shadow-sm focus:border-black focus:ring-black">
                            </div>
                        </div>

                        <div>
                            <label for="tags" class="block text-sm font-medium text-gray-700 mb-1">Tag</label>
                            {{-- 
                              4. MENGISI VALUE TAGS (TRICKY):
                              - $product->tags: Mengambil SEMUA tag yang berhubungan (via relasi 'tags()').
                              - ->pluck('name'): Dari semua tag itu, ambil HANYA kolom 'name'-nya saja.
                              - ->implode(','): Gabungkan semua nama itu jadi SATU string, dipisah pakai koma.
                              Hasilnya: "Adidas, Shoes, Sneakers"
                            --}}
                            <input type="text" name="tags" id="tags" placeholder="e.g., Adidas, Shoes, Sneakers"
                                   value="{{ old('tags', $product->tags->pluck('name')->implode(',')) }}"
                                   class="mt-1 block w-full rounded-md border-black py-3 px-4 shadow-sm focus:border-black focus:ring-black">
                            <p class="mt-2 text-xs text-gray-500">Pisahkan setiap tag dengan koma ( , ).</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <h4 class="text-lg font-medium text-gray-800 mb-4">Product Gallery</h4>
                            
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <label class="block text-sm font-medium text-gray-700">Main Image (Featured)</label>
                                    
                                    {{-- 5. AMBIL DATA GAMBAR LAMA (Featured) --}}
                                    @php
                                        // Cek ke DB, ambil gambar yang 'is_featured' = true
                                        $featuredImage = $product->images()->where('is_featured', true)->first();
                                    @endphp
                                    
                                    {{-- Tampilkan tombol hapus HANYA JIKA gambarnya ada --}}
                                    @if($featuredImage)
                                    <div class="flex items-center">
                                        {{-- 6. LOGIKA HAPUS (CLIENT + SERVER) --}}
                                        {{-- Checkbox ini 'hidden' (disembunyikan) tapi nilainya akan dikirim ke Controller --}}
                                        <input type="checkbox" name="delete_featured_image" id="delete_featured_image" 
                                               value="{{ $featuredImage->id }}" 
                                               class="hidden peer">
                                        {{-- Label ini adalah ikon tong sampah. Saat diklik, dia mencentang checkbox di atas --}}
                                        {{-- ID 'main-delete-btn' digunakan oleh JavaScript di bawah --}}
                                        <label for="delete_featured_image" 
                                               id="main-delete-btn" 
                                               class="p-2 rounded-md cursor-pointer text-gray-400 hover:text-red-600 
                                                      peer-checked:text-red-600 peer-checked:bg-red-100" 
                                               title="Mark for deletion">
                                            <i class="fas fa-trash"></i>
                                        </label>
                                    </div>
                                    @endif
                                </div>
                                
                                {{-- Box Preview/Upload --}}
                                <div class="mt-1 relative aspect-square w-full border-2 border-black border-dashed rounded-md overflow-hidden">
                                    {{-- 
                                      Tampilkan placeholder HANYA JIKA $featuredImage tidak ada.
                                      ID 'image-placeholder' digunakan oleh JavaScript.
                                    --}}
                                    <div id="image-placeholder" class="absolute inset-0 flex flex-col items-center justify-center space-y-1 text-center {{ $featuredImage ? 'hidden' : '' }}">
                                        <i class="fas fa-image fa-3x text-gray-400"></i>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="featured_image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                                <span>Upload an image</span>
                                                <input id="featured_image" name="featured_image" type="file" class="sr-only">
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                    </div>
                                    
                                    {{-- 
                                      Tampilkan gambar preview JIKA $featuredImage ADA.
                                      ID 'image-preview' digunakan oleh JavaScript.
                                    --}}
                                    <img id="image-preview" 
                                         src="{{ $featuredImage ? asset($featuredImage->image_path) : '' }}" 
                                         alt="Image preview" 
                                         class="{{ $featuredImage ? 'absolute inset-0 w-full h-full object-cover' : 'hidden' }}">
                                </div>
                            </div>

                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Other Images</label>
                                
                                {{-- Ini box untuk UPLOAD gambar BARU --}}
                                <div class="mt-1 flex justify-center py-12 px-6 border-2 border-black border-dashed rounded-md">
                                    <div class="space-y-1 text-center">
                                        <i class="fas fa-images fa-3x text-gray-400"></i>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="other_images" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                                <span>Drop your images here, or browse</span>
                                                <input id="other_images" name="other_images[]" type="file" multiple class="sr-only">
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500">jpeg, png are allowed</p>
                                    </div>
                                </div>

                                {{-- Tampilkan gambar LAMA "other images" --}}
                                <div class="space-y-3 mt-4">
                                    {{-- Kita loop semua gambar yang 'is_featured' = false --}}
                                    @foreach($product->images()->where('is_featured', false)->get() as $image)
                                        {{-- 
                                          'js-image-list-item' adalah "nama panggilan" untuk JavaScript 
                                          biar tahu div mana yang harus disembunyikan.
                                        --}}
                                        <div class="flex items-center justify-between p-3 border border-gray-300 rounded-md bg-gray-50 js-image-list-item">
                                            <div class="flex items-center space-x-3 min-w-0">
                                                <img src="{{ asset($image->image_path) }}" alt="Existing image" class="w-12 h-12 rounded-md object-cover shrink-0">
                                                {{-- 'truncate' akan memotong nama file jika terlalu panjang --}}
                                                <span class="text-sm font-medium text-gray-700 truncate max-w-48">{{ basename($image->image_path) }}</span>
                                            </div>
                                            <div class="flex items-center">
                                                <input type="checkbox" name="delete_images[]" id="delete_image_{{ $image->id }}" 
                                                       value="{{ $image->id }}" 
                                                       class="hidden peer">
                                                {{-- 
                                                  'js-delete-image-btn' adalah "nama panggilan" untuk JavaScript
                                                  biar tahu tombol mana yang harus dikasih 'event listener'.
                                                --}}
                                                <label for="delete_image_{{ $image->id }}" 
                                                       class="p-2 rounded-md cursor-pointer text-gray-400 hover:text-red-600 
                                                              peer-checked:text-red-600 peer-checked:bg-red-100 js-delete-image-btn" 
                                                       title="Mark for deletion">
                                                    <i class="fas fa-trash"></i>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Container untuk preview gambar BARU yang di-upload --}}
                                <div id="other-images-preview-container" class="space-y-3 mt-4">
                                    {{-- JavaScript akan mengisi list di sini --}}
                                </div>
                            </div>

                        </div>
                    </div> </div> <div class="flex justify-end space-x-4 mt-8 border-t border-gray-200 pt-6">
                    <a href="{{ route('products.index') }}" 
                       class="px-6 py-3 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        CANCEL
                    </a>
                    
                    {{-- Ganti teks tombol jadi 'UPDATE' --}}
                    <button type="submit" 
                            class="px-6 py-3 bg-black text-white rounded-lg font-medium hover:bg-gray-700 transition-colors duration-200">
                        UPDATE PRODUCT
                    </button>
                </div>

            </div> </div>
    </form>
</div>

{{-- SCRIPT INI UNTUK PREVIEW GAMBAR & HAPUS CLIENT-SIDE --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // === SCRIPT UNTUK MAIN IMAGE (UPLOAD PREVIEW) ===
        const fileInput = document.getElementById('featured_image');
        const preview = document.getElementById('image-preview');
        const placeholder = document.getElementById('image-placeholder');

        if (fileInput && preview && placeholder) {
            fileInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                        placeholder.classList.add('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });
        }

        // === SCRIPT UNTUK OTHER IMAGES (UPLOAD PREVIEW) ===
        const otherImagesInput = document.getElementById('other_images');
        const otherPreviewContainer = document.getElementById('other-images-preview-container');

        if (otherImagesInput && otherPreviewContainer) {
            otherImagesInput.addEventListener('change', function(event) {
                const files = event.target.files;
                otherPreviewContainer.innerHTML = ''; 

                if (files && files.length > 0) {
                    otherPreviewContainer.classList.remove('hidden');
                    Array.from(files).forEach(file => {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            // ... (logika membuat list preview untuk gambar BARU)
                            const listItem = document.createElement('div');
                            listItem.className = 'flex items-center justify-between p-3 border border-gray-300 rounded-md bg-gray-50';
                            const leftGroup = document.createElement('div');
                            leftGroup.className = 'flex items-center space-x-3';
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.alt = file.name;
                            img.className = 'w-12 h-12 rounded-md object-cover';
                            const fileName = document.createElement('span');
                            fileName.className = 'text-sm font-medium text-gray-700';
                            fileName.textContent = file.name;
                            leftGroup.appendChild(img);
                            leftGroup.appendChild(fileName);
                            const checkIcon = document.createElement('i');
                            checkIcon.className = 'fas fa-check-circle text-blue-500';
                            listItem.appendChild(leftGroup);
                            listItem.appendChild(checkIcon);
                            otherPreviewContainer.appendChild(listItem);
                        }
                        
                        reader.readAsDataURL(file);
                    });
                } else {
                    otherPreviewContainer.classList.add('hidden');
                }
            });
        }

        // =========================================================
        // === SCRIPT HAPUS 'MAIN IMAGE' (CLIENT-SIDE) ===
        // =========================================================
        const mainDeleteBtn = document.getElementById('main-delete-btn');
        if (mainDeleteBtn && preview && placeholder) {
            mainDeleteBtn.addEventListener('click', function() {
                // 1. Sembunyikan gambar preview
                preview.src = '';
                preview.classList.add('hidden');
                // 2. Tampilkan lagi placeholder
                placeholder.classList.remove('hidden');
                // 3. Sembunyikan tombol hapus itu sendiri
                this.closest('.flex').style.display = 'none'; 
            });
        }

        // =========================================================
        // === SCRIPT HAPUS 'OTHER IMAGES' (CLIENT-SIDE) ===
        // =========================================================
        // Ambil SEMUA tombol hapus yang punya class 'js-delete-image-btn'
        const deleteButtons = document.querySelectorAll('.js-delete-image-btn');
        // Loop semuanya
        deleteButtons.forEach(button => {
            // Kasih 'event listener' ke masing-masing tombol
            button.addEventListener('click', function() {
                // 1. Temukan 'list item' terdekat
                const listItem = this.closest('.js-image-list-item');
                // 2. Sembunyikan 'list item' itu dari tampilan
                if (listItem) {
                    listItem.style.display = 'none';
                }
            });
        });

    });
</script>
@endpush

@endsection