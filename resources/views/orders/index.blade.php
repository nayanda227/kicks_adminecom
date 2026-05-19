{{-- resources/views/orders/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Order List - KICKS')
@section('page-title', 'Order List')

@section('content')

<div class="flex justify-between items-start mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-800">@yield('page-title', 'Order List')</h1>
        <p class="text-sm text-gray-500 mt-1">Home > @yield('page-title', 'Order List')</p>
    </div>

    <div class="flex items-center bg-white rounded-lg shadow-sm px-4 py-2 text-sm text-gray-600">
        <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>
        <span>Nov 6,2025 - Nov 10,2025</span>
        <i class="fas fa-chevron-down text-xs ml-2 text-gray-400"></i>
    </div>
</div>

{{-- Ini adalah tabel yang kita copy dari dashboard --}}
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-start mb-4">
        {{-- Ganti judulnya jadi 'All Orders' --}}
        <h4 class="text-gray-800 font-bold">All Orders</h4>
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
                
                {{-- 
                  Kita pakai @forelse BUKAN @foreach.
                  @forelse punya 'bonus' @empty, yang akan jalan kalau $orders-nya kosong.
                --}}
                @forelse ($orders as $order)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap"><input type="checkbox" class="form-checkbox h-4 w-4 text-kicks-blue rounded border-gray-300"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{-- 
                          INI BAGIAN TRICKY (Relasi):
                          1. $order->items: Ambil SEMUA item di order ini (dari relasi 'items()' di Model Order).
                          2. ->first(): Ambil HANYA item PERTAMA dari list itu.
                          3. ->product->name: Ambil NAMA PRODUK dari item pertama itu.
                          4. ?? 'N/A': Ini "Null Coalescing Operator". Kalau item/produknya nggak ada (misal udah kehapus), 
                                       tampilkan 'N/A' biar halaman nggak crash.
                        --}}
                        {{ $order->items->first()->product->name ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->order_number }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{-- 
                          INI FIX UNTUK DUMMY DATA:
                          $order->created_at dari controller dummy adalah 'string' (teks biasa), bukan 'Objek Tanggal'.
                          Kalau kita panggil ->format() di 'string', pasti error (Call to a member function format() on string).
                          Solusinya: Kita "bungkus" string-nya pakai '\Carbon\Carbon::parse()' dulu
                          biar jadi 'Objek Tanggal' baru bisa di-format.
                        --}}
                        {{ \Carbon\Carbon::parse($order->created_at)->format('M jS, Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{-- Ambil nama customer dari relasi 'user()' di Model Order --}}
                        {{ $order->user->name ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{-- Ini logika standar Blade untuk ganti warna status --}}
                        @if ($order->status == 'Delivered')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"> Delivered </span>
                        @elseif ($order->status == 'Canceled')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800"> Canceled </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800"> {{ $order->status }} </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($order->total_amount, 2) }}</td>
                </tr>
                
                {{-- Ini bagian 'bonus' dari @forelse --}}
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                        No orders found.
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    {{-- PAGINASI --}}
    <div class="mt-6">
        {{-- 
          INI FIX PALING PENTING UNTUK DUMMY DATA:
          
          Saat pakai data ASLI dari DB, $orders adalah object 'Paginator' dan punya method ->links().
          Saat pakai data DUMMY dari Controller, $orders adalah object 'Collection' (array) biasa, 
          dan memanggil ->links() di 'Collection' akan bikin CRASH.
          
          Solusi: Kita cek dulu tipe datanya.
          "@if($orders instanceof \Illuminate\Pagination\LengthAwarePaginator)"
          Artinya: "JIKA $orders adalah object Paginator, MAKA tampilkan link halaman."
          (Kalau datanya dummy, dia akan skip bagian ini dan nggak error).
        --}}
        @if($orders instanceof \Illuminate\Pagination\LengthAwarePaginator)
            {{ $orders->links() }}
        @endif
    </div>
</div>
@endsection