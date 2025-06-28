<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserInfo extends Component
{

    public $user;

    public function mount()
    {
        // Misal pakai Auth, ambil user dari tabel 'pengguna'
        $this->user = DB::table('pengguna')->where('id', Auth::id())->first();

        // Atau untuk testing dulu:
        // $this->user = DB::table('pengguna')->first();
    }

    public function render()
    {
        return view('livewire.user.user-info');
    }
}
