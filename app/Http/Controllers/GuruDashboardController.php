<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use App\Models\User;
use App\Models\SiswaData;

class GuruDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'guru') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        // 1. Ambil Opsi Kelas
        $kelasOptions = DB::table('siswa_data')
            ->select('kelas')
            ->whereNotNull('kelas')
            ->distinct()
            ->orderBy('kelas')
            ->pluck('kelas');

        // 2. Query Siswa
        $query = User::where('role', 'siswa');

        // 3. Filter Kelas
        if ($request->has('kelas') && $request->kelas != '') {
            $userIds = DB::table('siswa_data')
                ->where('kelas', $request->kelas)
                ->pluck('user_id');
            $query->whereIn('id', $userIds);
        }

        $students = $query->get();

        // 4. Mapping Data
        $rekapSiswa = $students->map(function($student) {
            
            // Cek Data Pribadi
            $cekSiswaData = DB::table('siswa_data')->where('user_id', $student->id)->exists();
            
            $dataSiswa = DB::table('siswa_data')->where('user_id', $student->id)->first();
            $kelas = $dataSiswa ? $dataSiswa->kelas : '-';
            $nis = $student->nis ?? '-'; 

            // DEFINISI TUGAS & URL DETAILNYA
            // 'table' => Nama tabel di database
            // 'url_slug' => Bagian dari URL (misal: /guru/hasil-riasec/...)
            $taskList = [
                'Data Pribadi Siswa' => [
                    'table' => 'siswa_data', 
                    'url_slug' => 'detail-siswa' 
                ],
                'RIASEC' => [
                    'table' => 'riasec_results', 
                    'url_slug' => 'hasil-riasec' 
                ],
                'Motivasi Belajar' => [
                    'table' => 'motivasi_belajar', 
                    'url_slug' => 'hasil-motivasi' 
                ],
                'Studi Habit & Gaya Belajar' => [
                    'table' => 'studi_habit', 
                    'url_slug' => 'hasil-studi-habit' 
                ],
                'Sosial Emosional & Kes. Mental' => [
                    'table' => 'sosial_emosional', 
                    'url_slug' => 'hasil-sosial-emosional' 
                ],
                'Preferensi Kelompok' => [
                    'table' => 'preferensi_kelompok', 
                    'url_slug' => 'hasil-preferensi-kelompok' 
                ],
                'Skala Preferensi Belajar' => [
                    'table' => 'skala_preferensi_belajar', 
                    'url_slug' => 'hasil-skala-preferensi' 
                ],
                'Alat Ungkap Masalah (AUM)' => [
                    'table' => 'aum_results', 
                    'url_slug' => 'hasil-aum' 
                ],
            ];

            $detailTugas = [];
            $jumlahSelesai = 0;

            foreach ($taskList as $label => $config) {
                // Cek database
                $isDone = DB::table($config['table'])->where('user_id', $student->id)->exists();
                
                if ($isDone) {
                    $jumlahSelesai++;
                }

                $detailTugas[] = [
                    'label'  => $label,
                    'status' => $isDone ? 'Sudah Mengerjakan' : 'Belum Mengerjakan',
                    // Jika sudah selesai, buat URL. Jika belum, URL null.
                    'url'    => $isDone ? url('guru/' . $config['url_slug'] . '/' . $student->id) : '#',
                ];
            }

            // Hitung Persentase
            $totalTugas = count($taskList);
            $persentase = $totalTugas > 0 ? round(($jumlahSelesai / $totalTugas) * 100) : 0;

            return [
                'id'            => $student->id,
                'nama'          => $student->name,
                'nis'           => $nis,
                'kelas'         => $kelas,
                'total_selesai' => $jumlahSelesai,
                'total_tugas'   => $totalTugas,
                'persentase'    => $persentase,
                'detail'        => $detailTugas,
            ];
        });

        return view('dashboard_guru', compact('user', 'rekapSiswa', 'kelasOptions'));
    }
}