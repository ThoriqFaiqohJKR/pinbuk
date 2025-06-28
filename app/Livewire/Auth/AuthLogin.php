<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthLogin extends Component
{
    public $email;
    public $password;
    public $error;

    // Validasi input
    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    // Proses login 
    public function login()
    {
        $this->validate();
    
        $user = DB::table('pengguna')->where('email', $this->email)->first();
    
        if (!$user || !Hash::check($this->password, $user->password)) {
            $this->error = "Invalid credentials!";
            return;
        }
    
        // Simpan data ke session manual
        session([
            'user_id' => $user->id,
            'user_email' => $user->email,
            'user_name' => $user->nama,
            'user_level' => $user->level,
        ]);
    
        // Redirect sesuai level user
        if ($user->level === 'admin') {
            return redirect('/admin/dashboard');
        } elseif ($user->level === 'user') {
            return redirect('/user/dashboard');
        }
    
        $this->error = "Invalid user level!";
    }
    

    // Render tampilan login
    public function render()
    {
        return view('livewire.auth.auth-login');
    }
}

