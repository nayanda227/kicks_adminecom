{{-- resources/views/dashboard.blade.php --}}

@extends('layouts.app')

@section('title', 'Dashboard - KICKS')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-4">
    {{-- Ini adalah breadcrumb (penunjuk halaman) --}}
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
            <p class="text-sm text-gray-500 mt-1">Home > @yield('page-title', 'Dashboard')</p>
        </div>
        <div class="flex items-center bg-white rounded-lg shadow-sm px-4 py-2 text-sm text-gray-600">
            <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>
            <span>Nov 6,2025 - Nov 10,2025</span>
            <i class="fas fa-chevron-down text-xs ml-2 text-gray-400"></i>
        </div>
    </div>

    {{-- KARTU STATISTIK --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <div class="bg-white rounded-lg shadow-md p-6 flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <h4 class="text-gray-600 font-medium">Total Orders</h4>
                <button class="text-gray-400 hover:text-gray-600"><i class="fas fa-ellipsis-v"></i></button>
            </div>
            {{-- 
              Variabel $totalOrderValue ini dikirim dari DashboardController.
              number_format() adalah fungsi PHP untuk menambahkan koma (126,500).
            --}}
            <p class="text-3xl font-bold text-gray-800">${{ number_format($totalOrderValue) }}</p>
            <div class="flex items-center text-sm mt-2">
                <i class="fas fa-arrow-up text-green-500 mr-1"></i>
                <span class="text-green-500">34.7%</span>
                <span class="text-gray-500 ml-2">Compared to Nov 2025</span>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6 flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <h4 class="text-gray-600 font-medium">Active Orders</h4>
                <button class="text-gray-400 hover:text-gray-600"><i class="fas fa-ellipsis-v"></i></button>
            </div>
            <p class="text-3xl font-bold text-gray-800">${{ number_format($activeOrderValue) }}</p>
            <div class="flex items-center text-sm mt-2">
                <i class="fas fa-arrow-up text-green-500 mr-1"></i>
                <span class="text-green-500">34.7%</span>
                <span class="text-gray-500 ml-2">Compared to Nov 2025</span>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6 flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <h4 class="text-gray-600 font-medium">Shipped Orders</h4>
                <button class="text-gray-400 hover:text-gray-600"><i class="fas fa-ellipsis-v"></i></button>
            </div>
            <p class="text-3xl font-bold text-gray-800">${{ number_format($shippedOrderValue) }}</p>
            <div class="flex items-center text-sm mt-2">
                <i class="fas fa-arrow-up text-green-500 mr-1"></i>
                <span class="text-green-500">34.7%</span>
                <span class="text-gray-500 ml-2">Compared to Nov 2025</span>
            </div>
        </div>
    </div>

    {{-- GRAFIK & BEST SELLERS --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-gray-800 font-medium">Sale Graph</h4>
                <div class="flex space-x-2 text-sm">
                    <button class="px-3 py-1 rounded-md border border-black bg-white text-black">WEEKLY</button>
                    <button class="px-3 py-1 rounded-md bg-black text-white border-b-2 border-blue-500">MONTHLY</button>
                    <button class="px-3 py-1 rounded-md border border-black bg-white text-black">YEARLY</button>
                </div>
            </div>
            {{-- 
              Elemen <canvas> ini adalah "kanvas kosong" untuk Chart.js.
              ID 'salesChart' dipakai oleh JavaScript di bawah untuk menggambar grafiknya.
            --}}
            <div class="h-64">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-start mb-4">
                <h4 class="text-gray-800 font-medium">Best Sellers</h4>
                <button class="text-gray-400 hover:text-gray-600"><i class="fas fa-ellipsis-v"></i></button>
            </div>
            <div class="space-y-4">
                
                {{-- BEST SELLERS (DINAMIS DARI CONTROLLER) --}}
                @forelse ($bestSellers as $product)
                <div class="flex items-center">
                    {{-- 
                      Kita pakai helper asset() untuk membuat URL yang benar.
                      $product->images->first()->image_path adalah path gambar dari object dummy.
                    --}}
                    <img src="{{ asset($product->images->first()->image_path) }}" alt="{{ $product->name }}" class="w-16 h-16 rounded-md object-cover mr-4">
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">{{ $product->name }}</p>
                        <p class="text-sm text-gray-600">${{ number_format($product->price, 2) }}</p>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-500">No best sellers yet.</p>
                @endforelse
                
                <button class="mt-4 w-24 py-2 bg-black text-white rounded-lg font-medium hover:bg-gray-700 transition-colors duration-200">
                    REPORT
                </button>
            </div>
        </div>
    </div>

    {{-- RECENT ORDERS (DINAMIS DARI CONTROLLER) --}}
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-start mb-4">
            <h4 class="text-gray-800 font-bold">Recent Orders</h4>
            <button class="text-gray-400 hover:text-gray-600"><i class="fas fa-ellipsis-v"></i></button>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-white">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" class="form-checkbox h-4 w-4 text-kicks-blue rounded border-gray-300">
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    
                    {{-- Kita looping variabel $recentOrders dari Controller --}}
                    @forelse ($recentOrders as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap"><input type="checkbox" class="form-checkbox h-4 w-4 text-kicks-blue rounded border-gray-300"></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Adidas Ultra Boost</td> 
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->order_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{-- 
                              FIX untuk DUMMY DATA:
                              $order->created_at adalah 'string', jadi harus dibungkus
                              \Carbon\Carbon::parse() dulu baru bisa di ->format().
                            --}}
                            {{ \Carbon\Carbon::parse($order->created_at)->format('M jS, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{-- Logika Blade @if untuk ganti warna status --}}
                            @if ($order->status == 'Delivered')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"> Delivered </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800"> Canceled </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                            No recent orders found.
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

{{-- SCRIPT DIPINDAH KE SINI & DIBUAT DINAMIS --}}
@push('scripts')
{{-- 
  PENTING: Pastikan kamu sudah load Chart.js di <head> file 'layouts/app.blade.php'.
  Contoh: <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
--}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Ambil data dari Controller
    {{-- 
      @json() adalah helper Blade yang aman untuk mengubah
      array PHP ($saleGraphData) menjadi array JavaScript.
      Hasilnya: const saleGraphData = {'Jul': 10000, 'Aug': 20000, ...};
    --}}
    const saleGraphData = @json($saleGraphData);
    const chartLabels = Object.keys(saleGraphData); // -> ['Jul', 'Aug', ...]
    const chartData = Object.values(saleGraphData); // -> [10000, 20000, ...]

    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartLabels, // <-- Data dinamis dari Controller
            datasets: [{
                label: 'Sales',
                data: chartData, // <-- Data dinamis dari Controller
                borderColor: 'rgba(59, 130, 246, 1)',
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                tension: 0.4,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Penting agar chart bisa mengisi 'h-64'
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        // Fungsi callback untuk format label sumbu Y jadi $
                        callback: function(value, index, values) {
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false // Sembunyikan label "Sales" di atas chart
                }
            }
        }
    });
});
</script>
@endpush