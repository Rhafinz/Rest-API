<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aktor;
use Validator;

class AktorController extends Controller
{
    public function index()
    {
        $aktor = Aktor::latest()->get();
        $response = [
            'success' => true,
            'message' => 'Data Aktor',
            'data' => $aktor,
        ];
        return response()->json($response, 200);
    }
    public function store(Request $request)
    {
        // validator data
        $validator = Validator::make($request->all(), [
            'nama_aktor' => 'required',
            'biodata' => 'required',
        ], [
            'nama_aktor.required' => 'Masukan Aktor',
            'biodata.required' => 'Masukan Biodata',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan isi dengan benar',
                'data' => $validator->errors(),
            ], 400);
        } else {
            $aktor = new Aktor;
            $aktor->nama_aktor = $request->nama_aktor;
            $aktor->biodata = $request->biodata;
            $aktor->save();
        }
        if ($aktor) {
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
        $aktor = Aktor::find($id);

        if ($aktor) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Aktor',
                'data' => $aktor,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Aktor Tidak ditemukan',
            ], 404);
        }
    }
    public function update(Request $request, $id)
    {
        // validator data
        $validator = Validator::make($request->all(), [
            'nama_aktor' => 'required',
            'biodata' => 'required',
        ], [
            'nama_aktor.required' => 'Masukan Aktor',
            'biodata.required' => 'Masukan Biodata',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan isi dengan benar',
                'data' => $validator->errors(),
            ], 400);
        } else {
            $aktor = Aktor::find($id);
            $aktor->nama_aktor = $request->nama_aktor;
            $aktor->biodata = $request->biodata;
            $aktor->save();
        }
        if ($aktor) {
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
        $aktor = Aktor::find($id);
        if ($aktor) {
            $aktor->delete();
            return response()->json([
                'success' => true,
                'message' => 'data ' . $aktor->nama_aktor . ' berhasil dihapus',
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Data tidak ditemukan',
            ], 400);
        }
    }
}
