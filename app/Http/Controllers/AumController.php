<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AumResult;

class AumController extends Controller
{
    /**
     * DATABASE SOAL (PRIVATE METHOD)
     */
    private function getAllQuestions()
    {
        return [
            'JAS' => [
                                ['id' => '001', 'text' => 'Badan terlalu kurus atau terlalu gemuk'],
                                ['id' => '002', 'text' => 'Terdapat gangguan pada penglihatan atau pendengaran'],
                                ['id' => '003', 'text' => 'Sering merasa pusing atau sakit kepala'],
                                ['id' => '004', 'text' => 'Kurang nafsu makan atau makan tidak teratur'],
                                ['id' => '005', 'text' => 'Sering mengalami gangguan pencernaan'],
                                ['id' => '016', 'text' => 'Fungsi dan/atau kondisi kesehatan mata kurang baik'],
                                ['id' => '017', 'text' => 'Mengalami gangguan tertentui karena cacat jasmani'],
                                ['id' => '018', 'text' => 'Fungsi dan/atau kondisi kesehatan hidung kurang baik'],
                                ['id' => '019', 'text' => 'Kondisi kesehatan kulit sering terganggu'],
                                ['id' => '020', 'text' => 'Gangguan pada gigi'],
                                ['id' => '031', 'text' => 'Fungsi dan/atau kondisi kerongkongan kurang baik atau sering terganggu,misalnya serak'],
                                ['id' => '032', 'text' => 'Gagap dalam berbicara'],
                                ['id' => '033', 'text' => 'Fungsi dan/atau kondisi kesehatan telinga kurang baik'],
                                ['id' => '034', 'text' => 'Kurang mampu berolahraga karena kondisi jasmani yang kurang baik'],
                                ['id' => '035', 'text' => 'Gangguan pada pencernaan makanan'],
                                ['id' => '046', 'text' => 'Sering pusing dan/atau mudah sakit'],
                                ['id' => '047', 'text' => 'Mengalami gangguan setiap datang bulan'],
                                ['id' => '048', 'text' => 'Secara umum merasa tidak sehat'],
                                ['id' => '049', 'text' => 'Khawatir mengidap penyakit turunan'],
                                ['id' => '050', 'text' => 'Selera makan sering terganggu'],
                                ['id' => '061', 'text' => 'Mengidap penyakit kambuhan'],
                                ['id' => '062', 'text' => 'Alergi terhadap makanan atau keadaan tertentu'],
                                ['id' => '063', 'text' => 'Kurang atau susah tidur'],
                                ['id' => '064', 'text' => 'Mengalami gangguan akibat merokok atau minuman atau obat-obatan'],
                                ['id' => '065', 'text' => 'Khawatir tertular penyakit yang diderita orang lain']
                            ],
                            'DPI' => [
                                ['id' => '076', 'text' => 'Sering mimpi buruk'],
                                ['id' => '077', 'text' => 'Cemas atau khawatir tentang sesuatu yang belum pasti'],
                                ['id' => '078', 'text' => 'Mudah lupa'],
                                ['id' => '079', 'text' => 'Sering melamun atau berkhayal'],
                                ['id' => '080', 'text' => 'Ceroboh atau kurang hati-hati'],
                                ['id' => '091', 'text' => 'Sering murung dan/atau  merasa tidak bahagia'],
                                ['id' => '092', 'text' => 'Mengalami kerugian atau kesulitan karena terlampau hati-hati'],
                                ['id' => '093', 'text' => 'Kurang serius menghadapi sesuatu yang penting'],
                                ['id' => '094', 'text' => 'Merasa hidup ini kurang berarti'],
                                ['id' => '095', 'text' => 'Sering gagal dan/atau  mudah patah semangat'],
                                ['id' => '106', 'text' => 'Mudah gentar atau khawatir dalam menghadapi dan/atau  mengemukakan sesuatu'],
                                ['id' => '107', 'text' => 'Penakut, pemalu, dan/atau  mudah menjadi bingung'],
                                ['id' => '108', 'text' => 'Keras kepala atau sukar mengubah pendapat sendiri meskipun kata orang lain pendapat itu salah'],
                                ['id' => '109', 'text' => 'Takut mencoba sesuatu yang baru'],
                                ['id' => '110', 'text' => 'Mudah marah atau tidak mampu mengendalikan diri'],
                                ['id' => '121', 'text' => 'Ragu akan kemampuan saya untuk sukses dalam bekerja'],
                                ['id' => '122', 'text' => 'Belum mampu merencanakan masa depan'],
                                ['id' => '123', 'text' => 'Takut akan bayangan masa depan'],
                                ['id' => '124', 'text' => 'Mengalami masalah karena membanding-bandingkan pekerjaan yang layak atau tidak layak untuk dijabat'],
                                ['id' => '125', 'text' => 'Khawatir diperlakukan secara tidak wajar atau tidak adil dalam mencari dan/atau melamar pekerjaaan']
                            ],
                            'HSO' => [
                                ['id' => '136', 'text' => 'Tidak menyukai atau tidak disukai seseorang'],
                                ['id' => '137', 'text' => 'Merasa diperhatikan, dibicarakan atau diperolokkan orang lain'],
                                ['id' => '138', 'text' => 'Mengalami masalah karena ingin lebih terkenal atau lebih menarik atau lebih menyenangkan bagi orang lain'],
                                ['id' => '139', 'text' => 'Mempunyai kawan yang kurang disukai orang lain'],
                                ['id' => '140', 'text' => 'Tidak mempunyai kawan akrab, hubungan sosial terbatas atau terisolir'],
                                ['id' => '151', 'text' => 'Kurang perduli terhadap orang lain'],
                                ['id' => '152', 'text' => 'Rapuh dalam berteman'],
                                ['id' => '153', 'text' => 'Tidak Merasa tudak dianggap penting, diremehkan atau dikecam oleh orang lain'],
                                ['id' => '154', 'text' => 'Mengalami masalah dengan orang lain karena kurang perduli terhadap diri sendiri'],
                                ['id' => '155', 'text' => 'Canggung dan/atau tidak lancar berkomunikasi dengan orang lain'],
                                ['id' => '166', 'text' => 'Tidak lincah dan kurang mengetahui tentang tata krama pergaulan'],
                                ['id' => '167', 'text' => 'Kurang pandai memimpin dan/atau mudah dipengaruhi orang lain'],
                                ['id' => '168', 'text' => 'Sering membantah atau tidak menyukai sesuatu yang dikatakan/dirasakan orang lain atau dikatakan sombong'],
                                ['id' => '169', 'text' => 'Mudah tersinggung atau sakit hati dalam berhubungan dengan orang lain'],
                                ['id' => '170', 'text' => 'Lambat menjalin persahabatan']
                            ],
                            'EDK' => [
                                ['id' => '181', 'text' => 'Mengalami masalah karena kurang mampu berhemat atau kemampuan keuangan sangat tidak mencukupi, baik untuk keperluan sehari-hari maupun keperluan pekerjaan'],
                                ['id' => '182', 'text' => 'Khawatir tidak mampu menamatkan sekolah ini atau putus sekolah dan harus segera bekerja'],
                                ['id' => '183', 'text' => 'Mengalami masalah karena terlalu berhemat dan/atau ingin menabung'],
                                ['id' => '184', 'text' => 'Kekurangan dalam keuangan menyebabkan dalam pengembangan diri terhambat'],
                                ['id' => '185', 'text' => 'Untuk memenuhi keuangan terpaksa sekolah sambil bekerja'],
                                ['id' => '196', 'text' => 'Mengalami masalah karena ingin berpenghasilan sendiri'],
                                ['id' => '197', 'text' => 'Berhutang yang  cukup memberatkan'],
                                ['id' => '198', 'text' => 'Besarnya uang yang diperoleh dan sumber-sumbernya tidak menentu'],
                                ['id' => '199', 'text' => 'Khawatir akan kondisi keuangan orang tua atau orang yang menjadi sumber keuangan; jangan-jangan harus menjual atau menggadaikan harta keluarga'],
                                ['id' => '200', 'text' => 'Mengalami masalah karena keuangan dikendalikan oleh orang lain'],
                                ['id' => '211', 'text' => 'Mengalami masalah karena membanding-bandingkan kondisi keuangan sendiri dengan kondisi keuangan orang lain'],
                                ['id' => '212', 'text' => 'Kesulitan dalam mendapatkan penghasilan sendiri sambil sekolah'],
                                ['id' => '213', 'text' => 'Mempertanyakan kemungkinan memperoleh beasiswa atau dana bantuan belajar lainnya'],
                                ['id' => '214', 'text' => 'Orang lain menganggap pelit  dan/atau tidak mau membantu kawan yang sedang mengalami kesulitan keuangan'],
                                ['id' => '215', 'text' => 'Terpaksa berbagi pengeluaran keuangan dengan kakak atau adik atau anggota keluarga lain yang sama-sama membutuhkan biaya']
                            ],
                            'KDP' => [
                                ['id' => '006', 'text' => 'Belum mampu memikirkan dan memilih pekerjaan yang akan dijabat nantinya'],
                                ['id' => '007', 'text' => 'Belum mengetahui bakat diri sendiri untuk jabatan/pekerjaan apa'],
                                ['id' => '008', 'text' => 'Kurang memiliki pengetahuan yang luas tentang lapangan pekerjaan dan seluk beluk jenis-jenis pekerjaan'],
                                ['id' => '009', 'text' => 'Ingin memperoleh bantuan dalam mendapatkan pekerjaan sambilan untuk melatih diri bekerja sambil sekolah'],
                                ['id' => '010', 'text' => 'Khawatir akan pekerjaan yang dijabatnya nanti; jangan-jangan memberikan penghasilan yang tidak mencukupi'],
                                ['id' => '021', 'text' => 'Ragu akan kemampuan saya untuk sukses dalam bekerja'],
                                ['id' => '022', 'text' => 'Belum mampu merencanakan masa depan'],
                                ['id' => '023', 'text' => 'Takut akan bayangan masa depan'],
                                ['id' => '024', 'text' => 'Mengalami masalah karena membanding-bandingkan pekerjaan yang layak atau tidak layak untuk dijabat'],
                                ['id' => '025', 'text' => 'Khawatir diperlakukan secara tidak wajar atau tidak adil dalam mencari dan/atau melamar pekerjaaan'],
                                ['id' => '036', 'text' => 'Kurang yakin terhadap kamampuan pendidikan sekarang ini dalam menyiapkan jabatan tertentu nantinya'],
                                ['id' => '037', 'text' => 'Ragu tentang kesempatan memperoleh pekerjaan sesuai dengan pendidikan yang diikuti sekarang ini'],
                                ['id' => '038', 'text' => 'Ingin mengikuti kegiatan pelajaran dan/atau latihan khusus tertentu yang benar-benar menunjang proses mencari dan melamar pekerjaan setamat pendidikan ini'],
                                ['id' => '039', 'text' => 'Cemas kalau menjadi penganggur setamat pendidikan ini'],
                                ['id' => '039', 'text' => 'Ragu apakah setamat pendidikan ini dapat bekerja secara mandiri']
                            ],
                            'ANM' => [
                                ['id' => '111', 'text' => 'Mengalami masalah untuk pergi ke tempat peribadatan'],
                                ['id' => '112', 'text' => 'Mempunyai pandangan dan/atau  kebiasaan yang tidak sesuai dengan kaidah-kaidah agama'],
                                ['id' => '113', 'text' => 'Tidak mampu melaksanakan tuntutan keagamaan dan/atau khawatir tidak mampu menghindari larangan yang ditentukan oleh agama'],
                                ['id' => '114', 'text' => 'Kurang menyukai pembicaraan tentang agama'],
                                ['id' => '115', 'text' => 'Ragu dan ingin memperoleh penjelasan lebih banyak tentang kaidah-kaidah agama'],
                                ['id' => '116', 'text' => 'Mengalami kesulitan dalam mendalami agama'],
                                ['id' => '117', 'text' => 'Tidak memiliki kecakapan dan/atau  sarana untuk melaksanakan ibadah agama'],
                                ['id' => '118', 'text' => 'Mengalami masalah karena membandingkan agama yang satu dengan yang lainnya'],
                                ['id' => '119', 'text' => 'Bermasalah karena anggota keluarga tidak seagama'],
                                ['id' => '120', 'text' => 'Belum menjalankan ibadah agama sebagaimana diharapkan'],
                                ['id' => '126', 'text' => 'Berkata dusta dan/atau  berbuat tidak jujur untuk tujuan-tujuan tertentu, seperti membohongi teman,berlaku curang dalam ujian'],
                                ['id' => '127', 'text' => 'Kurang mengetahui hal-hal yang menurut orang lain dianggap baik atau buruk,benar atau salah'],
                                ['id' => '128', 'text' => 'Tidak dapat mengambil keputusan tentang sesuatu karena kurang memahami baik-buruknya atau benar-salahnya sesuatu itu'],
                                ['id' => '129', 'text' => 'Merasa terganggu oleh kesalahan atau keburukan orang lain'],
                                ['id' => '130', 'text' => 'Tidak mengetahui cara-cara yang tepat untuk mengatakan kepada orang lain tentang sesuatu yang baik atau buruk,benar atau salah'],
                                ['id' => '131', 'text' => 'Khawatir atau merasa ketakutan akan akibat perbuatan melanggar kaidah-kaidah agama'],
                                ['id' => '132', 'text' => 'Kurang menyukai pembicaraan yang dilontarkan di tempat peribadatan'],
                                ['id' => '133', 'text' => 'Kurang taat dan/atau  kurang khusyuk dalam menjalankan ibadah agama'],
                                ['id' => '134', 'text' => 'Mengalami masalah karena memiliki pandangan dan/atau  sikap keagamaan yang cenderung fanatik atau berprasangka'],
                                ['id' => '135', 'text' => 'Meragukan manfaat ibadah dan/atau  upacara keagamaan'],
                                ['id' => '141', 'text' => 'Merasa terganggu karena melakukan sesuatu yang menjadikan orang lain tidak senang'],
                                ['id' => '142', 'text' => 'Terlanjur berbicara, bertindak atau bersikap yang tidak layak kepada orang tua  dan/atau orang lain'],
                                ['id' => '143', 'text' => 'Sering ditegur karena dianggap melakukan kesalahan, pelanggaran atau sesuatu yang tidak layak'],
                                ['id' => '144', 'text' => 'Mengalami masalah karena berbohong atau berkata tidak layak meskipun sebenarnya dengan maksud sekedar berolok-olok atau menimbulkan suasana gembira'],
                                ['id' => '145', 'text' => 'Tidak melakukan sesuatu yang sesungguhnya perlu dilakukan'],
                                ['id' => '146', 'text' => 'Takut dipersalahkan karena melanggar adat'],
                                ['id' => '147', 'text' => 'Mengalami masalah karena memiliki kebiasaan yang berbeda dari orang lain'],
                                ['id' => '148', 'text' => 'Terlanjur melakukan sesuatu perbuatan yang salah, atau melanggar nilai-nilai moral atau adat'],
                                ['id' => '149', 'text' => 'Merasa bersalah karena terpaksa mengingkari janji'],
                                ['id' => '150', 'text' => 'Mengalami persoalan karena berbeda pendapat tentang suatu aturan dalam adat']
                            ],
                            'HMM' => [
                                ['id' => '156', 'text' => 'Membutuhkan keterangan tentang persoalan seks, pacaran dan/atau perkawinan'],
                                ['id' => '157', 'text' => 'Mengalami masalah karena malu dan kurang terbuka dalam membicarakan soal seks, pacar dan/atau jodoh'],
                                ['id' => '158', 'text' => 'Khawatir tidak mendapatkan pacar atau jodoh yang baik/cocok'],
                                ['id' => '159', 'text' => 'Terlalu memikirkan tentang seks, percintaan, pacaran atau perkawinan'],
                                ['id' => '160', 'text' => 'Mengalami masalah karena dilarang atau merasa tidak patut berpacaran'],
                                ['id' => '171', 'text' => 'Kurang mendapat perhatian dari jenis kelamin lain atau pacar'],
                                ['id' => '172', 'text' => 'Mengalami masalah karena ingin mempunyai pacar'],
                                ['id' => '173', 'text' => 'Canggung dalam menghadapi jenis kelamin lain atau pacar'],
                                ['id' => '174', 'text' => 'Sukar mengendalikan dorongan seksual'],
                                ['id' => '175', 'text' => 'Mengalami masalah dalam memilih teman akrab dari jenis kelamin lain atau pacar'],
                                ['id' => '186', 'text' => 'Mengalami masalah karena takut atau sudah terlalu jauh berhubungan dengan jenis kelamin lain atau pacar'],
                                ['id' => '187', 'text' => 'Bertepuk sebelah tangan dengan kawan akrab atau pacar'],
                                ['id' => '188', 'text' => 'Takut ditinggalkan pacar atau patah hati, cemburu atau cinta segitiga'],
                                ['id' => '189', 'text' => 'Khawatir akan dipaksa kawin'],
                                ['id' => '190', 'text' => 'Mengalami masalah karena sering dan mudah jatuh cinta dan/atau  rindu kepada pacar']
                            ],
                            'WSG' => [
                                ['id' => '201', 'text' => 'Kekurangan waktu senggang, seprti waktu istirahat, waktu luang d sekolah ataupun dirumah, waktu libur untuk bersikap santai dan/atau melakukan kegiatan yang menyenangkan atau rekreasi'],
                                ['id' => '202', 'text' => 'Tidak diperkenankan atau kurang bebas dalam menggunakan waktu senggang yang tersedia untuk kegiatan yang disukai/diingini'],
                                ['id' => '203', 'text' => 'Mengalami masalah untuk mengikutikegiatan acara-acara gembira dan santai bersama kawan-kawan'],
                                ['id' => '204', 'text' => 'Tidak mempunyai kawan akrab untuk bersama-sama mengisi waktu senggang'],
                                ['id' => '205', 'text' => 'Mengalami masalah karena memikirkan atau membayangkan kesempatan waktu berlibur ditempat yang jauh, indah, tenang dan menyenangkan'],
                                ['id' => '216', 'text' => 'Tidak mengetahui cara menggunakan waktu senggang yang ada'],
                                ['id' => '217', 'text' => 'Kekurangan sarana, seperti biaya, kendaraan, televisi, buku-buku bacaan, dan lain-lain untuk memanfaatkan waktu senggang'],
                                ['id' => '218', 'text' => 'Mengalami masalah karena cara melaksanakan kegiatan atau acara yang kurang tepat dalam menggunakan waktu senggang'],
                                ['id' => '219', 'text' => 'Mengalami masalah dalam menggunakan waktu senggang karena tidak memiliki keterampilan tertentu, seperti bermain musik, olah raga, menari dan sebagainya'],
                                ['id' => '220', 'text' => 'Kurang berminat atau tidak ada hal yang menarik dalam memanfaatkan waktu senggang yang tersedia']
                            ],
                            'PDP' => [
                                ['id' => '011', 'text' => 'Terpaksa atau ragu-ragu memasuki sekolah ini'],
                                ['id' => '012', 'text' => 'Meragukan kemanfaatan memasuki sekolah ini'],
                                ['id' => '013', 'text' => 'Sukar menyesuaikan diri dengan keadaan sekolah'],
                                ['id' => '014', 'text' => 'Kurang meminati pelajaran atau jurusan atau program yang diikuti'],
                                ['id' => '015', 'text' => 'Khawatir tidak dapat menamatkan sekolah pada waktu yang direncanakan'],
                                ['id' => '026', 'text' => 'Sering tidak masuk sekolah'],
                                ['id' => '027', 'text' => 'Tugas-tugas pelajaran tidak selesai pada waktunya'],
                                ['id' => '028', 'text' => 'Sukar memahami penjelasan guru sewaktu pelajaran berlangsung'],
                                ['id' => '029', 'text' => 'Mengalami kesulitan dalam membuat catatan pelajaran'],
                                ['id' => '030', 'text' => 'Terpaksa mengikuti mata pelajaran yang tidak disukai'],
                                ['id' => '041', 'text' => 'Gelisah dan/atau melakukan kegiatan tidak menentu sewaktu pelajaran berlangsung, misalnya membuat coret-coretan dalam buku, cenderung mengganggu teman'],
                                ['id' => '042', 'text' => 'Sering malas belajar'],
                                ['id' => '043', 'text' => 'Kurang konsentrasi dalam mengikuti pelajaran'],
                                ['id' => '044', 'text' => 'Khawatir tugas-tugas pelajaran hasilnya kurang memuaskan atau rendah'],
                                ['id' => '045', 'text' => 'Mengalami masalah karena kemajuan atau hasil belajar hanya diberitahukan pada akhir catur wulan'],
                                ['id' => '051', 'text' => 'Hasil belajar atau nilai-nilai kurang memuaskan'],
                                ['id' => '052', 'text' => 'Mengalami masalah dalam belajar kelompok'],
                                ['id' => '053', 'text' => 'Kurang berminat dan/atau kurang mampu mempelajari buku pelajaran'],
                                ['id' => '054', 'text' => 'Takut dan/atau kurang mampu berbicara di dalam kelas dan/atau di luar kelas'],
                                ['id' => '055', 'text' => 'Mengalami kesulitan dalam ejaan, tata bahasa dan/atau perbendaharaan kata dalam Bahasa Indonesia.'],
                                ['id' => '056', 'text' => 'Mengalami masalah dalam menjawab pertanyaan ujian.'],
                                ['id' => '057', 'text' => 'Tidak mengetahui dan/atau tidak mampu menerapkan cara-cara belajar yang baik.'],
                                ['id' => '058', 'text' => 'Kekurangan waktu untuk belajar.'],
                                ['id' => '059', 'text' => 'Mengalami masalah dalam menyusun makalah, laporan atau karya tulis lainnya.'],
                                ['id' => '060', 'text' => 'Sukar mendapatkan buku pelajaran yang diperlukan.'],
                                ['id' => '066', 'text' => 'Mengalami kesulitan dalam pemahaman dan penggunaan istilah dan/atau Bahasa Inggris dan/atau bahasa asing lainnya.'],
                                ['id' => '067', 'text' => 'Kesulitan dalam membaca cepat dan/atau memahami isi buku pelajaran.'],
                                ['id' => '068', 'text' => 'Takut menghadapi ulangan/ujian.'],
                                ['id' => '069', 'text' => 'Khawatir memperoleh nilai rendah dalam ulangan/ujian ataupun tugas-tugas.'],
                                ['id' => '070', 'text' => 'Kesulitan dalam mengingat materi pelajaran.'],
                                ['id' => '071', 'text' => 'Seringkali tidak siap menghadapi ujian.'],
                                ['id' => '072', 'text' => 'Sarana belajar di sekolah kurang memadai.'],
                                ['id' => '073', 'text' => 'Orang tua kurang peduli dan/atau kurang membantu kegiatan belajar di sekolah dan/atau dirumah.'],
                                ['id' => '074', 'text' => 'Anggota keluarga kurang peduli dan/atau kurang membantu kegiatan belajar di sekolah dan/atau dirumah.'],
                                ['id' => '075', 'text' => 'Sarana belajar dirumah kurang memadai.'],
                                ['id' => '081', 'text' => 'Cara guru menyajikan pelajaran terlalu kaku dan/atau membosankan.'],
                                ['id' => '082', 'text' => 'Guru kurang bersahabat dan/atau membimbing siswa.'],
                                ['id' => '083', 'text' => 'Mengalami masalah karena disiplin yang diterapkan oleh guru.'],
                                ['id' => '084', 'text' => 'Dirugikan karena dalam menilai kemajuan atau keberhasilan siswa guru kurang objektif.'],
                                ['id' => '085', 'text' => 'Guru kurang memberikan tanggung jawab kepada siswa.'],
                                ['id' => '086', 'text' => 'Guru kurang adil atau pilih kasih.'],
                                ['id' => '087', 'text' => 'Ingin dekat dengan guru.'],
                                ['id' => '088', 'text' => 'Guru kurang memperhatikan kebutuhan dan/atau keadaan siswa.'],
                                ['id' => '089', 'text' => 'Mendapat perhatian khusus dari guru tertentu.'],
                                ['id' => '090', 'text' => 'Dalam memberikan pelajaran dan/atau berhubungan dengan siswa sikap dan/atau tindakan guru sering berubah-ubah sehingga membingungkan siswa.'],
                                ['id' => '101', 'text' => 'Khawatir tidak tersedia biaya untuk melanjutkan pekerjaan setamat sekolah ini.'],
                                ['id' => '102', 'text' => 'Tidak dapat mengambil keputusan tentang apakah akan mencari pekerjaan atau melanjutkan pelajaran setamat sekolah ini.'],
                                ['id' => '103', 'text' => 'Khawatir tuntutan dan proses pendidikan lanjutan setamat sekolah ini sangat berat.'],
                                ['id' => '104', 'text' => 'Terdapat pertentangan pendapat dengan orang tua dan/atau anggota keluarga lain tentang rencana melanjutkan pelajaran setamat sekolah ini.'],
                                ['id' => '105', 'text' => 'Khawatir tidak mampu bersaing dalam upaya memasuki pendidikan lanjutan setamat sekolah ini.']
                            ],
                            'KHK' => [
                                ['id' => '161', 'text' => 'Bermasalah karena kedua orang tua hidup berpisah atau bercerai.'],
                                ['id' => '162', 'text' => 'Mengalami masalah karena ayah dan/atau ibu kandung telah meninggal.'],
                                ['id' => '163', 'text' => 'Mengkawatirkan kondisi kesehatan anggota keluarga.'],
                                ['id' => '164', 'text' => 'Mengalami masalah karena keadaan dan perlengkapan tempat tinggal dan/atau rumah orang tua kurang memadai.'],
                                ['id' => '165', 'text' => 'Mengkawatirkan kondisi orang tua yang bekerja terlalu berat.'],
                                ['id' => '176', 'text' => 'Keluarga mengeluh tentang keadaan keuangan.'],
                                ['id' => '177', 'text' => 'Mengkawatirkan keadaan orang tua yang bertempat tinggal jauh.'],
                                ['id' => '178', 'text' => 'Bermasalah karena ibu atau bapak akan kawin lagi.'],
                                ['id' => '179', 'text' => 'Khawatir tidak mampu memenuhi tuntutan atau harapan orang tua atau anggota keluarga lain.'],
                                ['id' => '180', 'text' => 'Membayangkan dan berpikir-pikir seandainya menjadi anak dari keluarga lain.'],
                                ['id' => '191', 'text' => 'Kurang mendapat perhatian dan pengertian dari orang tua dan/atau anggota keluarga.'],
                                ['id' => '192', 'text' => 'Mengalami kesulitan dengan bapak atau ibu tiri.'],
                                ['id' => '193', 'text' => 'Diperlakukan tidak adil oleh orang tua atau oleh anggota keluarga lainnya.'],
                                ['id' => '194', 'text' => 'Khawatir akan terjadinya pertentangan atau percekcokan dalam keluarga.'],
                                ['id' => '195', 'text' => 'Hubungan dengan orang tua dan anggota keluarga kurang hangat, kurang harmonis dan/atau kurang menggembirakan.'],
                                ['id' => '206', 'text' => 'Mengalami masalah karena menjadi anak tunggal, anak sulung, anak bungsu, satu-satunya anak laki-laki atau satu-satunya anak perempuan.'],
                                ['id' => '207', 'text' => 'Hubungan kurang harmonis dengan kakak atau adik atau dengan anggota keluarga lainnya.'],
                                ['id' => '208', 'text' => 'Orang tua atau keluarga anggota lainnya terlalu berkuasa atau kurang memberi kebebasan.'],
                                ['id' => '209', 'text' => 'Dicurigai oleh orang tua atau anggota keluarga lain.'],
                                ['id' => '210', 'text' => 'Bermasalah karena di rumah orang tua tinggal orang atau anggota keluarga lain.'],
                                ['id' => '221', 'text' => 'Tinggal di lingkungan keluarga atau tetangga yang kurang menyenangkan.'],
                                ['id' => '222', 'text' => 'Tidak sependapat dengan orang tua atau anggota keluarga tentang sesuatu yang direncanakan.'],
                                ['id' => '223', 'text' => 'Orang tua kurang senang kawan-kawan datang ke rumah.'],
                                ['id' => '224', 'text' => 'Mengalami masalah karena rindu dan ingin bertemu dengan orang tua dan/atau anggota keluarga lainnya.'],
                                ['id' => '225', 'text' => 'Tidak betah dan ingin meninggalkan rumah karena keadaannya sangat tidak menyenangkan.']
                            ]
        ];
    }
    private function getMasterProblems()
    {
        // Silakan lengkapi data ini sesuai dengan data soal lengkap Anda
        // Format: 'ID' => 'Teks Masalah'
        return [
            '001' => 'Badan terlalu kurus atau terlalu gemuk',
            '002' => 'Terdapat gangguan pada penglihatan atau pendengaran',
            // ... masukkan semua ID soal dan teksnya di sini ...
            // Contoh tambahan agar tidak error jika ID tidak ada
            '031' => 'Mudah tersinggung atau sakit hati',
        ];
    }

