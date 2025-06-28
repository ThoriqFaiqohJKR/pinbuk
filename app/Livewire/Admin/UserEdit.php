<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserEdit extends Component
{
    use WithFileUploads;

    public $userId, $nama, $email, $level, $password, $confirm_password;
    public $no_tlpn, $jabatan, $status;
    public $foto, $foto_old;

    public function mount($userId)
    {
        $user = DB::table('pengguna')->where('id', $userId)->first();

        if ($user) {
            $this->userId = $user->id;
            $this->nama = $user->nama;
            $this->email = $user->email;
            $this->level = $user->level;
            $this->no_tlpn = $user->no_tlpn ?? '';
            $this->jabatan = $user->jabatan ?? '';
            $this->status = $user->status ?? '';
            $this->foto_old = $user->foto ?? null; // Harus berupa path, misal: 'fotos/nama-foto.jpg'
        }
    }

    public function update()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'level' => 'required|in:admin,user',
            'password' => 'nullable|string|min:6',
            'confirm_password' => 'nullable|string|same:password',
            'no_tlpn' => 'nullable|string',
            'jabatan' => 'nullable|string',
            'status' => 'nullable|string',
            'foto' => 'nullable|image|max:1024',
        ]);

        $data = [
            'nama' => $this->nama,
            'email' => $this->email,
            'level' => $this->level,
            'no_tlpn' => $this->no_tlpn,
            'jabatan' => $this->jabatan,
            'status' => $this->status,
            'updated_at' => now(),
        ];
        
        if (!empty($this->password)) {
            $data['password'] = Hash::make($this->password);
            $data['password_plaintext'] = $this->password; // Simpan hanya jika user mengubah password
        }
        

        if ($this->foto) {
            $filename = $this->foto->store('foto', 'public');

            if ($this->foto_old && Storage::disk('public')->exists($this->foto_old)) {
                Storage::disk('public')->delete($this->foto_old);
            }

            $data['foto'] = $filename;
        } else {
            $data['foto'] = $this->foto_old;
        }

        DB::table('pengguna')->where('id', $this->userId)->update($data);

        session()->flash('message', 'User berhasil diperbarui.');
        return redirect('/admin/users');
    }

    public function render()
    {
        return view('livewire.admin.user-edit');
    }
}
