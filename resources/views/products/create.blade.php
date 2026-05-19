{{-- resources/views/products/create.blade.php --}}

@extends('layouts.app')

@section('title', 'Add New Product')
@section('page-title', 'Add New Product')

@section('content')
<div class="max-w-6xl mx-auto">
    {{-- Ini adalah breadcrumb (penunjuk halaman) --}}
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">@yield('page-title', 'Add New Products')</h1>
            <p class="text-sm text-gray-500 mt-1">Home > All Products > @yield('page-title', 'Add New Products')</p>
        </div>
    </div>
    
    {{-- 
      Form ini menargetkan route 'products.store' (method store() di ProductController).
      method="POST" adalah standar.
      enctype="multipart/form-data" WAJIB ada jika form kamu meng-upload file/gambar.
    --}}
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        {{-- @csrf adalah token keamanan Laravel, WAJIB ada di semua form POST/PUT/DELETE --}}
        @csrf
        <div class="grid grid-cols-1 gap-6">
            
            <div class="bg-white p-6 rounded-lg shadow-md">
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                            <input type="text" name="name" id="name" placeholder="Type name here" 
                                   class="mt-1 block w-full rounded-md border-black py-3 px-4 shadow-sm focus:border-black focus:ring-black">
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="description" id="description" rows="4" placeholder="Type description here"
                                      class="mt-1 block w-full rounded-md border-black py-3 px-4 shadow-sm focus:border-black focus:ring-black"></textarea>
                        </div>

                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select name="category_id" id="category_id"
                                    class="mt-1 block w-full rounded-md border-black py-3 px-4 shadow-sm focus:border-black focus:ring-black">
                                <option value="">Type Category here</option>
                                {{-- 
                                  Variabel $categories ini dikirim dari ProductController, 
                                  tepatnya dari method create().
                                --}}
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="brand_name" class="block text-sm font-medium text-gray-700 mb-1">Brand Name</label>
                            <input type="text" name="brand_name" id="brand_name" placeholder="Type brand name here" 
                                   class="mt-1 block w-full rounded-md border-black py-3 px-4 shadow-sm focus:border-black focus:ring-black">
                        </div>

                        <div>
                            <label for="supplier" class="block text-sm font-medium text-gray-700 mb-1">Supplier</label>
                            <input type="text" name="supplier" id="supplier" placeholder="Type supplier name here" 
                                   class="mt-1 block w-full rounded-md border-black py-3 px-4 shadow-sm focus:border-black focus:ring-black">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity</label>
                                <input type="number" name="stock" id="stock" placeholder="1258" 
                                       class="mt-1 block w-full rounded-md border-black py-3 px-4 shadow-sm focus:border-black focus:ring-black">
                            </div>
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Regular Price</label>
                                <input type="number" name="price" id="price" placeholder="$1000" step="0.01"
                                       class="mt-1 block w-full rounded-md border-black py-3 px-4 shadow-sm focus:border-black focus:ring-black">
                            </div>
                        </div>

                        <div>
                            <label for="tags" class="block text-sm font-medium text-gray-700 mb-1">Tag</label>
                            {{-- 
                              Input 'tags' ini akan di-handle di Controller.
                              Controller akan mengambil string "Adidas, Shoes, Sneakers",
                              memecahnya (explode) berdasarkan koma, lalu menyimpannya satu per satu.
                            --}}
                            <input type="text" name="tags" id="tags" placeholder="e.g., Adidas, Shoes, Sneakers"
                                   class="mt-1 block w-full rounded-md border-black py-3 px-4 shadow-sm focus:border-black focus:ring-black">
                            <p class="mt-2 text-xs text-gray-500">Pisahkan setiap tag dengan koma ( , ).</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <h4 class="text-lg font-medium text-gray-800 mb-4">Product Gallery</h4>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Main Image (Featured)</label>
                                {{-- 
                                  Ini adalah box upload/preview.
                                  'relative aspect-square' membuatnya jadi kotak persegi 1:1.
                                  'overflow-hidden' memastikan gambar preview-nya ikut 'rounded-md'.
                                --}}
                                <div class="mt-1 relative aspect-square w-full border-2 border-black border-dashed rounded-md overflow-hidden">
                                    
                                    {{-- 
                                      1. Placeholder (Ikon & Teks)
                                      'id="image-placeholder"' dipakai oleh JS untuk disembunyikan.
                                      'absolute inset-0' membuatnya memenuhi box.
                                    --}}
                                    <div id="image-placeholder" class="absolute inset-0 flex flex-col items-center justify-center space-y-1 text-center">
                                        <i class="fas fa-image fa-3x text-gray-400"></i>
                                        <div class="flex text-sm text-gray-600">
                                            {{-- 
                                              Trik upload: <input> aslinya disembunyikan pakai 'sr-only'.
                                              Yang diklik oleh user sebenarnya adalah <label>-nya.
                                            --}}
                                            <label for="featured_image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                                <span>Upload an image</span>
                                                <input id="featured_image" name="featured_image" type="file" class="sr-only">
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                    </div>

                                    {{-- 
                                      2. Preview Image
                                      'id="image-preview"' dipakai oleh JS untuk diisi 'src'-nya.
                                      'hidden' agar awalnya sembunyi. 'absolute inset-0' dan 'object-cover'
                                      membuatnya mengisi box persegi dengan rapi (tanpa gepeng).
                                    --}}
                                    <img id="image-preview" src="" alt="Image preview" 
                                         class="hidden absolute inset-0 w-full h-full object-cover">
                                
                                </div>
                            </div>

                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Other Images</label>
                                
                                {{-- 
                                  1. Box Upload 'Other Images'
                                  Box ini akan SELALU terlihat.
                                --}}
                                <div class="mt-1 flex justify-center py-12 px-6 border-2 border-black border-dashed rounded-md">
                                    <div class="space-y-1 text-center">
                                        <i class="fas fa-images fa-3x text-gray-400"></i>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="other_images" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                                <span>Drop your images here, or browse</span>
                                                {{-- 
                                                  'name="other_images[]"' (dengan tanda []) 
                                                  penting agar bisa upload BANYAK file.
                                                  'multiple' juga wajib ada.
                                                --}}
                                                <input id="other_images" name="other_images[]" type="file" multiple class="sr-only">
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500">jpeg, png are allowed</p>
                                    </div>
                                </div>

                                {{-- 
                                  2. Container Preview 'Other Images'
                                  'id="other-images-preview-container"' dipakai oleh JS
                                  sebagai tempat menaruh list preview gambar yang baru di-upload.
                                --}}
                                <div id="other-images-preview-container" class="space-y-3 mt-4">
                                    {{-- JavaScript akan mengisi list di sini --}}
                                </div>
                            </div>
                        </div>
                    </div> 
                </div> 
                <div class="flex justify-end space-x-4 mt-8 border-t border-gray-200 pt-6">
                    <a href="{{ route('products.index') }}" 
                       class="px-6 py-3 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        CANCEL
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-black text-white rounded-lg font-medium hover:bg-gray-700 transition-colors duration-200">
                        SAVE PRODUCT
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- 
  @push('scripts') adalah cara Laravel untuk "mengirim" blok <script> ini
  ke file layout utama (app.blade.php), tepat di atas </body>.
  Ini best practice agar JS tidak mengganggu loading halaman.
