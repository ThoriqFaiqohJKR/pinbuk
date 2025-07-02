<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class Searchnavbar extends Component
{
    public $query = '';
    public $results = [];

    public function updatedQuery()
    {
        $this->results = DB::table('buku')
            ->where('nama_buku', 'like', '%' . $this->query . '%')
            ->limit(5)
            ->get();
    }

    public function goToBuku($id)
    {
      return redirect()->route('user.buku.detail', ['id' => $id]);

    }

    public function search()
    {
        $trimmed = trim($this->query);
        if ($trimmed !== '') {
            // pilih salah satu baris di bawah
            return redirect('user/buku/search/' . urlencode($trimmed));          // cara A
            // return $this->redirect('/search/' . urlencode($trimmed)); // cara B
        }
    }

    public function render()
    {
        return view('livewire.user.searchnavbar');
    }
}
