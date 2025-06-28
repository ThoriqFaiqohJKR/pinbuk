<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserDetail extends Component
{
    public $user;
    public $confirmingDelete = false;

    public function mount($id)
    {
        $this->user = DB::table('pengguna')->where('id', $id)->first();
    }

    public function confirmDelete()
    {
        $this->confirmingDelete = true;
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = false;
    }

    public function deleteUser()
    {
        if ($this->user->foto) {
            Storage::delete('public/' . $this->user->foto);
        }

        DB::table('pengguna')->where('id', $this->user->id)->delete();

        session()->flash('message', 'User berhasil dihapus.');
        return redirect('/admin/users');
    }

    public function render()
    {
        return view('livewire.admin.user-detail');
    }
}
