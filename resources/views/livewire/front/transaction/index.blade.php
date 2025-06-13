<div class="py-24 text-black">
    <div class="mx-auto bg-white rounded-lg shadow-md overflow-hidden px-4 py-4">

        {{-- Flash Message --}}
        @if (session()->has('error'))
            <div class="p-4 bg-red-500 text-white rounded-md">{{ session('error') }}</div>
        @endif
        @if (session()->has('success'))
            <div class="p-4 bg-green-500 text-white rounded-md">{{ session('success') }}</div>
        @endif

        <div class="w-full bg-gray-200 p-4 text-center text-xl font-bold text-gray-600">
            Riwayat Transaksi Game
        </div>

        <div class="flex items-center justify-between bg-white p-6 rounded-lg shadow-md">
            <button wire:click="create" class="bg-blue-500 text-white px-4 py-2 rounded-lg cursor-pointer">
                Create Transaksi
            </button>

            <input wire:model.live="search" type="text" placeholder="Search ..."
        class="border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-600">
        </div>

        @if ($isOpen)
            @include('livewire.front.transaction.create')
        @endif

        <table class="min-w-full bg-white border mt-4 text-black">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">No</th>
                    <th class="px-4 py-2 border">Nama</th>
                    <th class="px-4 py-2 border">Tanggal Pembelian</th>
                    <th class="px-4 py-2 border">Game</th>
                    <th class="px-4 py-2 border">Harga Saat Pembelian</th>
                    <th class="px-4 py-2 border">Total Harga</th>
                    <!-- <th class="px-4 py-2 border">Transaction ID</th> -->
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
    @foreach ($transaction->items as $item)
        <tr class="hover:bg-gray-100">
           <td class="px-4 py-2 border-b border-gray-200 text-gray-600 text-center">
                {{ ($loop->parent->iteration + ($transactions->currentPage() - 1) * $transactions->perPage()) }} 
            </td>
            <td class="px-4 py-2 border-b border-gray-200 text-gray-600 text-center">{{ $transaction->user->name }}</td>
            <td class="px-4 py-2 border-b border-gray-200 text-gray-600 text-center">{{ $transaction->purchase_date?->format('d M Y') }}</td>
            <td class="px-4 py-2 border-b border-gray-200 text-gray-600 text-center">{{ $item->game->title }}</td>
            <td class="px-4 py-2 border-b border-gray-200 text-gray-600 text-center">Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }}</td>
            <td class="px-4 py-2 border-b border-gray-200 text-gray-600 text-center">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
            <!-- <td class="px-4 py-2 border-b border-gray-200 text-gray-600">{{ $item->transaction_id }}</td> -->
        </tr>
    @endforeach
@endforeach

            </tbody>
        </table>

        <div class="p-4">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
