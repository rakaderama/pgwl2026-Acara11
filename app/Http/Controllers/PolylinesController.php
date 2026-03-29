<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PolylinesModel;

class PolylinesController extends Controller
{
    protected $polylines;

    public function __construct()
    {
        $this->polylines = new polylinesModel();
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
        'geometry_polyline' => 'required',
        'name' => 'required|string|max:255',
        'description' => 'required|string|max:255', // ← wajib diisi
    ],
    [
        'geometry_polyline.required' => 'Geometry polyline harus diisi.',
        'name.required' => 'Nama harus diisi.',
        'name.string' => 'Nama harus berupa string.',
        'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',

        // pesan validasi description
        'description.required' => 'Deskripsi harus diisi.',
        'description.string' => 'Deskripsi harus berupa string.',
        'description.max' => 'Deskripsi tidak boleh lebih dari 255 karakter.',
    ]);

    $data = [
        'geom' => $request->geometry_polyline,
        'name' => $request->name,
        'description' => $request->description,
    ];

    // simpan data ke database
    if (!$this->polylines->create($data)) {
        return redirect()->route('peta')
            ->with('error', 'Gagal menyimpan data polyline.');
    }

    // kembali ke halaman peta
    return redirect()->route('peta')
        ->with('success', 'Data polyline berhasil disimpan.');
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
