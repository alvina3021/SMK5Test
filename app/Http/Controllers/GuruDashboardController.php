<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class GuruDashboardController extends Controller
{
    /**
     * Menampilkan Dashboard Khusus Guru dengan Filter
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'guru') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        // 1. Ambil Daftar Kelas (Hanya dari siswa yang SUDAH MENGISI tes)
        // Agar filter kelas tidak menampilkan kelas yang siswanya belum ada yang tes
        $kelasOptions = User::where('role', 'siswa')
            ->where(function($q) {
                $q->has('siswaData')->orHas('riasecResult');
            })
            ->whereNotNull('kelas')
            ->distinct()
            ->orderBy('kelas')
            ->pluck('kelas');

        // 2. Query Dasar Siswa
        $query = User::where('role', 'siswa')
            // --- FILTER UTAMA: Hanya ambil siswa yang sudah mengisi minimal satu tes ---
            ->where(function($q) {
                $q->has('siswaData')       // Sudah isi Data Pribadi
                  ->orHas('riasecResult'); // ATAU Sudah isi RIASEC
            })
            // --------------------------------------------------------------------------
            ->with([
                'siswaData' => function($q) { $q->latest(); },
                'riasecResult' => function($q) { $q->latest(); }
            ]);

        // 3. Terapkan Filter Kelas (Jika dipilih)
        if ($request->has('kelas') && $request->kelas != '') {
            $query->where('kelas', $request->kelas);
        }

        $students = $query->get();

        // 4. Olah Data (Mapping)
        $rekapSiswa = $students->map(function($student) {

            // Logic Data Pribadi
            $dataPribadi = $student->siswaData->first();
            $statusDP = $dataPribadi ? 'Selesai' : 'Belum';
            $tanggalDP = $dataPribadi ? $dataPribadi->created_at->format('d M Y') : '-';

            // Logic RIASEC
            $riasec = $student->riasecResult->first();
            $statusRiasec = $riasec ? 'Selesai' : 'Belum';
            $hasilRiasec = '-';

            if ($riasec) {
                $answers = is_string($riasec->answers) ? json_decode($riasec->answers, true) : $riasec->answers;
                $scores = ['R' => 0, 'I' => 0, 'A' => 0, 'S' => 0, 'E' => 0, 'C' => 0];
                if (is_array($answers)) {
                    foreach ($answers as $key => $val) {
                        if (array_key_exists($key, $scores) && is_array($val)) {
                            $scores[$key] = count($val);
                        } else {
                            $type = substr($key, 0, 1);
                            if (array_key_exists($type, $scores)) $scores[$type]++;
                        }
                    }
                }
                arsort($scores);
                $topKey = array_key_first($scores);

                $names = [
                    'R' => 'Realistic', 'I' => 'Investigative', 'A' => 'Artistic',
                    'S' => 'Social', 'E' => 'Enterprising', 'C' => 'Conventional'
                ];
                $hasilRiasec = $topKey . ' (' . ($names[$topKey] ?? '') . ')';
            }

            return [
                'id' => $student->id,
                'nama' => $student->name,
                'nis' => $student->nis ?? '-',
                'kelas' => $student->kelas ?? '-',
                'data_pribadi' => [
                    'status' => $statusDP,
                    'tanggal' => $tanggalDP
                ],
                'riasec' => [
                    'status' => $statusRiasec,
                    'hasil' => $hasilRiasec
                ]
            ];
        });

        return view('dashboard_guru', compact('user', 'rekapSiswa', 'kelasOptions'));
    }
}
