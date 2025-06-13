<?php

namespace App\Livewire\Front\Library;

use App\Models\Library;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    protected $paginationTheme = 'tailwind';

    public function render()
    {
        $libraries = Library::with(['game', 'transaction'])
            ->where('user_id', Auth::id())
            ->whereHas('game', function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->orderByDesc('added_at')
            ->paginate(10);

        return view('livewire.front.library.index', [
            'libraries' => $libraries,
        ]);
    }
}
