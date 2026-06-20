<template>
  <div class="legal-page">
    <div class="container">
      <header class="legal-header">
        <h1>Kebijakan Privasi</h1>
        <p class="updated">Terakhir diperbarui: 12 Februari 2026</p>
      </header>

      <div class="legal-content">
        <section>
          <h2>1. Pendahuluan</h2>
          <p>PT Jetschool Academy Indonesia ("kami") menghargai privasi Anda. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi pribadi Anda saat menggunakan layanan Jetschool.</p>
        </section>

        <section>
          <h2>2. Data yang Kami Kumpulkan</h2>
          <p>Kami mengumpulkan informasi yang Anda berikan secara langsung, seperti:</p>
          <ul>
            <li>Informasi Akun: Nama, alamat email, nomor telepon, dan data sekolah.</li>
            <li>Data Akademik: Nilai siswa, absensi, dan data kurikulum yang diunggah ke platform.</li>
            <li>Data Penggunaan: Log aktivitas, alamat IP, dan informasi perangkat.</li>
          </ul>
        </section>

        <section>
          <h2>3. Penggunaan Data</h2>
          <p>Kami menggunakan data Anda untuk:</p>
          <ul>
            <li>Menyediakan dan memelihara layanan Jetschool.</li>
            <li>Memproses pembayaran dan transaksi.</li>
            <li>Mengirimkan pembaruan sistem dan pemberitahuan penting.</li>
            <li>Meningkatkan keamanan dan mencegah penyalahgunaan.</li>
          </ul>
        </section>

        <section>
          <h2>4. Keamanan Data</h2>
          <p>Kami menerapkan standar keamanan industri, termasuk enkripsi SSL dan infrastruktur Google Cloud yang aman, untuk melindungi data Anda dari akses yang tidak sah.</p>
        </section>

        <section>
          <h2>5. Hak Anda</h2>
          <p>Anda memiliki hak untuk mengakses, memperbaiki, atau menghapus data pribadi Anda. Silakan hubungi tim dukungan kami jika Anda memiliki pertanyaan atau permintaan terkait data Anda.</p>
        </section>

        <section>
          <h2>6. Kontak</h2>
          <p>Jika ada pertanyaan mengenai Kebijakan Privasi ini, silakan hubungi kami di <a href="mailto:support@jetschool.id">support@jetschool.id</a>.</p>
        </section>
      </div>
    </div>
  </div>
</template>

<style scoped>
.legal-page {
  padding: 120px 0 80px;
  background: var(--page);
  min-height: 100vh;
}

.legal-header {
  text-align: center;
  margin-bottom: 60px;
}

h1 {
  font-size: 2.5rem;
  font-weight: 700;
  color: var(--ink);
  margin-bottom: 12px;
}

.updated {
  font-size: 1rem;
  color: var(--ink-muted);
}

.legal-content {
  max-width: 800px;
  margin: 0 auto;
  background: white;
  padding: 48px;
  border-radius: var(--r-xl);
  box-shadow: var(--sh-sm);
  border: 1px solid var(--border);
}

section {
  margin-bottom: 40px;
}

section:last-child {
  margin-bottom: 0;
}

h2 {
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--ink);
  margin-bottom: 16px;
}

p, li {
  font-size: 1rem;
  line-height: 1.7;
  color: var(--ink-muted);
  margin-bottom: 16px;
}

ul {
  padding-left: 20px;
  margin-bottom: 16px;
}

li {
  margin-bottom: 8px;
}

a {
  color: var(--indigo);
  text-decoration: underline;
}

@media (max-width: 768px) {
  .legal-content {
    padding: 24px;
  }
}
</style>
