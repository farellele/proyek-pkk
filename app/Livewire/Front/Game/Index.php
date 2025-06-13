<?php

namespace App\Livewire\Front\Game;

use App\Models\Game;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Library;
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

    protected $paginationTheme = 'tailwind';

    public function render()
    {
        $games = Game::with(['developer', 'genre', 'platform'])
            ->where('status', 'approved')
            ->where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhereHas('developer', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('genre', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('platform', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderByDesc('release_date')
            ->paginate(10);

        return view('livewire.front.game.index', [
            'games' => $games,
        ]);
    }

    public function addToCart($gameId)
    {
        $userId = Auth::id();

        if (!$userId) {
            session()->flash('error', 'Anda harus login terlebih dahulu.');
            return;
        }

        // Cek apakah user sudah punya cart
        $cart = Cart::firstOrCreate(
            ['user_id' => $userId],
            ['created_at' => now(), 'updated_at' => now()]
        );

        // Cek apakah game sudah ada di cart user
        $existing = CartItem::where('cart_id', $cart->id)
            ->where('game_id', $gameId)
            ->first();

        if ($existing) {
            session()->flash('error', 'Game ini sudah ada di keranjang.');
            return;
        }

        // Tambahkan game ke dalam cart_items
        CartItem::create([
            'cart_id' => $cart->id,
            'game_id' => $gameId,
            'created_at' => now(),
        ]);

        session()->flash('success', 'Game berhasil ditambahkan ke keranjang.');
    }


    public function create($gameId)
    {
        $this->resetForm();
        $this->gameId = $gameId;

        $game = Game::find($gameId);
        $this->priceAtPurchase = $game ? $game->price : 0;

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

            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'game_id' => $game->id,
                'price_at_purchase' => $price,
            ]);

            Library::create([
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
