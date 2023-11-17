<?php

namespace App\Http\Controllers;

use App\Models\Employees;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
       $employees = Employees::all();

        // Jika data kosong, kirim status code 204
        if ($employees->isEmpty()) {
            $data = [
                'message' => 'Resource is empty'
            ];

            return response()->json($data, 204);
        }

        $data = [
            "message" => "Get all employees",
            "data" =>$employees
        ];

        // Kirim data (json) dan response code 200
        return response()->json($data, 200);
    }

    //membuat methos store
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'phone' => 'numeric|required',
            'address' => 'required|string', // Menggunakan 'string' untuk validasi teks
            'email' => 'email|required',
            'status' => 'required',
            'hired_on' => 'date|required',
        ]);
    
        $employee = Employees::create($validatedData);
    
        return response()->json(['message' => 'Employee is created successfully', 'data' => $employee],201);
    }
    
    //untuk menampilkan semua data 
    public function show($id){
       $employees = employees::find($id);
        //jika data yang dicari tidak ada, kirim kode 404
        if (!$employees) {
            $data = [
                'message' => "employees not found",
            ];
            return response()->json($data, 404);
        }
        $data = [
            'message' => "show details of employesss",
            'data' =>$employees,
        ];

        return response()->json($data, 200);
    }

    //untuk update data
    public function update($id, Request $request)
    {
        // Temukan pegawai berdasarkan ID
        $employees = Employees::find($id);
    
        // Jika data yang dicari tidak ada, kirim kode 404 
        if (!$employees) {
            $data = [
                "message" => "Data not found"
            ];
            return response()->json($data, 404);
        }
    
        $employees->update([
            'name' => $request->input('name') ?? $employees->name,
            'gender' => $request->input('gender') ?? $employees->gender,
            'phone' => $request->input('phone') ?? $employees->phone,
            'address' => $request->input('address') ?? $employees->address,
            'email' => $request->input('email') ?? $employees->email,
            'status' => $request->input('status') ?? $employees->status,
            'hired_on' => $request->input('hired_on') ?? $employees->hired_on,
        ]);
    
        $data = [
            'message' => "Data is updated",
            'data' => $employees,
        ];
    
        // Mengembalikan respons JSON dengan kode 200
        return response()->json($data, 200);
    }
    
    //unutk menghapus data pegawai
    public function destroy($id)
    {
        // Cari pegawai berdasarkan ID
       $employees = Employees::find($id);

        // Jika pegawai tidak ditemukan, kirim kode 404
        if (!$employees) {
            $data = [
                'message' => "Employee not found",
            ];
            return response()->json($data, 404);
        }

        // Hapus pegawai
       $employees->delete();

        // Kirim respons berhasil
        $data = [
            'message' => 'Employee deleted successfully',
        ];

        return response()->json($data, 200);
    }

    public function search(Request $request)
    {

        // Validasi parameter pencarian
        $request->validate([
            'name' => 'required',
        ]);

        // Lakukan pencarian berdasarkan nama pegawai
        $employees = Employees::where('name', 'LIKE', '%' . $request->input('name') . '%')->get();

        // Jika hasil pencarian kosong, kirim status code 404
        if ($employees->isEmpty()) {
            $data = [
                'message' => 'No matching results found',
            ];

            return response()->json($data, 404);
        }

        // Kirim hasil pencarian
        $data = [
            'message' => 'Search results',
            'data' => $employees,
        ];

        return response()->json($data, 200);
    }
}


