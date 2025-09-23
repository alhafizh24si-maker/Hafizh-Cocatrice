<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Data contoh
        $tanggal_lahir = new \DateTime('2006-05-15'); // Ganti dengan tanggal lahir pegawai
        $hari_ini = new \DateTime();

        // Hitung umur
        $umur = $hari_ini->diff($tanggal_lahir)->y;

        $tgl_harus_wisuda = new \DateTime('2025-07-01'); // Contoh tanggal harus wisuda
        $jarak_hari = $hari_ini->diff($tgl_harus_wisuda)->days;

        // Jika tanggal sudah lewat, beri nilai negatif
        if ($hari_ini > $tgl_harus_wisuda) {
            $jarak_hari = -$jarak_hari;
        }

        $current_semester = 4; // Ganti dengan semester saat ini

        // Pesan motivasi berdasarkan semester
        if ($current_semester < 3) {
            $motivasi = "Masih Awal, Kejar TAK";
        } else {
            $motivasi = "Jangan main-main, kurang-kurangi main game!";
        }

        $data = [
            'name' => 'Hafizh',
            'my_age' => $umur,
            'hobbies' => ['Membaca', 'Olahraga', 'Programming', 'Traveling', 'Fotografi', 'Musik'],
            'tgl_harus_wisuda' => $tgl_harus_wisuda->format('Y-m-d'),
            'time_to_study_left' => $jarak_hari,
            'current_semester' => $current_semester,
            'semester_message' => $motivasi,
            'future_goal' => 'Menjadi Software Architect'
        ];

        return view('pegawai', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }
}
