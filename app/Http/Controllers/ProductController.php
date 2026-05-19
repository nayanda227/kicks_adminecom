<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController; 
use App\Models\Product;
use App\Models\Category; 
use App\Models\Tag;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends BaseController 
{
    public function index(Request $request) 
    {
        $productQuery = Product::with('images', 'category')->withCount('orderItems');

        if ($request->has('category')) {
            $categorySlug = $request->input('category');
            $productQuery->whereHas('category', function ($query) use ($categorySlug) {
                $query->where('slug', $categorySlug);
            });
        }

        $products = $productQuery->latest()->paginate(9);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $tags = Tag::orderBy('name')->get();
        return view('products.create', compact('tags'));
    }

    public function store(Request $request)
    {
        // menmbahkan supplier
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'brand_name' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'supplier' => 'nullable|string|max:255', 
            'tags' => 'nullable|string',
            'featured_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'other_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Menaambahkan 'supplier' di create
        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'category_id' => $validated['category_id'],
            'brand_name' => $validated['brand_name'] ?? null,
            'stock' => $validated['stock'],
            'price' => $validated['price'],
            'supplier' => $validated['supplier'] ?? null,
        ]);

        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = 'assets/product-images';
            $file->move(public_path($path), $filename); 

            $product->images()->create([
                'image_path' => $path . '/' . $filename,
                'is_featured' => true
            ]);
        }

        if ($request->hasFile('other_images')) {
            foreach ($request->file('other_images') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = 'assets/product-images';
                $file->move(public_path($path), $filename);
                
                $product->images()->create([
                    'image_path' => $path . '/' . $filename,
                    'is_featured' => false
                ]);
            }
        }

        if (!empty($validated['tags'])) {
            $tagNames = explode(',', $validated['tags']);
            $tagIds = [];
            foreach ($tagNames as $tagName) {
                $tagName = trim($tagName);
                if ($tagName) {
                    $tag = Tag::firstOrCreate(
                        ['slug' => Str::slug($tagName)],
                        ['name' => $tagName]
                    );
                    $tagIds[] = $tag->id;
                }
            }
            $product->tags()->sync($tagIds);
        }

        return redirect()->route('products.index')
                         ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $tags = Tag::orderBy('name')->get();
        return view('products.edit', compact('product', 'tags'));
    }

    public function update(Request $request, Product $product)
    {
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'brand_name' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'supplier' => 'nullable|string|max:255', 
            'tags' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'other_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);


        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'category_id' => $validated['category_id'],
            'brand_name' => $validated['brand_name'] ?? null,
            'stock' => $validated['stock'],
            'price' => $validated['price'],
            'supplier' => $validated['supplier'] ?? null,
        ]);

        // Handle image deletions
        if ($request->has('delete_featured_image')) {
            $image = ProductImage::find($request->input('delete_featured_image'));
            if ($image && $image->product_id == $product->id) {
                if (file_exists(public_path($image->image_path))) {
                    unlink(public_path($image->image_path));
                }
                $image->delete();
            }
        }

        if ($request->has('delete_images')) {
            $imageIdsToDelete = $request->input('delete_images');
            $imagesToDelete = ProductImage::whereIn('id', $imageIdsToDelete)->get();
            foreach ($imagesToDelete as $image) {
                if ($image->product_id == $product->id) {
                    if (file_exists(public_path($image->image_path))) {
                        unlink(public_path($image->image_path));
                    }
                    $image->delete();
                }
            }
        }

        if ($request->hasFile('featured_image')) {
            $oldImage = $product->images()->where('is_featured', true)->first();
            if ($oldImage) {
                if (file_exists(public_path($oldImage->image_path))) {
                    unlink(public_path($oldImage->image_path));
                }
                $oldImage->delete();
            }

            $file = $request->file('featured_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = 'assets/product-images';
            $file->move(public_path($path), $filename); 
            
            $product->images()->create([
                'image_path' => $path . '/' . $filename,
                'is_featured' => true
            ]);
        }

        if ($request->hasFile('other_images')) {
            foreach ($request->file('other_images') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = 'assets/product-images';
                $file->move(public_path($path), $filename);
                
                $product->images()->create([
                    'image_path' => $path . '/' . $filename,
                    'is_featured' => false
                ]);
            }
        }

        if (!empty($validated['tags'])) {
            $tagNames = explode(',', $validated['tags']);
            $tagIds = [];
            foreach ($tagNames as $tagName) {
                $tagName = trim($tagName);
                if ($tagName) { 
                    $tag = Tag::firstOrCreate(
                        ['slug' => Str::slug($tagName)],
                        ['name' => $tagName]
                    );
                    $tagIds[] = $tag->id;
                }
            }
            $product->tags()->sync($tagIds);
        } else {
            $product->tags()->sync([]);
        }

        return redirect()->route('products.index')
                         ->with('success', 'Produk berhasil di-update!');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $image) {
            if (file_exists(public_path($image->image_path))) {
                unlink(public_path($image->image_path));
            }
        }

        $product->delete();

        return redirect()->route('products.index')
                         ->with('success', 'Produk berhasil dihapus!');
    }
}
