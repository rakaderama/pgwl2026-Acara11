<?php

namespace App\Http\Controllers;

use App\Models\pointsModel;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Description;

class PointsController extends Controller
{
    public $points;

    public function __construct()
    {
        $this->points = new pointsModel();
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
        'geometry_point' => 'required',
        'name' => 'required|string|max:255',
        'description' => 'required|string|max:255', // ← wajib diisi
    ],
    [
        'geometry_point.required' => 'Geometry point harus diisi.',
        'name.required' => 'Nama harus diisi.',
        'name.string' => 'Nama harus berupa string.',
        'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',

        // pesan validasi description
        'description.required' => 'Deskripsi harus diisi.',
        'description.string' => 'Deskripsi harus berupa string.',
        'description.max' => 'Deskripsi tidak boleh lebih dari 255 karakter.',
    ]);

    $data = [
        'geom' => $request->geometry_point,
        'name' => $request->name,
        'description' => $request->description,
    ];

    // simpan data ke database
    if (!$this->points->create($data)) {
        return redirect()->route('peta')
            ->with('error', 'Gagal menyimpan data point.');
    }

    // kembali ke halaman peta
    return redirect()->route('peta')
        ->with('success', 'Data point berhasil disimpan.');
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
