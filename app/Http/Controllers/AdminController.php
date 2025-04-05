<?php

// AdminController.php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function manageUsers()
    {
        $users = User::all();  // Lấy tất cả người dùng
        return view('admin.manage_users', compact('users'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);  // Tìm người dùng theo ID
        return view('admin.edit_user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return redirect()->route('admin.manage_users');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.manage_users');
    }

    public function manageMedicalData()
    {
        return view('admin.manage_medical_data');
    }

    public function manageVipPackages()
    {
        return view('admin.manage_vip_packages');
    }

    public function statisticsReports()
    {
        return view('admin.statistics_reports');
    }
}

