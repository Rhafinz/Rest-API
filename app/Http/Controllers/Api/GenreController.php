<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genre;
use Validator;

class GenreController extends Controller
{
    public function index()
    {
        $genre = Genre::latest()->get();
        $response = [
            'success' => true,
            'message' => 'Data Genre',
            'data' => $genre,
        ];
        return response()->json($response, 200);
    }
    public function store(Request $request)
    {
        // validator data
        $validator = Validator::make($request->all(), [
            'nama_genre' => 'required|unique:genres',
        ], [
            'nama_genre.required' => 'Masukan Genre',
            'nama_genre.unique' => 'Kategori Sudah digunakan!',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan isi dengan benar',
                'data' => $validator->errors(),
            ], 400);
        } else {
            $genre = new Genre;
            $genre->nama_genre = $request->nama_genre;
            $genre->save();
        }
        if ($genre) {
            return response()->json([
                'success' => true,
                'message' => 'data berhasil disimpan',
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'data gagal disimpan'
            ], 400);
        }
    }

    public function show($id)
    {
        $genre = Genre::find($id);

        if ($genre) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Genre',
                'data' => $genre,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Kategori Tidak ditemukan',
            ], 404);
        }
    }
    public function update(Request $request, $id)
    {
        // validator data
        $validator = Validator::make($request->all(), [
            'nama_genre' => 'required',
        ], [
            'nama_genre.required' => 'Masukan Genre',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan isi dengan benar',
                'data' => $validator->errors(),
            ], 400);
        } else {
            $genre = Genre::find($id);
            $genre->nama_genre = $request->nama_genre;
            $genre->save();
        }
        if ($genre) {
            return response()->json([
                'success' => true,
                'message' => 'data berhasil diperbarui',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'data gagal disimpan'
            ], 400);
        }
    }
    public function destroy($id)
    {
        $genre = Genre::find($id);
        if ($genre) {
            $genre->delete();
            return response()->json([
                'success' => true,
                'message' => 'data ' . $genre->nama_genre . ' berhasil dihapus',
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Data tidak ditemukan',
            ], 400);
        }
    }

}
