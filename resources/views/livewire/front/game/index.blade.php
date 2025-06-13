<div class="py-24 text-black">
    <div class="mx-auto bg-white rounded-lg shadow-md overflow-hidden px-4 py-4 max-w-7xl">

        {{-- Flash Message --}}
        @if (session()->has('error'))
            <div class="p-4 bg-red-500 text-white rounded-md">{{ session('error') }}</div>
        @endif
        @if (session()->has('success'))
            <div class="p-4 bg-green-500 text-white rounded-md">{{ session('success') }}</div>
        @endif

        <div class="w-full bg-gray-200 p-4 text-center text-xl font-bold text-gray-600">
            Daftar Game Tersedia
        </div>

        {{-- Search Bar --}}
        <div class="flex items-center justify-between bg-white p-6 rounded-lg shadow-md">
            <input wire:model.live="search" type="text" placeholder="Cari game..."
                class="border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-600">
        </div>

        @if ($isOpen)
            @include('livewire.front.game.create')
        @endif

        {{-- Game Table --}}
        <table class="min-w-full bg-white border mt-4 text-black">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">No</th>
                    <th class="px-4 py-2 border">Judul</th>
                    <th class="px-4 py-2 border">Developer</th>
                    <th class="px-4 py-2 border">Genre</th>
                    <th class="px-4 py-2 border">Platform</th>
                    <th class="px-4 py-2 border">Harga</th>
                    <th class="px-4 py-2 border">Tanggal Rilis</th>
                    <th class="px-4 py-2 border">Aksi</th>
                    <!-- <th class="px-4 py-2 border">Status</th> -->
                </tr>
            </thead>
            <tbody>
                @forelse ($games as $game)
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-2 border text-center">
                            {{ ($loop->iteration + ($games->currentPage() - 1) * $games->perPage()) }}
                        </td>
                        <td class="px-4 py-2 border">{{ $game->title }}</td>
                        <td class="px-4 py-2 border">{{ $game->developer->name ?? '-' }}</td>
                        <td class="px-4 py-2 border">{{ $game->genre->name ?? '-' }}</td>
                        <td class="px-4 py-2 border">{{ $game->platform->name ?? '-' }}</td>
                        <td class="px-4 py-2 border">Rp {{ number_format($game->price, 0, ',', '.') }}</td>
                        <td class="px-4 py-2 border">{{ $game->release_date?->format('d M Y') }}</td>
                        <td class="px-4 py-2 border text-center space-x-2">
                            <button wire:click="addToCart({{ $game->id }})"
                                class="bg-green-500 text-white px-3 py-1 rounded cursor-pointer">Add to Cart</button>
                            <button wire:click="create({{ $game->id }})"
                                class="bg-blue-500 text-white px-3 py-1 rounded cursor-pointer">Checkout</button>

                        </td>
                        <!-- <td class="px-4 py-2 border capitalize">
                                    <span class="px-2 py-1 rounded-md text-white 
                                        {{ $game->status === 'approved' ? 'bg-red-500' : 'bg-gray-400' }}">
                                        {{ $game->status }}
                                    </span>
                                </td> -->
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center p-4 text-gray-500">Tidak ada game ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $games->links() }}
        </div>
    </div>
</div>