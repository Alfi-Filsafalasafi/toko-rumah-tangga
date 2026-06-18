@extends('layouts.admin')

@section('title', 'Kategori - RumahTanggaKu')
@section('page-title', 'Kategori')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
<style>
    #categoriesTable_wrapper .dataTables_length select,
    #categoriesTable_wrapper .dataTables_filter input {
        border: 1px solid #EAEAEA;
        border-radius: 0.5rem;
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        outline: none;
    }

    #categoriesTable_wrapper .dataTables_filter input:focus,
    #categoriesTable_wrapper .dataTables_length select:focus {
        border-color: #F1641E;
    }

    #categoriesTable_wrapper .dataTables_length,
    #categoriesTable_wrapper .dataTables_filter,
    #categoriesTable_wrapper .dataTables_info,
    #categoriesTable_wrapper .dataTables_paginate {
        font-size: 0.8rem;
        color: #595959;
    }

    #categoriesTable thead th {
        background-color: #F4F4F4;
        color: #595959;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        font-weight: 600;
        padding: 0.875rem 1rem !important;
        border-bottom: none !important;
    }

    #categoriesTable tbody td {
        padding: 0.875rem 1rem;
        font-size: 0.875rem;
        vertical-align: middle;
        border-top: 1px solid #EAEAEA;
    }

    #categoriesTable.dataTable {
        border-collapse: collapse !important;
    }

    #categoriesTable_wrapper .dataTables_paginate .paginate_button {
        border-radius: 0.375rem !important;
        padding: 0.3rem 0.65rem !important;
        margin-left: 2px;
        border: 1px solid transparent !important;
        background: transparent !important;
    }

    #categoriesTable_wrapper .dataTables_paginate .paginate_button.current,
    #categoriesTable_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: #F1641E !important;
        color: white !important;
        border-color: #F1641E !important;
    }

    #categoriesTable_wrapper .dataTables_paginate .paginate_button:hover {
        background: #F4F4F4 !important;
        color: #222222 !important;
    }
</style>
@endpush

@section('content')
<div class="bg-white rounded-xl border border-etsy-border">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 p-5 border-b border-etsy-border">
        <div>
            <h2 class="text-lg font-semibold">Daftar Kategori</h2>
            <p class="text-sm text-etsy-gray mt-0.5">Kelola kategori produk toko Anda.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}"
            class="inline-flex items-center gap-2 bg-etsy-orange text-white text-sm font-medium px-4 py-2.5 rounded-lg hover:bg-etsy-orange/90 transition shrink-0">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Kategori</span>
        </a>
    </div>

    <div class="p-5 overflow-x-auto">
        <table id="categoriesTable" class="w-full text-left">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Slug</th>
                    <th>Jumlah Produk</th>
                    <th>Dibuat</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="font-medium text-etsy-dark">{{ $category->name }}</td>
                    <td>
                        <span class="inline-block bg-etsy-light text-etsy-gray text-xs px-2 py-1 rounded-md">
                            {{ $category->slug }}
                        </span>
                    </td>
                    <td>{{ $category->products_count }}</td>
                    <td>{{ $category->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.categories.show', $category) }}" title="Lihat"
                                class="h-8 w-8 flex items-center justify-center rounded-lg text-etsy-gray hover:bg-etsy-light hover:text-etsy-dark transition">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.categories.edit', $category) }}" title="Edit"
                                class="h-8 w-8 flex items-center justify-center rounded-lg text-blue-500 hover:bg-blue-50 transition">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                onsubmit="return confirm('Hapus kategori \'{{ $category->name }}\'? Tindakan ini tidak dapat dibatalkan.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Hapus"
                                    class="h-8 w-8 flex items-center justify-center rounded-lg text-red-500 hover:bg-red-50 transition">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#categoriesTable').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/id.json'
            },
            columnDefs: [
                { orderable: false, targets: [0, 5] },
                { searchable: false, targets: [0, 3, 4, 5] }
            ],
            order: [[1, 'asc']]
        });
    });
</script>
@endpush
