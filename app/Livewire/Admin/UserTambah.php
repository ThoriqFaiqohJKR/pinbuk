<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserTambah extends Component
{
    use WithFileUploads;
 
    public $nip, $nama, $email, $no_tlpn, $photo, $jabatan;
    public $password, $confirm_password;

    protected $rules = [
        'nip' => 'required|string|max:20|unique:pengguna,nip',
        'nama' => 'required|string|max:255',
        'email' => 'required|email|unique:pengguna,email',
        'no_tlpn' => 'required|string|max:15',
        'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:1024',
        'jabatan' => 'required|string|max:255',
        'password' => 'required|string|min:6',
        'confirm_password' => 'required|same:password',
    ];

    public function store()
    {
        $this->validate();

        $photoPath = null;
        if ($this->photo) {
            $photoPath = $this->photo->store('photos/users', 'public');
        }

        try {
            DB::transaction(function () use ($photoPath) {
                DB::table('pengguna')->insert([
                    'nip' => $this->nip,
                    'nama' => $this->nama,
                    'email' => $this->email,
                    'no_tlpn' => $this->no_tlpn,
                    'foto' => $photoPath,
                    'level' => 'user',
                    'jabatan' => $this->jabatan,
                    'password' => Hash::make($this->password),
                    'password_plaintext' => $this->password,
                    'status' => 'green',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });

            session()->flash('message', 'User berhasil ditambahkan.');
            $this->reset();
            return redirect()->to('/admin/users');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat menambahkan user: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.user-tambah');
    }
}
