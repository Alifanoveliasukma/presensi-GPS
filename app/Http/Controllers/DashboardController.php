<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $hariIni = date("Y-m-d");
        $bulanIni = date('m') * 1; // 1 atau januari
        $tahunIni = date("Y"); // 2023
        $nik = Auth::guard('karyawan')->user()->nik;
        $presensiHariIni = DB::table('presensi')->where('nik', $nik)->where('tgl_presensi', $hariIni)->first();
        $historyBulanIni = DB::table('presensi')
        ->whereRaw('nik', $nik)
        ->whereRaw('MONTH(tgl_presensi)="'. $bulanIni . '"')
        ->whereRaw('YEAR(tgl_presensi)="' .$tahunIni . '"')
        ->orderBy('tgl_presensi')
        ->get();

        $rekapPresensi = DB::table('presensi')
        ->selectRaw('COUNT(nik) as jmlhadir, SUM(IF(jam_in > "07.00", 1, 0)) as jmlterlambat' )
        ->where('nik', $nik)
        ->whereRaw('MONTH(tgl_presensi)="'. $bulanIni . '"')
        ->whereRaw('YEAR(tgl_presensi)="' .$tahunIni . '"')
        ->first();

        $leaderBoard = DB::table('presensi')
        ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
        ->where('tgl_presensi', $hariIni )
        ->orderBy('jam_in')
        ->get();
        
        $namaBulan = ["","Januari","Februari", "Maret", "April", "Mei","Juni","Juli", "Agustus", "September","Oktober", "November","Desember"];

        // dd($historyBulanIni); buat cek nanti
        return view('dashboard.dashboard', compact('presensiHariIni','historyBulanIni', 'namaBulan', 'bulanIni','tahunIni','rekapPresensi', 'leaderBoard'));
        
    }
}
