<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class AssetController extends Controller
{
    //
    public function index()
    {
        $asets = DB::table('aset')->get();
        return view("admin.asset-index", compact('asets'));
    }

    public function create()
    {
        return view("admin.asset-tambah");
    }


    public function edit($id)
    {
        return view("admin.asset-edit  ", ['id' => $id]);
    }
    public function pinjam($id)
    {
        $asset = DB::table('asset')->where('id', $id)->first();
        return view('admin.asset-pinjam', compact('asset'));
    }
    public function show($id)
    {
        // Mengambil data asset berdasarkan ID
        $asset = DB::table('asset')->where('id', $id)->first();

        // Mengirimkan data ke tampilan dengan variabel $asset
        return view('admin.asset-detail', compact('asset'));
    }
    public function printQr($id)
    {
        $asset = DB::table('asset')->where('id', $id)->first();

        if (!$asset) {
            return redirect()->route('admin.asset.index')->with('error', 'asset tidak ditemukan.');
        }
    }

    public function update(Request $request)
    {
        return view("");
    }

    public function destroy(Request $request)
    {
        return view("");
    }
}
