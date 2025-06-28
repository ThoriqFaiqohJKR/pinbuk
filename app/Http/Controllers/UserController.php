<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    
    public function index()
    {
        return view('admin.user-index'); 
    }

     public function create()
     {
         // Render Livewire component untuk form tambah user
         return view('admin.user-tambah');
     }
     
     
    public function edit($id)
    {
        $user = DB::table('pengguna')->where('id', $id)->first();

        return view('admin.user-edit', ['id' => $id]); // Pastikan tampilan ada di folder yang tepat
    }

    /**
     * Update user berdasarkan ID.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,$id",
            'role' => 'required|string|in:admin,user', // Validasi role
        ]);

        DB::table('users')->where('id', $id)->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
            'updated_at' => now(),
        ]);

        return redirect()->route('user.index')->with('message', 'User berhasil diperbarui.');
    }

    /**
     * Hapus user berdasarkan ID.
     */
    public function destroy($id)
    {
        DB::table('users')->where('id', $id)->delete();
        return redirect()->route('user.index')->with('message', 'User berhasil dihapus.');
    }

    public function show($id)
    {
        $user = DB::table('pengguna')->where('id', $id)->first();
        return view('admin.user-detail', compact('user'));
    }
}
