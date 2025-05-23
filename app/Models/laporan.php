<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';
    public $timestamps = false;

    public static function getDataStatusMasuk()
    {
        return count(self::where('status', 'Masuk')
            ->whereDate('tanggal', now()->toDateString())
            ->get());
    }

    public static function getDataSuratSelesaiBulanIni()
    {
        return self::where('status', 'Selesai')
            ->whereYear('tanggal', now()->year)
            ->whereMonth('tanggal', now()->month)
            ->count();
    }

    public static function getDataTabelAll() {
        return self::
        join( 'pengajuan_surat', 'pengajuan_surat.id', '=', 'laporan.id' )
        ->join( 'surat', 'pengajuan_surat.kode_surat', '=', 'surat.kode_surat' )
        // ->where( 'laporan.status', 'Masuk' )
        ->select( 'pengajuan_surat.nik', 'pengajuan_surat.nama', 'pengajuan_surat.tanggal', 'pengajuan_surat.id', 'pengajuan_surat.kode_surat', 'surat.Keterangan', 'laporan.status' )
        ->orderBy( 'pengajuan_surat.tanggal', 'desc' ) // Add this line to sort by tanggal in descending order
        ->get();
    }

    public static function getDataTabel($bulan, $tahun)
    {
        return self::join('pengajuan_surat', 'pengajuan_surat.id', '=', 'laporan.id')
            ->join('surat', 'pengajuan_surat.kode_surat', '=', 'surat.kode_surat')
            ->whereMonth('laporan.tanggal', $bulan)
            ->whereYear('laporan.tanggal', $tahun)
            ->select('pengajuan_surat.nik', 'pengajuan_surat.nama', 'laporan.tanggal', 'pengajuan_surat.id', 'pengajuan_surat.kode_surat', 'surat.Keterangan', 'laporan.status')
            ->whereIn('laporan.status', ['Selesai', 'Tolak'])
            ->orderBy('pengajuan_surat.tanggal', 'desc')
            ->get();
    }


    public static function getlaporan($no_pengajuan, $kode_surat)
    {
        return self::join('pengajuan_surat', 'pengajuan_surat.id', '=', 'laporan.id')
            ->where('pengajuan_surat.no_pengajuan', $no_pengajuan)
            ->where('pengajuan_surat.kode_surat', $kode_surat)
            ->select('laporan.tanggal as tanggal')
            ->get();
    }

    public static function updatestatus($no_pengajuan,$kode_surat){
       return self::join('pengajuan_surat', 'laporan.id', '=', 'pengajuan_surat.id')
    ->where('pengajuan_surat.kode_surat', $kode_surat)
    ->where('pengajuan_surat.no_pengajuan', $no_pengajuan)
    ->update([
        'status' => 'Selesai',
        'alasan' => 'Silahkan Ambil Surat di Kantor Desa Pesudukuh'
    ]);
    }

    public static function tolakdetail($no_pengajuan,$kode_surat,$alasan){
        return self::join('pengajuan_surat', 'laporan.id', '=', 'pengajuan_surat.id')
     ->where('pengajuan_surat.kode_surat', $kode_surat)
     ->where('pengajuan_surat.no_pengajuan', $no_pengajuan)
     ->update([
         'status' => 'Tolak',
         'alasan' => $alasan
     ]);
     }
}
