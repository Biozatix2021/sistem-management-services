<?php

namespace App\Http\Controllers;

use App\Models\Instalasi_Alat;
use App\Models\Perusahaan;
use App\Models\rumah_sakit;
use Illuminate\Http\Request;

class InstalasiAlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Instalasi_Alat::with('alat', 'perusahaan', 'rumah_sakit', 'teknisi', 'user')->get();

        // return $data;
        return view('v_instalasi_alat');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rumah_sakit = rumah_sakit::all();
        $perusahaan = Perusahaan::all();
        return view('create_instalasi_alat', [
            'rumah_sakits' => $rumah_sakit,
            'perusahaans' => $perusahaan
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
