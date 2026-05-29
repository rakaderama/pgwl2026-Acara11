<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PolylinesModel;
use Illuminate\Support\Facades\File;

class PolylinesController extends Controller
{
    public $polylines;

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
        $request->validate(
            [
                'geometry_polyline' => 'required',
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ],
            [
                'geometry_polyline.required' => 'Geometry polyline harus diisi.',
                'name.required' => 'Nama harus diisi.',
                'name.string' => 'Nama harus berupa string.',
                'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
                'description.required' => 'Deskripsi harus diisi.',
                'description.string' => 'Deskripsi harus berupa string.',
                'description.max' => 'Deskripsi tidak boleh lebih dari 255 karakter.',
                'image.image' => 'File harus berupa gambar.',
                'image.mimes' => 'Gambar harus berupa file JPEG, PNG, atau JPG.',
                'image.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
            ]
        );

        // Create directory if not exists
        if (!is_dir('storage/images')) {
            mkdir('./storage/images', 0777);
        }

        // Get image from request
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_polyline." . strtolower($image->getClientOriginalExtension());
            $image->move('storage/images', $name_image);
        } else {
            $name_image = null;
        }

        $data = [
            'geom' => $request->geometry_polyline,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $name_image,
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
        $data = [
            'title' => 'Edit Polyline',
            'id' => $id,
            'polyline' => $this->polylines->find($id),
        ];

        return view('map-edit-polyline', $data);
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

        $image_old = $this->polylines->find($id)->image;

        // Get image from request
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_polyline." . strtolower($image->getClientOriginalExtension());
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
        if (!$this->polylines->find($id)->update($data)) {
            return redirect()->route('peta')
                ->with('error', 'Gagal memperbarui data polyline.');
        }

        // kembali ke halaman peta
        return redirect()->route('peta')
            ->with('success', 'Data polyline berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Mencari data berdasarkan ID
        $polyline = $this->polylines->find($id);

        // Hapus file gambar jika ada di storage
        if ($polyline && $polyline->image) {
            $filepath = public_path('storage/images/' . $polyline->image);
            if (File::exists($filepath)) {
                File::delete($filepath);
            }
        }

        // hapus data dari database
        if (!$polyline || !$polyline->delete()) {
            return redirect()->route('peta')
                ->with('error', 'Gagal menghapus data polyline.');
        }

        // kembali ke halaman peta dengan pesan sukses
        return redirect()->route('peta')
            ->with('success', 'Data polyline berhasil dihapus.');
    }
}
