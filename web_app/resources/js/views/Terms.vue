<template>
  <div class="legal-page">
    <div class="container">
      <header class="legal-header">
        <h1>Syarat & Ketentuan</h1>
        <p class="updated">Terakhir diperbarui: 12 Februari 2026</p>
      </header>

      <div class="legal-content">
        <section>
          <h2>1. Penerimaan Syarat</h2>
          <p>Dengan mengakses atau menggunakan layanan Jetschool, Anda setuju untuk terikat oleh Syarat dan Ketentuan ini. Jika Anda tidak setuju, harap jangan gunakan layanan kami.</p>
        </section>

        <section>
          <h2>2. Lisensi Penggunaan</h2>
          <p>Jetschool memberikan Anda lisensi terbatas, non-eksklusif, dan tidak dapat dipindahtangankan untuk menggunakan platform kami semata-mata untuk tujuan manajemen pendidikan internal institusi Anda.</p>
        </section>

        <section>
          <h2>3. Akun Pengguna</h2>
          <p>Anda bertanggung jawab untuk menjaga kerahasiaan informasi login akun Anda. Segala aktivitas yang terjadi di bawah akun Anda adalah tanggung jawab Anda sepenuhnya.</p>
        </section>

        <section>
          <h2>4. Konten Pengguna</h2>
          <p>Anda memegang hak penuh atas data yang Anda unggah ke Jetschool. Namun, Anda memberikan kami izin untuk menyimpan, memproses, dan menampilkan data tersebut semata-mata untuk tujuan penyediaan layanan.</p>
        </section>

        <section>
          <h2>5. Pembatasan</h2>
          <p>Anda tidak diperbolehkan untuk:</p>
          <ul>
            <li>Menyalin, memodifikasi, atau mendistribusikan ulang bagian mana pun dari layanan kami.</li>
            <li>Menggunakan layanan untuk tujuan ilegal atau melanggar hak pihak lain.</li>
            <li>Mencoba meretas atau mengganggu integritas sistem keamanan kami.</li>
          </ul>
        </section>

        <section>
          <h2>6. Perubahan Layanan</h2>
          <p>Kami berhak untuk mengubah, menangguhkan, atau menghentikan layanan kapan saja dengan atau tanpa pemberitahuan, meskipun kami akan berusaha memberitahukan perubahan signifikan sebelumnya.</p>
        </section>

        <section>
          <h2>7. Kontak</h2>
          <p>Jika Anda memiliki pertanyaan tentang Syarat & Ketentuan ini, silakan hubungi kami di <a href="mailto:legal@jetschool.id">legal@jetschool.id</a>.</p>
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
