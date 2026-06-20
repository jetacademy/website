<template>
  <div class="features-container">
    <section class="features-hero">
      <h1>Modul Lengkap & Terintegrasi</h1>
      <p>Satu sistem untuk seluruh kebutuhan operasional sekolah Anda.</p>
    </section>

    <div class="module-grid">
      <div v-for="module in modules" :key="module.title" class="module-card">
        <div class="icon-wrapper">
          <!-- Placeholder for icon -->
          <span class="icon">✨</span>
        </div>
        <h3>{{ module.title }}</h3>
        <p>{{ module.description }}</p>
        <ul v-if="module.features.length">
            <li v-for="feature in module.features" :key="feature">{{ feature }}</li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script setup>
const modules = [
  {
    title: 'Manajemen Data Master',
    description: 'Pusat data yayasan, sekolah, kurikulum, dan tahun ajaran yang terstruktur rapi.',
    features: ['Data Yayasan & Sekolah', 'Kurikulum & Mata Pelajaran', 'Manajemen Kelas']
  },
  {
    title: 'Kepegawaian (PTK)',
    description: 'Kelola data guru dan tenaga kependidikan dengan mudah dan efisien.',
    features: ['Biodata Lengkap', 'Absensi Digital', 'Riwayat Pelatihan']
  },
  {
    title: 'Kemuridan',
    description: 'Database lengkap siswa dari pendaftaran hingga alumni.',
    features: ['Identitas Siswa', 'Mutasi Kelas', 'Arsip Data']
  },
  {
    title: 'Bimbingan Konseling',
    description: 'Pantau perkembangan karakter dan psikologis siswa secara intensif.',
    features: ['Catatan Prestasi', 'Pencatatan Pelanggaran', 'Jadwal Konseling']
  },
  {
    title: 'SOS Bullying',
    description: 'Fitur kritis untuk menciptakan lingkungan sekolah yang aman dan nyaman.',
    features: ['Tombol SOS', 'Pelaporan Anonim', 'Tracking Penanganan']
  },
  {
    title: 'Akademik',
    description: 'Sistem penilaian dan rapor digital yang fleksibel.',
    features: ['Penilaian Harian', 'Rapor Digital', 'Nilai Sikap & Karakter']
  },
  {
    title: 'Keuangan',
    description: 'Transparansi dan kemudahan pengelolaan keuangan sekolah.',
    features: ['Tagihan SPP', 'Pembayaran Online', 'Laporan Keuangan']
  },
  {
    title: 'Ujian Online (CBT)',
    description: 'Platform ujian berbasis komputer yang aman dan kaya fitur.',
    features: ['Bank Soal', 'Timer Ujian', 'Mode Layar Penuh']
  },
  {
    title: 'LMS (Learning Management)',
    description: 'Platform pembelajaran digital untuk materi dan tugas.',
    features: ['Materi Digital', 'Tugas & Diskusi', 'Progres Belajar']
  },
  {
    title: 'SPMB',
    description: 'Sistem Penerimaan Murid Baru yang efisien dan paperless.',
    features: ['Pendaftaran Online', 'Seleksi Otomatis', 'Pengumuman']
  },
  {
    title: 'AI Tutor',
    description: 'Kecerdasan buatan untuk membantu proses belajar mandiri siswa.',
    features: ['Tanya Jawab Materi', 'Latihan Adaptif', 'Rekomendasi Belajar']
  }
];
</script>

<style scoped>
.features-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 80px 20px;
}

.features-hero {
  text-align: center;
  margin-bottom: 60px;
}

.features-hero h1 {
  font-size: 3rem;
  margin-bottom: 20px;
  color: #1e293b;
}

.features-hero p {
  font-size: 1.25rem;
  color: #64748b;
}

.module-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
  gap: 30px;
}

.module-card {
  background: white;
  border-radius: 12px;
  padding: 30px;
  box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05);
  transition: transform 0.2s;
  border: 1px solid #e2e8f0;
}

.module-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
}

.icon-wrapper {
  margin-bottom: 20px;
  background-color: #eff6ff;
  width: 50px;
  height: 50px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.icon {
  font-size: 1.5rem;
}

.module-card h3 {
  font-size: 1.5rem;
  margin-bottom: 10px;
  color: #1e293b;
}

.module-card p {
  color: #64748b;
  margin-bottom: 20px;
  line-height: 1.5;
}

.module-card ul {
  list-style-type: none;
  padding: 0;
  border-top: 1px solid #f1f5f9;
  padding-top: 15px;
}

.module-card li {
  color: #475569;
  margin-bottom: 8px;
  font-size: 0.9rem;
  display: flex;
  align-items: center;
}

.module-card li::before {
  content: "•";
  color: #3b82f6;
  margin-right: 10px;
  font-size: 1.2rem;
}
</style>
