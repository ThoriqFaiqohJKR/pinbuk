<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
 
class PeminjamanController extends Controller
{
    
    //
    public function index()
    {
    return view('admin.peminjaman-index');
    }

    public function show($id)
    {
        return view('admin.peminjaman-detail', ['id' => $id]);
    }
    
    public function edit($id)
    {
        return view('admin.peminjaman-edit', ['id' => $id]);
    }

    
}
