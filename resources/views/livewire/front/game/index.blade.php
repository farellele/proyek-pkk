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
            Daftar Game Tersedia
        </div>

        {{-- Search Bar --}}
        <div class="flex items-center justify-between bg-gray-800 p-4 mt-6 rounded-md">
            <input wire:model.live="search" type="text" placeholder="Cari game..."
                class="w-full bg-gray-700 border border-gray-600 rounded-md p-2 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400">
        </div>

        @if ($isOpen)
            @include('livewire.front.game.create')
        @endif

        {{-- Game Table --}}
        <div class="overflow-x-auto mt-6 rounded-lg">
            <table class="min-w-full border border-gray-700 text-sm">
                <thead class="bg-gray-800 text-gray-200 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 border border-gray-700">No</th>
                        <th class="px-4 py-3 border border-gray-700">Judul</th>
                        <th class="px-4 py-3 border border-gray-700">Developer</th>
                        <th class="px-4 py-3 border border-gray-700">Genre</th>
                        <th class="px-4 py-3 border border-gray-700">Platform</th>
                        <th class="px-4 py-3 border border-gray-700">Harga</th>
                        <th class="px-4 py-3 border border-gray-700">Tanggal Rilis</th>
                        <th class="px-4 py-3 border border-gray-700 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-900 text-white">
                    @forelse ($games as $game)
                        <tr class="hover:bg-gray-800">
                            <td class="px-4 py-2 border border-gray-800 text-center">
                                {{ ($loop->iteration + ($games->currentPage() - 1) * $games->perPage()) }}
                            </td>
                            <td class="px-4 py-2 border border-gray-800">{{ $game->title }}</td>
                            <td class="px-4 py-2 border border-gray-800">{{ $game->developer->name ?? '-' }}</td>
                            <td class="px-4 py-2 border border-gray-800">{{ $game->genre->name ?? '-' }}</td>
                            <td class="px-4 py-2 border border-gray-800">{{ $game->platform->name ?? '-' }}</td>
                            <td class="px-4 py-2 border border-gray-800">Rp {{ number_format($game->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 border border-gray-800">{{ $game->release_date?->format('d M Y') }}</td>
                            <td class="px-4 py-2 border border-gray-800 text-center space-x-2">
                                <button wire:click="addToCart({{ $game->id }})"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-xs">Add to Cart</button>
                                <button wire:click="create({{ $game->id }})"
                                    class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded-md text-xs">Checkout</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center px-4 py-6 text-gray-400">Tidak ada game ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4">
            {{ $games->links() }}
        </div>
    </div>
</div>