    /**
     * Halaman Instruksi Awal
     */
    public function index()
    {
        // 1. RESET SESSION: Penting agar bisa retake (mengulang tes)
        // Hapus data pilihan masalah dari tes sebelumnya/setengah jalan
        session()->forget(['aum_step1_ids']);

        $user = Auth::user();

        // 2. (Opsional) Ambil hasil tes TERBARU untuk dikirim ke view
        // Ini berguna jika di halaman depan AUM Anda ingin menampilkan info: "Anda terakhir tes pada tanggal sekian"
        $result = AumResult::where('user_id', $user->id)->latest()->first();

        // 3. Tampilkan halaman depan (Landing Page AUM)
        return view('aum', compact('user', 'result'));
    }

    /**
     * Halaman Langkah 1 (Form Centang Masalah)
     */
    //public function form()
   // {
        //$user = Auth::user();
        //return view('aum_form', compact('user'));
    //}

    public function form()
    {
        $user = Auth::user();

        // 1. Panggil data dari fungsi private di atas
        $categories = $this->getAllQuestions();

        // 2. Kirim ke view menggunakan compact
        return view('aum_form', compact('user', 'categories'));
    }

    /**
     * Proses Simpan Langkah 1
     */
    public function storeStep1(Request $request)
    {
        $request->validate([
            'problems' => 'required|array|min:1',
        ]);

        session(['aum_step1_ids' => $request->input('problems', [])]);

        return redirect()->route('aum.step2');
    }

