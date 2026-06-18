@extends('layouts.app')

@section('title', 'Checkout - RumahTanggaKu')

@section('content')
<div class="bg-etsy-light min-h-screen py-10">
    <div class="container mx-auto px-4 max-w-2xl">
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-etsy-border">
            <h1 class="text-2xl font-bold text-etsy-dark mb-6">Checkout Pesanan</h1>

            <!-- Ringkasan Total -->
            <div class="bg-etsy-light p-4 rounded-lg mb-8">
                <p class="text-sm text-etsy-gray">Total yang harus dibayar:</p>
                <p class="text-2xl font-bold text-etsy-orange">Rp {{ number_format(array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], session('cart', []))), 0, ',', '.') }}</p>
            </div>

            <!-- Pilih Bank Tujuan Transfer -->
            <div class="mb-6">
                <p class="text-sm font-medium text-etsy-dark mb-3">Pilih Bank Tujuan Transfer</p>
                <div class="grid grid-cols-2 gap-3">

                    @php
                    $banks = [
                    'BRI' => ['color' => '#00529C', 'logo' => 'BRI', 'norek' => '1234-5678-9012-3456', 'atas_nama' => 'PT RumahTanggaKu'],
                    'BCA' => ['color' => '#0066AE', 'logo' => 'BCA', 'norek' => '8765-4321-0987-6543', 'atas_nama' => 'PT RumahTanggaKu'],
                    'BNI' => ['color' => '#FF6600', 'logo' => 'BNI', 'norek' => '1122-3344-5566-7788', 'atas_nama' => 'PT RumahTanggaKu'],
                    'MANDIRI' => ['color' => '#003D80', 'logo' => 'MANDIRI', 'norek' => '9988-7766-5544-3322', 'atas_nama' => 'PT RumahTanggaKu'],
                    ];
                    @endphp

                    @foreach($banks as $kode => $bank)
                    <label class="cursor-pointer">
                        <input type="radio" name="_bank_selected" value="{{ $kode }}" class="sr-only peer" onchange="showBankDetail('{{ $kode }}')">
                        <div class="flex items-center gap-3 p-3 rounded-xl border-2 border-etsy-border peer-checked:border-etsy-dark peer-checked:bg-etsy-light transition">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0 text-white text-xs font-black"
                                style="background-color: {{ $bank['color'] }}">
                                {{ $bank['logo'] }}
                            </div>
                            <span class="text-sm font-semibold text-etsy-dark">Bank {{ $kode }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-etsy-dark ml-auto opacity-0 peer-checked:opacity-100 transition" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </label>
                    @endforeach
                </div>

                <!-- Detail rekening bank yang dipilih -->
                @foreach($banks as $kode => $bank)
                <div id="detail-{{ $kode }}" class="hidden mt-4 p-4 rounded-xl border border-etsy-border bg-etsy-light">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white text-xs font-black shrink-0"
                            style="background-color: {{ $bank['color'] }}">
                            {{ $bank['logo'] }}
                        </div>
                        <div>
                            <p class="text-xs text-etsy-gray">Bank {{ $kode }}</p>
                            <p class="text-sm font-bold text-etsy-dark">{{ $bank['atas_nama'] }}</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between bg-white rounded-lg px-4 py-3 border border-etsy-border">
                        <div>
                            <p class="text-xs text-etsy-gray mb-0.5">Nomor Rekening</p>
                            <p id="norek-{{ $kode }}" class="text-lg font-bold text-etsy-dark tracking-widest">{{ $bank['norek'] }}</p>
                        </div>
                        <button type="button" onclick="copyNorek('{{ $kode }}', '{{ $bank['norek'] }}')"
                            class="text-xs font-semibold text-etsy-orange border border-etsy-orange px-3 py-1.5 rounded-full hover:bg-orange-50 transition shrink-0">
                            Salin
                        </button>
                    </div>
                    <p class="text-xs text-etsy-gray mt-2">* Harap transfer tepat sesuai jumlah yang tertera di atas, lalu upload bukti di bawah.</p>
                </div>
                @endforeach
            </div>

            <!-- Form Checkout -->
            <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Hidden field bank yang dipilih, ikut terkirim ke controller -->
                <input type="hidden" id="selected_bank" name="bank" value="">

                <div class="mb-6">
                    <label class="block text-sm font-medium text-etsy-dark mb-2">Upload Bukti Transfer <span class="text-etsy-gray font-normal">(JPG, PNG, PDF)</span></label>
                    <input type="file" name="payment_proof" accept="image/*,application/pdf" required
                        class="w-full text-sm text-etsy-gray file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-etsy-orange hover:file:bg-orange-100">
                </div>

                <div class="mt-8">
                    <button type="submit" class="w-full bg-etsy-dark text-white py-3 rounded-full font-bold hover:bg-black transition">
                        Konfirmasi Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function showBankDetail(kode) {
        // Sembunyikan semua detail
        ['BRI', 'BCA', 'BNI', 'MANDIRI'].forEach(k => {
            document.getElementById('detail-' + k).classList.add('hidden');
        });

        // Tampilkan detail bank yang dipilih
        document.getElementById('detail-' + kode).classList.remove('hidden');

        // Set value hidden input supaya bank ikut terkirim ke controller
        document.getElementById('selected_bank').value = kode;
    }

    function copyNorek(kode, norek) {
        // Hapus tanda strip sebelum disalin
        const plain = norek.replace(/-/g, '');
        navigator.clipboard.writeText(plain).then(() => {
            const btn = event.target;
            btn.innerText = 'Tersalin!';
            btn.classList.add('bg-green-50', 'text-green-600', 'border-green-400');
            setTimeout(() => {
                btn.innerText = 'Salin';
                btn.classList.remove('bg-green-50', 'text-green-600', 'border-green-400');
            }, 2000);
        });
    }
</script>
@endpush