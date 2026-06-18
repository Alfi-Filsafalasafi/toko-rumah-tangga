@extends('layouts.admin')

@section('title', 'Pesanan - RumahTanggaKu')
@section('page-title', 'Pesanan')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
<style>
    #ordersTable_wrapper .dataTables_length,
    #ordersTable_wrapper .dataTables_info,
    #ordersTable_wrapper .dataTables_paginate {
        font-size: 0.8rem;
        color: #595959;
    }

    #ordersTable thead th {
        background-color: #F4F4F4;
        color: #595959;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        font-weight: 600;
        padding: 0.875rem 1rem !important;
        border-bottom: none !important;
    }

    #ordersTable tbody td {
        padding: 0.875rem 1rem;
        font-size: 0.875rem;
        vertical-align: middle;
        border-top: 1px solid #EAEAEA;
    }

    #ordersTable.dataTable {
        border-collapse: collapse !important;
    }
</style>
@endpush

@section('content')
@php
$statusLabels = [
'belum_bayar' => 'Belum Bayar',
'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
'diproses' => 'Diproses',
'selesai' => 'Selesai',
'dibatalkan' => 'Dibatalkan',
];
@endphp

<div class="bg-white rounded-xl border border-etsy-border mb-6">
    <div class="p-5 border-b border-etsy-border">
        <h2 class="text-lg font-semibold">Filter Pesanan</h2>
        <p class="text-sm text-etsy-gray mt-0.5">Saring pesanan berdasarkan status, pelanggan, atau tanggal.</p>
    </div>
    <div class="p-5">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-wrap items-end gap-4">

            <div class="w-full sm:w-auto flex-1 min-w-[200px]">
                <label class="block text-xs font-medium text-etsy-dark mb-1">Cari Pelanggan</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama atau email..."
                    class="w-full rounded-lg border border-etsy-border px-4 py-2 text-sm focus:ring-1 focus:ring-etsy-orange focus:outline-none">
            </div>

            <div class="w-full sm:w-auto flex-1 min-w-[150px]">
                <label class="block text-xs font-medium text-etsy-dark mb-1">Status Pesanan</label>
                <select name="status" class="w-full rounded-lg border border-etsy-border px-4 py-2 text-sm focus:ring-1 focus:ring-etsy-orange focus:outline-none bg-white">
                    <option value="">Semua Status</option>
                    @foreach($statuses as $status)
                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                        {{ $statusLabels[$status] }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="w-full sm:w-auto flex-1 min-w-[150px]">
                <label class="block text-xs font-medium text-etsy-dark mb-1">Dari Tanggal</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                    class="w-full rounded-lg border border-etsy-border px-4 py-2 text-sm focus:ring-1 focus:ring-etsy-orange focus:outline-none">
            </div>

            <div class="w-full sm:w-auto flex-1 min-w-[150px]">
                <label class="block text-xs font-medium text-etsy-dark mb-1">Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}"
                    class="w-full rounded-lg border border-etsy-border px-4 py-2 text-sm focus:ring-1 focus:ring-etsy-orange focus:outline-none">
            </div>

            <div class="w-full sm:w-auto flex gap-2">
                <button type="submit" class="bg-etsy-dark text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-black transition">Terapkan</button>
                <a href="{{ route('admin.orders.index') }}" class="px-5 py-2 border border-etsy-border rounded-lg text-sm font-medium text-etsy-dark hover:bg-etsy-light transition">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="bg-white rounded-xl border border-etsy-border">
    <div class="p-5 border-b border-etsy-border">
        <h2 class="text-lg font-semibold">Daftar Pesanan</h2>
    </div>

    <div class="p-5 overflow-x-auto">
        <table id="ordersTable" class="w-full text-left">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td class="font-bold text-etsy-dark">#{{ $order->id }}</td>
                    <td>
                        <p class="font-medium text-etsy-dark">{{ $order->user->name ?? 'User Terhapus' }}</p>
                        <p class="text-xs text-etsy-gray">{{ $order->user->email ?? '-' }}</p>
                    </td>
                    <td class="font-medium text-etsy-orange">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td>
                        @php
                        $badgeColor = match($order->status) {
                        'belum_bayar' => 'bg-gray-100 text-gray-700',
                        'menunggu_konfirmasi' => 'bg-yellow-100 text-yellow-700',
                        'diproses' => 'bg-blue-100 text-blue-700',
                        'selesai' => 'bg-green-100 text-green-700',
                        'dibatalkan' => 'bg-red-100 text-red-700',
                        default => 'bg-gray-100 text-gray-700'
                        };
                        @endphp
                        <span class="inline-block px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider {{ $badgeColor }}">
                            {{ $statusLabels[$order->status] }}
                        </span>
                    </td>
                    <td class="text-etsy-gray text-sm">{{ $order->created_at->format('d M Y, H:i') }}</td>
                    <td>
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.orders.show', $order) }}" title="Lihat Detail"
                                class="h-8 w-8 flex items-center justify-center rounded-lg text-white bg-etsy-dark hover:bg-black transition">
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#ordersTable').DataTable({
            paging: false,
            info: false,
            searching: false,
            columnDefs: [{
                orderable: false,
                targets: [5]
            }],
            order: [
                [0, 'desc']
            ]
        });
    });
</script>
@endpush