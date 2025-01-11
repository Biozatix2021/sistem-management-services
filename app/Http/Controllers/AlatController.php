<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\sop_alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return Alat::all();
        if (request()->ajax()) {
            $data = Alat::all();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<center>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-xs btn-primary btn-block" onclick="show_data(' . $data->id . ')">Lihat SOP</button>
                                    <button type="button" class="btn btn-xs btn-danger btn-block" onclick="delete_data(' . $data->id . ')">Delete</button>
                                </div></center>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('m_data_alat');
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
        $rules = [
            'nama'              => 'required',
            'type'              => 'required',
        ];

        $text = [
            'nama.required' => 'Nama Alat Harus Diisi !',
            'type.required' => 'Type Alat Harus Diisi !',

        ];

        $validator = Validator::make($request->all(), $rules, $text);

        if ($validator->fails()) {
            # code...
            return response()->json(['success' => 0, 'text' => $validator->errors()->first()], 422);
        }

        Alat::create([
            'nama'          => $request->nama,
            'type'          => $request->type,

        ]);

        return response()->json(['status'   => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // find data alat with sop_alat
        $data = sop_alat::where('alat_id', $id)->get();
        return response()->json($data);
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
        $data = Alat::find($id);
        $data->delete();
        return response()->json(['status' => true]);
    }
}
