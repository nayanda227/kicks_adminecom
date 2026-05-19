<aside class="w-56 bg-white text-black flex flex-col h-full shadow-lg">
    
    <div class="flex items-center justify-center h-20 bg-white border-b border-gray-200"> 
        <a href="{{ route('dashboard') }}" class="text-2xl font-bold tracking-wider text-black">KICKS</a> 
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2">
        
        {{-- Link Dashboard --}}
        <a href="{{ route('dashboard') }}"
           class="flex items-center p-3 rounded-lg transition-colors duration-200
                  {{ request()->routeIs('dashboard') ? 'bg-gray-800 text-white shadow-md' : 'text-black hover:bg-gray-800 hover:text-white' }}">
            <i class="fas fa-chart-line mr-3"></i>
            <span>Dashboard</span>
        </a>
        
        {{-- Link All Products --}}
        <a href="{{ route('products.index') }}"
           class="flex items-center p-3 rounded-lg transition-colors duration-200
                  {{--'products.*' agar aktif di create/edit/show --}}
                  {{ request()->routeIs('products.*') ? 'bg-gray-800 text-white shadow-md' : 'text-black hover:bg-gray-800 hover:text-white' }}">
            <i class="fas fa-box-open mr-3"></i>
            <span>All Products</span>
        </a>
        
        {{-- Link Order List --}}
        <a href="{{ route('orders.index') }}" 
           class="flex items-center p-3 rounded-lg transition-colors duration-200
                  {{ request()->routeIs('orders.*') ? 'bg-gray-800 text-white shadow-md' : 'text-black hover:bg-gray-800 hover:text-white' }}">
            <i class="fas fa-clipboard-list mr-3"></i>
            <span>Order List</span>
        </a> 
          
        {{-- Accordion untuk Categories --}}
        <details class="group" open> {{-- agar defaultnya terbuka --}}
            
            <summary class="flex items-center justify-between p-3 rounded-lg text-black hover:bg-gray-800 hover:text-white transition-colors duration-200 cursor-pointer list-none">
                <span class="flex items-center">
                    <i class="fas fa-tags mr-3"></i>
                    <span>Categories</span>
                </span>
                <i class="fas fa-chevron-down transition-transform duration-200 group-open:rotate-180"></i>
            </summary>

            <div class="mt-2 space-y-1 pl-6">

                @foreach ($categories as $category) 
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" 
                   class="flex justify-between items-center p-2 rounded-lg transition-colors duration-200
                          {{ request('category') == $category->slug 
                             ? 'text-blue-600 font-bold' 
                             : 'text-gray-600 hover:text-black' }}">
                    
                    <span class="flex items-center text-sm">
                        <i class="fas fa-shoe-prints mr-3 text-gray-400"></i> 
                        <span>{{ $category->name }}</span>
                    </span>
                    <span class="bg-gray-200 text-gray-700 text-xs font-bold px-2 py-0.5 rounded-full">
                        {{ $category->products_count }}
                    </span>
                </a>
                @endforeach
            </div>
        </details>  
    </nav>
</aside>