{{-- resources/views/layouts/partials/header.blade.php --}}
<header class="bg-white shadow-sm h-20 flex items-center justify-end px-6 border-b border-gray-200">
    
    <div class="flex items-center space-x-4">
        <button class="text-gray-600 hover:text-gray-800 text-lg">
            <i class="fas fa-search"></i>
        </button>
        <button class="text-gray-600 hover:text-gray-800 text-lg">
            <i class="fas fa-bell"></i>
        </button>
        
        <div class="relative">
            <button class="flex items-center p-2 border border-gray-800 rounded-md hover:bg-gray-100 focus:outline-none">
                <span class="mr-2 text-gray-700 text-sm">ADMIN</span>
                <i class="fas fa-chevron-down text-xs ml-2 text-gray-500"></i>
            </button>
        </div>
    </div>
</header>