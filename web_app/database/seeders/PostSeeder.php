<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Panduan Transformasi Digital Sekolah di Era Kurikulum Merdeka (2026)',
                'slug' => 'panduan-transformasi-digital-sekolah-kurikulum-merdeka',
                'excerpt' => 'Menyusul adaptasi penuh Kurikulum Merdeka, yayasan pendidikan di Indonesia dihadapkan pada urgensi digitalisasi sistem secara komprehensif.',
                'image' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=2070&auto=format&fit=crop',
                'category' => 'Edukasi',
                'status' => 'published',
                'published_at' => now()->subDays(2),
                'content' => '
                    <h2>Transisi Kurikulum, Tantangan Administratif bagi Guru</h2>
                    <p>Hingga tahun ajaran 2025/2026, data Kemendikbudristek menunjukkan lebih dari 80% sekolah di Indonesia telah mengadopsi <strong>Kurikulum Merdeka</strong>. Meskipun membawa angin segar bagi fleksibilitas pembelajaran dan porsi penekanan pada Projek Penguatan Profil Pelajar Pancasila (P5), kurikulum ini juga membawa beban administratif baru bagi tenaga pendidik.</p>
                    <p>Rapor tak lagi sekadar angka, namun memerlukan deskripsi formatif yang rinci, evaluasi projek P5 yang observasional, hingga penyesuaian asesmen diagnostik.</p>
                    
                    <h3>Mengapa Yayasan Harus Beralih ke Platform Terpusat?</h3>
                    <p>Sekolah yang masih mengandalkan kertas atau program hamparan tunggal (spreadsheet terpisah antar guru) perlahan menemui jalan buntu. Kesalahan rekapitulasi nilai dan waktu terbuang untuk administrasi menyebabkan <em>burnout</em> pada guru. Platform seperti <strong>Jetschool</strong> mengintegrasikan hal-hal sentral ini:</p>
                    <ul>
                        <li><strong>Otomatisasi Rapor Kurikulum Merdeka</strong>: Sistem langsung melahirkan deskripsi kompetensi tiap bab/Capaian Pembelajaran (CP).</li>
                        <li><strong>Bank Soal dan Asesmen Online terintegrasi CBT</strong>.</li>
                        <li><strong>Monitoring Akademik & Kedisiplinan Siswa real-time</strong>.</li>
                    </ul>
                    <blockquote>"Guru didorong untuk merdeka dalam mendidik, namun sistem administrasi yayasanlah yang bertugas memerdekakan mereka dari tumpukan kertas pendataan." — Jetschool Insights.</blockquote>
                    <p>Langkah kecil memulai Sistem Informasi Manajemen (SIM) Sekolah adalah awal menuju arsitektur pendidikan berbasis data, membangun ketahanan instansi di tengah era EdTech.</p>
                '
            ],
            [
                'title' => 'Digitalisasi Keuangan Sekolah: Jurus Jitu Naikkan Collection Rate SPP hingga 98%',
                'slug' => 'digitalisasi-keuangan-sekolah-naikkan-spp',
                'excerpt' => 'Macetnya pembayaran SPP dan iuran komite sekolah kerap membuat cashflow yayasan tersendat. Simak bagaimana sistem tagihan online menyelesaikan masalah ini.',
                'image' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?q=80&w=2070&auto=format&fit=crop',
                'category' => 'Manajemen',
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'content' => '
                    <h2>Masalah Klasik Cashflow Yayasan Pendidikan</h2>
                    <p>Sekolah swasta dan yayasan Islam/Pesantren sangat mengandalkan SPP (Sumbangan Pembinaan Pendidikan) maupun iuran donatur untuk menopang operasional harian. Masalahnya, seringkali tunggakan terjadi bukan karena orang tua tidak mau atau tidak mampu membayar, melainkan karena mereka <strong>LUPA</strong> atau proses membayarnya merepotkan.</p>
                    
                    <h3>Urgensi Pembayaran Online (Virtual Account & QRIS)</h3>
                    <p>Tata usaha bendahara sekolah tidak lagi efektif jika hanya duduk menunggu orang tua datang membawa segepok uang tunai atau mentransfer lalu mengirimkan foto struk pudar ke WhatsApp. Cacat fatal metode manual ini adalah keharusan mutasi manual, yang rawan <em>human error</em>.</p>
                    <p>Integrasi <em>Payment Gateway</em> seperti yang dilakukan dalam layanan ERP <strong>Jetschool</strong> mengubah alur itu 180 derajat:</p>
                    <ul>
                        <li><strong>Notifikasi Otomatis</strong>: Sistem mengirim Surat Tagihan (Invoice) terdigitalisasi ke aplikasi orang tua atau via Bot WhatsApp mendekati tanggal jatuh tempo.</li>
                        <li><strong>Pembayaran 24/7</strong>: Lewat Virtual Account (BCA, Mandiri, BNI, BRI) atau e-Wallet (OVO, Dana), orang tua bisa setor uang gedung pad jam 2 pagi tanpa harus konfirmasi manual. Lunas seketika.</li>
                        <li><strong>Laporan Keuangan Instan bagi Yayasan</strong>: Taksiran <em>cash flow</em>, sisa piutang kelas, hingga rekapitulasi pendapatan Yayasan dapat dipantau dari Dashboard secara real-time.</li>
                    </ul>
                    <p>Statistik pengguna sistem tagihan pintar membuktikan tingkat pengumpulan iuran (<em>Collection Rate</em>) meningkat dari rata-rata 60-70% menembus angka lebih dari 95% hanya dalam kurun waktu satu semester. Pastikan yayasan Anda sudah bersiap di kuartal ini!</p>
                '
            ],
            [
                'title' => 'Mengawasi Hafalan Al-Quran & Ekosistem Boarding School Lewat Ponsel Pintar',
                'slug' => 'mengawasi-hafalan-quran-ekosistem-boarding-school-ponsel',
                'excerpt' => 'Orang tua semakin kritis menitipkan anaknya di Asrama (Boarding). Transparansi data kegiatan harian dan kemajuan ibadah menjadi nilai tawar eksklusif pesantren modern.',
                'image' => 'https://images.unsplash.com/photo-1629853314088-251f2e1dfa98?q=80&w=2070&auto=format&fit=crop',
                'category' => 'Teknologi',
                'status' => 'published',
                'published_at' => now()->subDays(10),
                'content' => '
                    <h2>Era Keterbukaan Boarding School & Pesantren Modern</h2>
                    <p>Kepercayaan adalah komoditas paling berharga di institusi berbasis asrama. Fenomena santri/siswa jauh dari rumah membuat orang tua senantiasa dirundung rindu dan kekhawatiran. Pesantren modern unggul bukan sekadar karena gedungnya megah, melainkan transparansi laporan perwaliannya yang konsisten.</p>
                    
                    <h3>Inovasi Sistem Musyrif / Pembina Asrama</h3>
                    <p>Aplikasi Smart School saat ini tak lagi melulu soal nilai UTS dan UAS. Modul unggulan yang menggaet wali murid adalah <strong>Jejak Santri atau Manajemen Boarding</strong>. Apa saja fitur krusial yang harus diadopsi asrama modern?</p>
                    <ul>
                        <li><strong>Log Ibadah dan Tahfidz</strong>: Ustadz/Musyrif dapat mengisi data tilawah, hafalan surah/juz harian dari ponsel. Aplikasi seketika memberi laporan kepada wali murid secara langsung.</li>
                        <li><strong>Poin Pelanggaran Asrama & Prestasi (E-BK / Kesiswaan)</strong>: Mulai dari keterlambatan kajian subuh hingga prestasi juara MTQ—semua tercatat detail dan membentuk "Karakter Kurva" anak.</li>
                        <li><strong>Tele-Perizinan</strong>: Izin pulang, sakit, atau penjengukan wali, tak ada lagi surat fisik lecek yang hilang diculik angin. Digital persetujuan mutlak aman!</li>
                    </ul>
                    <p><strong>Jetschool Super Warga Asrama</strong> menjadi pionir yang menggabungkan kebutuhan akademik, kedisiplinan dan muatan agamis-spesifik ke dalam satu atap aplikasi <em>All in One</em>. Transformasi ini berhasil meredam komplain orang tua hingga 80% karena informasi jauh lebih proaktif dihantarkan pad layar ponsel wali.</p>
                '
            ],
            [
                'title' => 'Strategi Sukses PPDB Online 2026: Jangan Biarkan Calon Siswa Kabur!',
                'slug' => 'strategi-sukses-ppdb-online-2026',
                'excerpt' => 'Penerimaan Peserta Didik Baru (PPDB) adalah ujung tombak kelangsungan hidup yayasan. Simak bagaimana formulir cerdas mengurangi drop-out pendaftaran.',
                'image' => 'https://images.unsplash.com/photo-1543269865-cbf427effbad?q=80&w=2070&auto=format&fit=crop',
                'category' => 'Manajemen',
                'status' => 'published',
                'published_at' => now()->subDays(15),
                'content' => '
                    <h2>Kesan Pertama Mendaftar Sangatlah Penting</h2>
                    <p>Di era ketika calon walimurid sangat rasional dan gemar membandingkan fasilitas, proses Pendaftaran Penerimaan Didik Baru (PPDB) yang berbelit-belit menjanjikan satu hal: mereka akan berpaling mencari sekolah lain. Sistem Google Form tak selamanya cukup, apalagi saat rekap bukti transfer mulai tercecer atau format Excel rusak.</p>
                    
                    <h3>3 Poin Penting Dalam Ekosistem PPDB Modern</h3>
                    <p>Agar proses pengumpulan <em>Leads</em> dan pendaftar tidak tiris, yayasan modern perlu beralih dari sekadar form isian dasar ke <strong>Pusat PPDB Terintegrasi</strong>:</p>
                    <ol>
                        <li><strong>Pengisian Berjenjang (Wizard) yang Intuitif</strong>: Memecah biodata siswa, alamat, nilai rapor, dan unggah berkas PDF/Foto ke tab yang rapi terstruktur. Aplikasi mendaftar Jetschool bahkan mendukung adaptasi seluler dengan antarmuka halus.</li>
                        <li><strong>E-Brosur dan Kalkulator Biaya Sekolah</strong>: Sebelum submit, ayah/bunda sudah bisa mengalkulasi dan memantau biaya formulir serta langsung memproses pembayaran lewat <em>QRIS / VA</em> yang digenerate sistem. Tak menunggu konfirmasi manual dari panitia!</li>
                        <li><strong>Manajemen Funnel oleh Panitia (Afiliator Sekolah)</strong>: Kepala yayasan bisa melacak berapa yang registrasi akun, pendaftar yang belum setor berkas, hingga wawancara/jadwal test seleksi <strong>Computer Based Test (CBT)</strong> langsung di modul yang sama!</li>
                    </ol>
                    <p>Platform terintegrasi PPDB seperti JetSchool mengubah pos kepanitiaan dari "perekap absen berkas" menjadi "marketer sekolah". Dengan <em>affiliate marketing feature</em> dan database tertata, tahun ajaran baru selalu dimulai dengan optimis.</p>
                '
            ]
        ];

        foreach ($articles as $article) {
            \App\Models\Post::updateOrCreate(
                ['slug' => $article['slug']],
                $article
            );
        }
    }
}
