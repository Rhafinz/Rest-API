<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\kategori;
use Validator;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = kategori::latest()->get();
        $response = [
            'success' => true,
            'message' => 'Data Kategori',
            'data' => $kategori,
        ];
        return response()->json($response, 200);
    }
    public function store(Request $request)
    {
        // validator data
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|unique:kategoris',
        ], [
            'nama_kategori.required' => 'Masukan Kategori',
            'nama_kategori.unique' => 'Kategori Sudah digunakan!',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan isi dengan benar',
                'data' => $validator->errors(),
            ], 400);
        } else {
            $kategori = new kategori;
            $kategori->nama_kategori = $request->nama_kategori;
            $kategori->save();
        }
        if ($kategori) {
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
        $kategori = Kategori::find($id);

        if ($kategori) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Kategori',
                'data' => $kategori,
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
            'nama_kategori' => 'required',
        ], [
            'nama_kategori.required' => 'Masukan Kategori',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan isi dengan benar',
                'data' => $validator->errors(),
            ], 400);
        } else {
            $kategori = Kategori::find($id);
            $kategori->nama_kategori = $request->nama_kategori;
            $kategori->save();
        }
        if ($kategori) {
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
        $kategori = Kategori::find($id);
        if ($kategori) {
            $kategori->delete();
            return response()->json([
                'success' => true,
                'message' => 'data ' . $kategori->nama_kategori . ' berhasil dihapus',
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Data tidak ditemukan',
            ], 400);
        }
    }
}
