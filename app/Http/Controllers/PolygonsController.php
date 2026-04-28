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
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
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
        'image.image' => 'File harus berupa gambar.',
        'image.mimes' => 'Gambar harus berupa file JPEG, PNG, atau JPG.',
        'image.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',

    ]);

     // Create directory if not exists
        if (!is_dir('storage/images')) {
            mkdir('./storage/images', 0777);
        }

        // Get image from request
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_polygon." . strtolower($image->getClientOriginalExtension());
            $image->move('storage/images', $name_image);
        } else {
            $name_image = null;
        }

        $data = [
            'geom'=>$request->geometry_polygon,
            'name'=>$request->name,
            'description'=>$request->description,
            'image'=>$name_image,
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
