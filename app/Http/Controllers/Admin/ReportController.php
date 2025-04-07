<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $usersCount = DB::table('users')->count();
        $vipCount = DB::table('users')->where('role', 'vip')->count();
        $adminCount = DB::table('users')->where('role', 'admin')->count();
        $medicalDataCount = DB::table('medical_data')->count();
        $vipPackages = DB::table('vip_packages')->count();

        $latestUsers = DB::table('users')->orderBy('created_at', 'desc')->limit(5)->get();
        $latestMedicalData = DB::table('medical_data')->orderBy('created_at', 'desc')->limit(5)->get();

        return view('admin.statistics_reports', compact(
            'usersCount',
            'vipCount',
            'adminCount',
            'medicalDataCount',
            'vipPackages',
            'latestUsers',
            'latestMedicalData'
        ));
    }
}
