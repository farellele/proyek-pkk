<?php

namespace App\Livewire\Front\Transaction;

use App\Models\Game;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $isOpen = false;

    public $purchase_date;
    public $gameId;
    public $priceAtPurchase = 0;

    public $games;

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        $this->games = Game::all();
    }

    public function updatedGameId($value)
    {
        $game = Game::find($value);
        $this->priceAtPurchase = $game ? $game->price : 0;
    }

    public function render()
    {
        $transactions = Transaction::with(['items.game', 'user'])
            ->where('user_id', Auth::id())
            ->whereHas('items.game', function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->orderBy('purchase_date', 'desc')
            ->paginate(5);

        return view('livewire.front.transaction.index', [
            'transactions' => $transactions,
        ]);
    }

    public function create()
    {
        $this->resetForm();
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function resetForm()
    {
        $this->gameId = null;
        $this->priceAtPurchase = 0;
        $this->purchase_date = null;
    }

    public function store()
    {
        $this->validate([
            'purchase_date' => 'required|date',
            'gameId' => 'required|exists:games,id',
        ]);

        DB::beginTransaction();

        try {
            $game = Game::findOrFail($this->gameId);
            $price = $game->price;

            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'purchase_date' => $this->purchase_date,
                'total_price' => $price,
            ]);

            $transactionItem = TransactionItem::create([
                'transaction_id' => $transaction->id,
                'game_id' => $game->id,
                'price_at_purchase' => $price,
            ]);

            \App\Models\Library::create([
                'user_id' => Auth::id(),
                'game_id' => $game->id,
                'transaction_id' => $transaction->id,
                'status' => 'active',
                'added_at' => now(),
            ]);

            DB::commit();

            $this->resetForm();
            $this->isOpen = false;
            session()->flash('success', 'Transaksi berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan saat membuat transaksi.');
        }
    }
}