    /**
     * Halaman Langkah 2
     */
    public function step2()
    {
        $user = Auth::user();
        $step1Ids = session('aum_step1_ids', []);

        if (empty($step1Ids)) {
            return redirect()->route('aum.form')->with('error', 'Silakan isi Langkah 1 terlebih dahulu.');
        }

        // Ambil lagi data master untuk mencocokkan ID
        $allCategories = $this->getAllQuestions();

        // Ratakan array (Flatten) agar mudah dicari ID-nya
        $flatQuestions = [];
        foreach ($allCategories as $cat => $items) {
            foreach ($items as $item) {
                $flatQuestions[$item['id']] = $item['text'];
            }
        }

        // Cari teks berdasarkan ID yang dipilih user
        $selectedProblems = [];
        foreach ($step1Ids as $id) {
            $text = $flatQuestions[$id] ?? "Masalah nomor $id (Teks tidak ditemukan)";
            $selectedProblems[] = [
                'id' => $id,
                'text' => $text
            ];
        }

        return view('aum_step2', compact('selectedProblems', 'user'));
    }
    public function finish(Request $request)
    {
        $user = Auth::user();

        // --- SKENARIO 1: PROSES SIMPAN (Method POST dari Step 2) ---
        if ($request->isMethod('post')) {

            // 1. Ambil Data
            $step1Ids = session('aum_step1_ids', []);
            $heavyProblemDesc = $request->input('heavy_problem_desc');

            $consultationData = [
                'ingin_bantuan'    => $request->input('q_c'),
                'ingin_bicara'     => $request->input('q_a'),
                'mitra_bicara'     => $request->input('q_b', []), // Array checkbox
                'waktu_konsultasi' => $request->input('q_d')
            ];

            // 2. Simpan ke Database (Create History Baru)
            AumResult::create([
                'user_id'           => Auth::id(),
                'selected_problems' => $step1Ids, // Pastikan Model dicast 'array'
                'heavy_problems'    => ['description' => $heavyProblemDesc], // Simpan sbg JSON
                'consultation_data' => $consultationData // Simpan sbg JSON
            ]);

            // 3. Bersihkan Session
            session()->forget('aum_step1_ids');

            // 4. Redirect ke DIRI SENDIRI (GET) untuk menampilkan hasil
            // PERBAIKAN UTAMA: Jangan redirect ke index!
            return redirect()->route('aum.finish')->with('success', 'Tes AUM berhasil diselesaikan!');
        }

        // --- SKENARIO 2: TAMPILKAN HASIL (Method GET) ---
        else {
            // Ambil data hasil tes TERBARU
            $result = AumResult::where('user_id', $user->id)->latest()->first();

            // Jika belum ada data, lempar ke instruksi
            if (!$result) {
                return redirect()->route('aum.index');
            }

            // Tampilkan View Hasil
            return view('aum_finish', compact('user', 'result'));
        }
    }
}
