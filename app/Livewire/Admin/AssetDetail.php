<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class AssetDetail extends Component
{
    public $asset;
    public $showDeleteModal = false;

    public function mount($id)
    {
        $this->asset = DB::table('asset')->where('id', $id)->first();
    }
    
    public function render()
    {
        return view('livewire.admin.asset-detail', ['asset' => $this->asset]);
    }

    public function confirmDelete()
    {
        $this->showDeleteModal = true;
    }

    public function deleteAsset()
    {
        DB::table('asset')->where('id', $this->asset->id)->delete();

        session()->flash('message', 'Asset berhasil dihapus.');

        return redirect ('/admin/asset');
    }
}
