<div class="fixed z-10 inset-0 overflow-y-auto bg-black bg-opacity-50">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white text-gray-800 rounded-2xl shadow-lg p-6 w-full max-w-md space-y-4">
            <h2 class="text-2xl font-semibold text-center">Buat Transaksi</h2>

            <form wire:submit.prevent="store" class="space-y-4">
                {{-- Tanggal Pembelian --}}
                <div>
                    <label for="purchase_date" class="block mb-1 text-sm font-medium text-gray-700">Tanggal Pembelian</label>
                    <input type="date" wire:model="purchase_date"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-800 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('purchase_date') 
                        <span class="text-sm text-red-500">{{ $message }}</span> 
                    @enderror
                </div>

                {{-- Nama Game --}}
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Game</label>
                    <input type="text" disabled
                        class="w-full border bg-gray-100 px-3 py-2 rounded-lg text-gray-800 cursor-not-allowed"
                        value="{{ \App\Models\Game::find($gameId)?->title ?? '-' }}">
                </div>

                {{-- Total Harga --}}
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Total Harga</label>
                    <input type="text" disabled
                        class="w-full border bg-gray-100 px-3 py-2 rounded-lg text-gray-800 cursor-not-allowed"
                        value="Rp {{ number_format($priceAtPurchase ?? 0, 0, ',', '.') }}">
                </div>

                {{-- Tombol --}}
                <div class="flex justify-end space-x-2 pt-2">
                    <button type="button" wire:click="closeModal"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg text-sm transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition cursor-pointer">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
