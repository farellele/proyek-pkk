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
            Library
        </div>

        {{-- Search --}}
        <div class="flex items-center justify-end bg-gray-800 p-4 mt-6 rounded-md">
            <input wire:model.live="search" type="text" placeholder="Search ..."
                class="w-full max-w-sm bg-gray-700 border border-gray-600 rounded-md p-2 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400">
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto mt-6 rounded-lg">
            <table class="min-w-full border border-gray-700 text-sm">
                <thead class="bg-gray-800 text-gray-200 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 border border-gray-700">No</th>
                        <th class="px-4 py-3 border border-gray-700">Nama Game</th>
                        <th class="px-4 py-3 border border-gray-700">Ditambahkan Pada</th>
                        <th class="px-4 py-3 border border-gray-700">ID Transaksi</th>
                        <th class="px-4 py-3 border border-gray-700">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-900 text-white">
                    @forelse ($libraries as $index => $library)
                        <tr class="hover:bg-gray-800">
                            <td class="px-4 py-2 border border-gray-800 text-center">
                                {{ $index + 1 + ($libraries->currentPage() - 1) * $libraries->perPage() }}
                            </td>
                            <td class="px-4 py-2 border border-gray-800 text-center">
                                {{ $library->game->title }}
                            </td>
                            <td class="px-4 py-2 border border-gray-800 text-center">
                                {{ $library->added_at }}
                            </td>
                            <td class="px-4 py-2 border border-gray-800 text-center">
                                {{ $library->transaction_id ?? '-' }}
                            </td>
                            <td class="px-4 py-2 border border-gray-800 text-center capitalize">
                                <span class="px-2 py-1 rounded-md bg-red-500 text-white text-xs">
                                    {{ $library->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center px-4 py-6 text-gray-400">Belum ada game di library.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="p-4">
            {{ $libraries->links() }}
        </div>
    </div>
</div>
