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
            Cart
        </div>

        <div class="flex items-center justify-end bg-white p-6 rounded-lg shadow-md">
            <input wire:model.live="search" type="text" placeholder="Search ..."
                class="border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-600">
        </div>

        @if ($isOpen)
            @include('livewire.front.cart.create')
        @endif


        <table class="min-w-full bg-white border mt-4 text-black">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">No</th>
                    <th class="px-4 py-2 border">Nama Game</th>
                    <th class="px-4 py-2 border">Genre</th>
                    <th class="px-4 py-2 border">Harga</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cartItems as $item)
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-2 border text-center">
                            {{ ($loop->iteration + ($cartItems->currentPage() - 1) * $cartItems->perPage()) }}
                        </td>
                        <td class="px-4 py-2 border-b border-gray-200 text-gray-600 text-center">
                            {{ $item->game->title }}
                        </td>
                        <td class="px-4 py-2 border-b border-gray-200 text-gray-600 text-center">
                            {{ $item->game->genre->name ?? '-' }}
                        </td>
                        <td class="px-4 py-2 border-b border-gray-200 text-gray-600 text-center">
                            Rp {{ number_format($item->game->price, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-2 border-b border-gray-200 text-center">
                            <button wire:click="removeFromCart({{ $item->id }})"
                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 cursor-pointer  ">
                                Remove
                            </button>
                            <button wire:click="checkout({{ $item->id }})"
                                class="bg-blue-500 text-white px-3 py-1 rounded cursor-pointer">Checkout</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500">Keranjang Anda kosong.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">
            {{ $cartItems->links() }}
        </div>

        <!-- <div class="p-4 flex justify-between items-center">
            <div class="text-gray-600 font-semibold">
                Total: Rp {{ number_format($cartItems->sum(fn($item) => $item->game->price), 0, ',', '.') }}
            </div>
            <button wire:click="checkoutCart"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold">
                Checkout Semua
            </button> -->
    </div>
</div>
</div>