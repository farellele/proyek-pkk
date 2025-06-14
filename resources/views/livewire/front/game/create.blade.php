<div class="fixed z-10 inset-0 overflow-y-auto bg-black bg-opacity-50">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-gray-900 text-white rounded-2xl shadow-lg p-6 w-full max-w-md space-y-4">
            <h2 class="text-2xl font-semibold text-center text-white">Buat Transaksi</h2>

            <form wire:submit.prevent="store" class="space-y-4">

                {{-- Tanggal Pembelian --}}
                <div>
                    <label for="purchase_date" class="block mb-1 text-sm font-medium text-gray-300">Tanggal Pembelian</label>
                    <input type="date" id="purchase_date" wire:model="purchase_date"
                        class="w-full bg-gray-800 border border-gray-600 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-red-500 focus:outline-none">
                    @error('purchase_date') 
                        <span class="text-sm text-red-400">{{ $message }}</span> 
                    @enderror
                </div>

                {{-- Pilih Game --}}
                <div>
                    <label for="gameId" class="block mb-1 text-sm font-medium text-gray-300">Pilih Game</label>
                    <select id="gameId" wire:model="gameId"
                        class="w-full bg-gray-800 border border-gray-600 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-red-500 focus:outline-none">
                        <option value="">-- Pilih Game --</option>
                        @foreach ($games as $game)
                            <option value="{{ $game->id }}">
                                {{ $game->title }} - Rp {{ number_format($game->price, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                    @error('gameId') 
                        <span class="text-sm text-red-400">{{ $message }}</span> 
                    @enderror
                </div>

                {{-- Total Harga --}}
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-300">Total Harga</label>
                    <input type="text" disabled
                        class="w-full bg-gray-800 border border-gray-700 px-3 py-2 rounded-lg text-white cursor-not-allowed"
                        value="Rp {{ number_format($priceAtPurchase ?? 0, 0, ',', '.') }}">
                </div>

                {{-- Tombol --}}
                <div class="flex justify-end space-x-2 pt-2">
                    <button type="button" wire:click="closeModal"
                        class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm transition cursor-pointer">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
