<div class="py-16 px-4 min-h-screen text-white">
    <div class="mx-auto bg-gray-900 rounded-lg shadow-md overflow-hidden px-6 py-6 max-w-7xl">

        {{-- Flash Message --}}
        @if (session()->has('error'))
            <div class="p-4 bg-red-600 text-white rounded-md">{{ session('error') }}</div>
        @endif
        @if (session()->has('success'))
            <div class="p-4 bg-green-500 text-white rounded-md">{{ session('success') }}</div>
        @endif

        {{-- Header --}}
        <div class="w-full bg-red-600 p-4 text-center text-xl font-bold text-white rounded-md">
            Riwayat Transaksi Game
        </div>

        {{-- Search + Create --}}
        <div class="flex flex-col md:flex-row items-center justify-between bg-gray-800 p-4 mt-6 rounded-md gap-4">
            <button wire:click="create"
                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm">Create Transaksi</button>

            <input wire:model.live="search" type="text" placeholder="Search ..."
                class="w-full md:w-1/3 bg-gray-700 border border-gray-600 rounded-md p-2 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400">
        </div>

        @if ($isOpen)
            @include('livewire.front.transaction.create')
        @endif

        {{-- Tabel Transaksi --}}
        <div class="overflow-x-auto mt-6 rounded-lg">
            <table class="min-w-full border border-gray-700 text-sm">
                <thead class="bg-gray-800 text-gray-200 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 border border-gray-700">No</th>
                        <th class="px-4 py-3 border border-gray-700">Nama</th>
                        <th class="px-4 py-3 border border-gray-700">Tanggal Pembelian</th>
                        <th class="px-4 py-3 border border-gray-700">Game</th>
                        <th class="px-4 py-3 border border-gray-700">Harga Saat Pembelian</th>
                        <th class="px-4 py-3 border border-gray-700">Total Harga</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-900 text-white">
                    @foreach ($transactions as $transaction)
                        @foreach ($transaction->items as $item)
                            <tr class="hover:bg-gray-800">
                                <td class="px-4 py-2 border border-gray-800 text-center">
                                    {{ ($loop->parent->iteration + ($transactions->currentPage() - 1) * $transactions->perPage()) }}
                                </td>
                                <td class="px-4 py-2 border border-gray-800 text-center">
                                    {{ $transaction->user->name }}
                                </td>
                                <td class="px-4 py-2 border border-gray-800 text-center">
                                    {{ $transaction->purchase_date?->format('d M Y') }}
                                </td>
                                <td class="px-4 py-2 border border-gray-800 text-center">
                                    {{ $item->game->title }}
                                </td>
                                <td class="px-4 py-2 border border-gray-800 text-center">
                                    Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-2 border border-gray-800 text-center">
                                    Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    @endforeach

                    @if ($transactions->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center px-4 py-6 text-gray-400">
                                Belum ada transaksi.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="p-4">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
