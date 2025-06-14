<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class Register extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        // Tambahkan role default (misal: buyer atau pending)
        $validated['role'] = 'buyer';

        // Enkripsi password
        $validated['password'] = Hash::make($validated['password']);

        // Buat user baru
        $user = User::create($validated);

        // Trigger event listener jika ada
        event(new Registered($user));

        // Flash message ke halaman login
        session()->flash('status', 'Akun berhasil dibuat. Silakan login.');

        // Redirect ke login
        $this->redirect(route('login', absolute: false), navigate: true);
    }
}
