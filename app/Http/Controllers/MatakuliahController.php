<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MatakuliahController extends Controller
{
    /**
     * Menampilkan daftar matakuliah
     */
    public function index()
    {
        return "Menampilkan data matakuliah";
    }

    /**
     * Menampilkan form untuk membuat matakuliah baru
     */
    public function create()
    {
        return "Menampilkan form untuk membuat matakuliah baru";
    }

    /**
     * Menyimpan matakuliah baru
     */
    public function store(Request $request)
    {
        return "Menyimpan matakuliah baru";
    }

    /**
     * Menampilkan detail matakuliah berdasarkan kode
     */
    public function show($kode = null)
    {
        if ($kode) {
            return "Anda mengakses matakuliah $kode";
        }

        return "Masukkan kode matakuliah!";
    }

    /**
     * Menampilkan form untuk mengedit matakuliah
     */
    public function edit($id)
    {
        return "Menampilkan form untuk mengedit matakuliah $id";
    }

    /**
     * Mengupdate matakuliah
     */
    public function update(Request $request, $id)
    {
        return "Mengupdate matakuliah $id";
    }

    /**
     * Menghapus matakuliah
     */
    public function destroy($id)
    {
        return "Menghapus matakuliah $id";
    }
}
