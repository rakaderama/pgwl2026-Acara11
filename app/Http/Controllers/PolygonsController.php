<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PolygonsModel;

class PolygonsController extends Controller
{
    protected $polygons;

    public function __construct()
    {
        $this->polygons = new PolygonsModel();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        // validasi input
        $request->validate([
        'geometry_polygon' => 'required',
        'name' => 'required|string|max:255',
        'description' => 'required|string|max:255', // ← wajib diisi
    ],
    [
        'geometry_polygon.required' => 'Geometry polygon harus diisi.',
        'name.required' => 'Nama harus diisi.',
        'name.string' => 'Nama harus berupa string.',
        'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',

        // pesan validasi description
        'description.required' => 'Deskripsi harus diisi.',
        'description.string' => 'Deskripsi harus berupa string.',
        'description.max' => 'Deskripsi tidak boleh lebih dari 255 karakter.',
    ]);

        $data = [
            'geom'=>$request->geometry_polygon,
            'name'=>$request->name,
            'description'=>$request->description,
        ];

        //simpan data ke database
        if (!$this->polygons->create($data)) {
            return redirect()->route('peta')->with('error', 'Gagal menyimpan data polygon.');
        }

        //kembalikan ke halaman peta
        return redirect()->route('peta')->with('success', 'Data polygon berhasil disimpan.');
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
