<?php

namespace App\Http\Controllers;

use App\Models\MedicalData;
use Illuminate\Http\Request;

class MedicalDataController extends Controller
{
    // Xem danh sách dữ liệu y khoa
    public function index()
    {
        $medicalData = MedicalData::all();
        return view('admin.manage_medical_data', compact('medicalData'));
    }

    // Form thêm mới dữ liệu y khoa
    public function create()
    {
        return view('admin.create_medical_data');
    }

    // Lưu dữ liệu y khoa
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        MedicalData::create($request->all());

        return redirect()->route('admin.manage_medical_data')->with('success', 'Dữ liệu y khoa đã được thêm.');
    }

    // Form chỉnh sửa dữ liệu y khoa
    public function edit($id)
    {
        $medicalData = MedicalData::findOrFail($id);
        return view('admin.edit_medical_data', compact('medicalData'));
    }

    // Cập nhật dữ liệu y khoa
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $medicalData = MedicalData::findOrFail($id);
        $medicalData->update($request->all());

        return redirect()->route('admin.manage_medical_data')->with('success', 'Dữ liệu y khoa đã được cập nhật.');
    }

    // Xóa dữ liệu y khoa
    public function destroy($id)
    {
        $medicalData = MedicalData::findOrFail($id);
        $medicalData->delete();

        return redirect()->route('admin.manage_medical_data')->with('success', 'Dữ liệu y khoa đã được xóa.');
    }
}
