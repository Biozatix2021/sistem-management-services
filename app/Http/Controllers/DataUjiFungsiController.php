<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Data_Uji_Fungsi;
use App\Models\M_Uji_Fungsi;
use App\Models\teknisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DataUjiFungsiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filter = request('filter');
        $alat = Alat::select('id', 'nama', 'tipe')->get();
        $template = M_Uji_Fungsi::select('id', 'item', 'qty', 'satuan')->get();

        if (request()->ajax()) {
            $data = Data_Uji_Fungsi::all();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<center>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-xs btn-danger" onclick="delete_data(' . $data->id . ')">Delete</button>
                                </div></center>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('v_uji_fungsi', [
            'alats' => $alat,
            'templates' => $template,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $alat = Alat::select('id', 'nama', 'tipe')->get();
        $teknisi = teknisi::select('id', 'nama')->get();
        $template = M_Uji_Fungsi::select('id', 'item', 'qty', 'satuan')->get();
        return view('create_uji_fungsi', [
            'alats' => $alat,
            'templates' => $template,
            'teknisis' => $teknisi,
        ]);
    }

    public function form_qc(Request $request)
    {
        $alat_Id = request('alat_id');
        $teknisi = teknisi::select('id', 'nama')->get();
        $alat = Alat::select('id', 'nama', 'tipe')
            ->where('id', $alat_Id)->get();

        $template = Cache::remember('dbtemplate-' . $alat_Id, 3600, function () use ($alat_Id) {
            return M_Uji_Fungsi::where('alat_id', $alat_Id)->get();
        });

        return response()->json([
            'alats' => $alat,
            'templates' => $template,
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
