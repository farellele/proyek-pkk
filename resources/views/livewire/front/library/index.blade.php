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
            Library
        </div>

        <div class="flex items-center justify-end bg-white p-6 rounded-lg shadow-md">
            <input wire:model.live="search" type="text" placeholder="Search ..."
                class="border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-600">
        </div>

        <table class="min-w-full bg-white border mt-4 text-black">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">No</th>
                    <th class="px-4 py-2 border">Nama Game</th>
                    <th class="px-4 py-2 border">Ditambahkan Pada</th>
                    <th class="px-4 py-2 border">ID Transaksi</th>
                    <th class="px-4 py-2 border">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($libraries as $index => $library)
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-2 border-b border-gray-200 text-gray-600 text-center">
                            {{ $index + 1 + ($libraries->currentPage() - 1) * $libraries->perPage() }}
                        </td>
                        <td class="px-4 py-2 border-b border-gray-200 text-gray-600 text-center">
                            {{ $library->game->title }}
                        </td>
                        <td class="px-4 py-2 border-b border-gray-200 text-gray-600 text-center">
                            {{ $library->added_at}}
                        </td>
                        <td class="px-4 py-2 border-b border-gray-200 text-gray-600 text-center">
                            {{ $library->transaction_id ?? '-' }}
                        </td>
                        <td class="px-4 py-2 border-b border-gray-200 text-gray-600 text-center">
                            {{ ucfirst($library->status) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500">Belum ada game di library.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $libraries->links() }}
        </div>
    </div>
</div>