--}}
@push('scripts')
<script>
    // 'DOMContentLoaded' memastikan script ini jalan HANYA SETELAH
    // semua HTML selesai di-load oleh browser.
    document.addEventListener('DOMContentLoaded', function() {
        
        // === SCRIPT UNTUK MAIN IMAGE (SINGLE PREVIEW) ===
        const fileInput = document.getElementById('featured_image');
        const preview = document.getElementById('image-preview');
        const placeholder = document.getElementById('image-placeholder');

        // Cek dulu apakah semua elemennya ada
        if (fileInput && preview && placeholder) {
            // Pasang 'event listener' (mata-mata) di input file
            fileInput.addEventListener('change', function(event) {
                // Ambil file pertama yang dipilih
                const file = event.target.files[0];
                if (file) {
                    // FileReader adalah API browser untuk baca file
                    const reader = new FileReader();
                    
                    // 'reader.onload' adalah event yang jalan SETELAH file selesai dibaca
                    reader.onload = function(e) {
                        // e.target.result adalah data gambar (format base64)
                        preview.src = e.target.result;
                        // Hapus class 'hidden' dari <img>
                        preview.classList.remove('hidden');
                        // Tambah class 'hidden' ke placeholder (ikon & teks)
                        placeholder.classList.add('hidden');
                    }
                    
                    // Perintah untuk mulai membaca file
                    reader.readAsDataURL(file);
                }
            });
        }

        // === SCRIPT BARU UNTUK OTHER IMAGES (MULTI PREVIEW SEBAGAI LIST) ===
        const otherImagesInput = document.getElementById('other_images');
        const otherPreviewContainer = document.getElementById('other-images-preview-container');

        if (otherImagesInput && otherPreviewContainer) {
            otherImagesInput.addEventListener('change', function(event) {
                // Ambil SEMUA file yang dipilih (karena 'multiple')
                const files = event.target.files;
                
                // Kosongkan container preview setiap kali ada file baru dipilih
                otherPreviewContainer.innerHTML = ''; 

                if (files && files.length > 0) {
                    // Tampilkan container-nya (yang tadinya 'hidden' atau kosong)
                    otherPreviewContainer.classList.remove('hidden');

                    // Loop setiap file yang ada di 'files'
                    Array.from(files).forEach(file => {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            // Ini adalah 'Dynamic HTML Generation'
                            // Kita membuat elemen HTML baru pakai JavaScript

                            // 1. Buat <div> pembungkus
                            const listItem = document.createElement('div');
                            listItem.className = 'flex items-center justify-between p-3 border border-gray-300 rounded-md bg-gray-50';
                            
                            // 2. Buat <div> grup kiri
                            const leftGroup = document.createElement('div');
                            leftGroup.className = 'flex items-center space-x-3';

                            // 3. Buat <img> thumbnail
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.alt = file.name;
                            img.className = 'w-12 h-12 rounded-md object-cover';
                            
                            // 4. Buat <span> nama file
                            const fileName = document.createElement('span');
                            fileName.className = 'text-sm font-medium text-gray-700';
                            fileName.textContent = file.name;

                            // 5. Gabungkan (img + nama) -> grup kiri
                            leftGroup.appendChild(img);
                            leftGroup.appendChild(fileName);

                            // 6. Buat <i> ikon centang
                            const checkIcon = document.createElement('i');
                            checkIcon.className = 'fas fa-check-circle text-blue-500';

                            // 7. Gabungkan (grup kiri + ikon) -> list item
                            listItem.appendChild(leftGroup);
                            listItem.appendChild(checkIcon);

                            // 8. Masukkan list item yang sudah jadi ke container di HTML
                            otherPreviewContainer.appendChild(listItem);
                        }
                        
                        // Perintah untuk mulai membaca file (per file di dalam loop)
                        reader.readAsDataURL(file);
                    });
                } else {
                    // Jika user batal milih file, sembunyikan lagi container-nya
                    otherPreviewContainer.classList.add('hidden');
                }
            });
        }
    });
</script>
@endpush

@endsection