<?php

namespace App\Livewire\Front\Cart;

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
    public $gameId;
    public $priceAtPurchase = 0;
    public $purchase_date;
    public $isOpen = false;
    protected $paginationTheme = 'tailwind';


    public function render()
    {
        $user = Auth::user();

        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart) {
            $cartItems = collect();
        } else {

            $cartItems = CartItem::with('game')
                ->where('cart_id', $cart->id)
                ->whereHas('game', function ($query) {
                    $query->where('title', 'like', '%' . $this->search . '%');
                })
                ->paginate(10);
        }

        return view('livewire.front.cart.index', [
            'cartItems' => $cartItems,
        ]);
    }

    public function removeFromCart($id)
    {
        $item = CartItem::findOrFail($id);

        // Pastikan hanya user yang punya cart yang bisa menghapus
        if ($item->cart->user_id !== auth()->id()) {
            session()->flash('error', 'Anda tidak diizinkan menghapus item ini.');
            return;
        }

        $item->delete();

        session()->flash('success', 'Item berhasil dihapus dari keranjang.');
    }

    public function checkout($id)
    {
        $this->resetForm();

        // Ambil CartItem dan pastikan milik user
        $cartItem = CartItem::with('game', 'cart')
            ->where('id', $id)
            ->whereHas('cart', fn($q) => $q->where('user_id', Auth::id()))
            ->firstOrFail();

        $this->gameId = $cartItem->game->id;
        $this->priceAtPurchase = $cartItem->game->price;

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
        $alreadyOwned = Library::where('user_id', Auth::id())
            ->where('game_id', $this->gameId)
            ->exists();

        if ($alreadyOwned) {
            session()->flash('error', 'Game ini sudah ada di Library Anda.');
            $this->isOpen = false;
            return;
        }

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

            // Hapus CartItem setelah checkout
            CartItem::where('game_id', $game->id)
                ->whereHas('cart', fn($q) => $q->where('user_id', Auth::id()))
                ->delete();

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
