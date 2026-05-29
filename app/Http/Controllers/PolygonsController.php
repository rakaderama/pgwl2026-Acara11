<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PolygonsModel;
use Illuminate\Support\Facades\File;

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
        $data = [
            'title' => 'Edit Polygon',
            'id' => $id,
            'polygon' => $this->polygons->find($id),
        ];

        return view('map-edit-polygon', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         // validasi input
        $request->validate(
            [
                'geometry' => 'required',
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:255', // ← wajib diisi
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ],
            [
                'geometry.required' => 'Geometry harus diisi.',
                'name.required' => 'Nama harus diisi.',
                'name.string' => 'Nama harus berupa string.',
                'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',

                // pesan validasi description
                'description.required' => 'Deskripsi harus diisi.',
                'description.string' => 'Deskripsi harus berupa string.',
                'description.max' => 'Deskripsi tidak boleh lebih dari 255 karakter.',
                'image.image' => 'Image harus berupa gambar.',
                'image.mimes' => 'Image harus berupa file JPEG, PNG, atau JPG.',
                'image.max' => 'Image tidak boleh lebih dari 2MB.',
            ]
        );

        // Create directory if not exists
        if (!is_dir('storage/images')) {
            mkdir('./storage/images', 0777);
        }

        $image_old = $this->polygons->find($id)->image;

        // Get image from request
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_polygon." . strtolower($image->getClientOriginalExtension());
            $image->move('storage/images', $name_image);
        } else {
            $name_image = $image_old; // tetap gunakan gambar lama jika tidak ada gambar baru yang diunggah
        }

        if ($image_old != null) {
            $filepath = public_path('storage/images/' . $image_old);
            if (File_exists('./storage/images/' . $image_old)) {
                unlink('./storage/images/' . $image_old); // hapus file gambar lama jika ada gambar baru yang diunggah
            }
        }

        $data = [
            'geom' => $request->geometry,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $name_image,
        ];

        // simpan update ke database
        if (!$this->polygons->find($id)->update($data)) {
            return redirect()->route('peta')
                ->with('error', 'Gagal memperbarui data polygon.');
        }

        // kembali ke halaman peta
        return redirect()->route('peta')
            ->with('success', 'Data polygon berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Mencari data berdasarkan ID
        $polygon = $this->polygons->find($id);

        // Hapus file gambar jika ada di storage
        if ($polygon->image) {
            $filepath = public_path('storage/images/' . $polygon->image);
            if (File::exists($filepath)) {
                File::delete($filepath);
            }
        }

        // hapus data dari database
        if (!$polygon->delete()) {
            return redirect()->route('peta')
                ->with('error', 'Gagal menghapus data polygon.');
        }

        // kembali ke halaman peta dengan pesan sukses
        return redirect()->route('peta')
            ->with('success', 'Data polygon berhasil dihapus.');
    }
}
