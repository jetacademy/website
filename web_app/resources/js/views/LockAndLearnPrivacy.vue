<script setup>
import { onMounted } from 'vue';

onMounted(() => {
  document.title = "Kebijakan Privasi Lock & Learn | Jetschool";
});
</script>

<template>
  <div class="legal-page">
    <div class="container overflow-hidden">
      <!-- Decorative Element -->
      <div class="decorative-blob"></div>

      <header class="legal-header">
        <div class="overline">Produk Ekosistem</div>
        <h1>Kebijakan Privasi Lock & Learn</h1>
        <p class="updated">Terakhir Diperbarui: 21 April 2026</p>
      </header>

      <div class="legal-grid">
        <!-- Sidebar Navigation (Optional, but adds to the premium feel) -->
        <aside class="legal-sidebar">
          <nav class="sticky-nav">
            <a href="#umum" class="nav-item">Informasi Umum</a>
            <a href="#koleksi" class="nav-item">Data yang Dikumpulkan</a>
            <a href="#izin" class="nav-item">Izin Sensitif</a>
            <a href="#keamanan" class="nav-item">Penyimpanan & Keamanan</a>
            <a href="#pihak-ketiga" class="nav-item">Pihak Ketiga</a>
            <a href="#kontak" class="nav-item">Hubungi Kami</a>
          </nav>
        </aside>

        <!-- Main Content -->
        <main class="legal-content">
          <section id="umum">
            <div class="section-number">01</div>
            <h2>Informasi Umum</h2>
            <p>Selamat datang di <strong>Lock & Learn</strong>. Privasi Anda sangat penting bagi kami. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi Anda saat Anda menggunakan aplikasi kami.</p>
            <p>Aplikasi <strong>Lock & Learn</strong> ("Aplikasi") dikembangkan oleh <strong>PT Jetschool Academy Indonesia</strong> untuk membantu pengguna meningkatkan produktivitas dan fokus dengan membatasi akses ke aplikasi tertentu selama waktu belajar.</p>
          </section>

          <section id="koleksi">
            <div class="section-number">02</div>
            <h2>Informasi yang Kami Kumpulkan</h2>
            <p>Kami berkomitmen untuk hanya mengumpulkan data yang benar-benar diperlukan untuk fungsi inti aplikasi.</p>
            <ul class="custom-list">
              <li>
                <strong>Daftar Aplikasi Terinstal:</strong> 
                <span>Kami mengakses daftar aplikasi yang terinstal di perangkat agar Anda dapat memilih aplikasi mana yang ingin dikunci. Data ini disimpan secara lokal di perangkat Anda.</span>
              </li>
              <li>
                <strong>Data Penggunaan Aplikasi:</strong> 
                <span>Kami memantau aplikasi mana yang sedang berjalan di latar depan (foreground) untuk menentukan apakah aplikasi tersebut termasuk dalam daftar yang harus dikunci.</span>
              </li>
            </ul>
          </section>

          <section id="izin">
            <div class="section-number">03</div>
            <h2>Izin Sensitif dan Penggunaannya</h2>
            <p>Aplikasi kami memerlukan izin khusus agar dapat berfungsi. Kami menjamin izin ini hanya digunakan untuk tujuan produktivitas:</p>
            <div class="permission-cards">
              <div class="p-card">
                <div class="p-icon">📊</div>
                <h4>Akses Data Penggunaan</h4>
                <code>PACKAGE_USAGE_STATS</code>
                <p>Digunakan untuk mendeteksi aplikasi apa yang sedang dibuka sehingga kami dapat mengaktifkan layar kunci jika aplikasi tersebut dilarang.</p>
              </div>
              <div class="p-card">
                <div class="p-icon">🖥️</div>
                <h4>Izin Overlay</h4>
                <code>SYSTEM_ALERT_WINDOW</code>
                <p>Digunakan untuk menampilkan layar kunci di atas aplikasi lain yang sedang dibatasi.</p>
              </div>
              <div class="p-card">
                <div class="p-icon">⚡</div>
                <h4>Layanan Latar Depan</h4>
                <code>FOREGROUND_SERVICE</code>
                <p>Digunakan agar aplikasi tetap dapat memantau jadwal penguncian meskipun aplikasi tidak dibuka secara manual.</p>
              </div>
              <div class="p-card">
                <div class="p-icon">🔍</div>
                <h4>Lihat Semua Paket</h4>
                <code>QUERY_ALL_PACKAGES</code>
                <p>Diperlukan agar Anda dapat memilih aplikasi mana saja yang ingin dikunci dari daftar lengkap aplikasi di ponsel.</p>
              </div>
            </div>
          </section>

          <section id="keamanan">
            <div class="section-number">04</div>
            <h2>Penyimpanan Data & Keamanan</h2>
            <div class="highlight-box">
              <div class="hb-icon">🛡️</div>
              <p>Semua data pengaturan dan statistik pribadi disimpan <strong>secara lokal</strong> di perangkat Anda. Kami tidak memiliki server pusat, sehingga data Anda tidak pernah meninggalkan perangkat Anda.</p>
            </div>
          </section>

          <section id="pihak-ketiga">
            <div class="section-number">05</div>
            <h2>Pihak Ketiga</h2>
            <p>Aplikasi ini tidak menjual atau membagikan informasi pribadi Anda kepada pihak ketiga manapun.</p>
          </section>

          <section id="kontak">
            <div class="section-number">06</div>
            <h2>Hubungi Kami</h2>
            <p>Jika Anda memiliki pertanyaan tentang Kebijakan Privasi ini, silakan hubungi kami di:</p>
            <div class="contact-card">
              <div class="cc-item">
                <span class="cc-label">Email</span>
                <a href="mailto:jetschool.id@gmail.com" class="cc-value">jetschool.id@gmail.com</a>
              </div>
              <div class="cc-item">
                <span class="cc-label">Website</span>
                <a href="https://jetschool.id" target="_blank" class="cc-value">jetschool.id</a>
              </div>
              <div class="cc-item">
                <span class="cc-label">Developer</span>
                <span class="cc-value">PT Jetschool Academy Indonesia</span>
              </div>
            </div>
          </section>
        </main>
      </div>
    </div>
  </div>
</template>

<style scoped>
.legal-page {
  padding: 180px 0 120px;
  background: var(--page);
  min-height: 100vh;
  position: relative;
  overflow: hidden;
}

.decorative-blob {
  position: absolute;
  top: -100px;
  right: -100px;
  width: 400px;
  height: 400px;
  background: radial-gradient(circle, rgba(99, 102, 241, 0.05) 0%, transparent 70%);
  border-radius: 50%;
  pointer-events: none;
}

.legal-header {
  margin-bottom: 80px;
  max-width: 800px;
}

h1 {
  font-size: clamp(2.5rem, 5vw, 3.5rem);
  font-family: var(--serif);
  color: var(--ink);
  margin-bottom: 16px;
  line-height: 1.1;
}

.updated {
  font-family: var(--sans);
  font-size: 1rem;
  color: var(--ink-muted);
  letter-spacing: 0.02em;
}

/* Asymmetric Grid Layout */
.legal-grid {
  display: grid;
  grid-template-columns: 280px 1fr;
  gap: 80px;
  align-items: start;
}

/* Sticky Sidebar Nav */
.legal-sidebar {
  position: sticky;
  top: 120px;
}

.sticky-nav {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.nav-item {
  font-family: var(--sans);
  font-size: 0.9rem;
  font-weight: 600;
  color: var(--ink-muted);
  padding: 12px 20px;
  border-radius: var(--r-md);
  transition: all 0.3s ease;
  border-left: 2px solid transparent;
}

.nav-item:hover {
  color: var(--indigo);
  background: rgba(99, 102, 241, 0.04);
}

.nav-item.active {
  color: var(--indigo);
  background: var(--indigo-light);
  border-left-color: var(--indigo);
}

/* Main Content Styling */
.legal-content {
  max-width: 800px;
}

section {
  margin-bottom: 64px;
  position: relative;
  padding-top: 24px;
}

.section-number {
  position: absolute;
  top: -10px;
  left: -20px;
  font-family: var(--serif);
  font-size: 4rem;
  color: var(--indigo);
  opacity: 0.05;
  pointer-events: none;
}

h2 {
  font-size: 1.8rem;
  font-family: var(--serif);
  color: var(--ink);
  margin-bottom: 24px;
}

p {
  font-size: 1.1rem;
  line-height: 1.8;
  color: var(--ink-soft);
  margin-bottom: 20px;
}

strong {
  color: var(--ink);
  font-weight: 700;
}

/* Custom List */
.custom-list {
  list-style: none;
  padding: 0;
  display: flex;
  flex-direction: column;
  gap: 24px;
}

.custom-list li {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.custom-list li strong {
  font-size: 1.1rem;
  color: var(--indigo);
}

/* Permission Cards */
.permission-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 20px;
  margin-top: 32px;
}

.p-card {
  background: white;
  padding: 32px;
  border-radius: var(--r-lg);
  border: 1px solid var(--border-light);
  box-shadow: var(--sh-sm);
  transition: all 0.3s ease;
}

.p-card:hover {
  transform: translateY(-4px);
  box-shadow: var(--sh-md);
  border-color: var(--indigo);
}

.p-icon {
  font-size: 2rem;
  margin-bottom: 20px;
}

.p-card h4 {
  font-size: 1.2rem;
  color: var(--ink);
  margin-bottom: 8px;
}

.p-card code {
  display: inline-block;
  font-family: monospace;
  font-size: 0.8rem;
  background: var(--surface);
  padding: 4px 10px;
  border-radius: 6px;
  color: var(--coral);
  margin-bottom: 16px;
}

.p-card p {
  font-size: 0.95rem;
  margin-bottom: 0;
}

/* Highlight Box */
.highlight-box {
  display: flex;
  gap: 24px;
  background: var(--teal-light);
  padding: 32px;
  border-radius: var(--r-lg);
  border: 1px solid rgba(20, 184, 166, 0.1);
  align-items: center;
}

.hb-icon {
  font-size: 2.5rem;
}

.highlight-box p {
  margin-bottom: 0;
  color: var(--ink-soft);
}

/* Contact Card */
.contact-card {
  background: var(--hero-bg);
  padding: 40px;
  border-radius: var(--r-lg);
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 40px;
}

.cc-item {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.cc-label {
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  color: var(--ink-muted);
  font-weight: 700;
}

.cc-value {
  font-size: 1.2rem;
  color: white;
  font-weight: 600;
  text-decoration: none;
}

.cc-value:hover {
  color: var(--indigo);
}

/* Responsive */
@media (max-width: 1024px) {
  .legal-grid {
    grid-template-columns: 1fr;
    gap: 48px;
  }
  
  .legal-sidebar {
    display: none;
  }
  
  .legal-header {
    margin-bottom: 48px;
  }
}

@media (max-width: 768px) {
  .legal-page {
    padding: 140px 0 80px;
  }
  
  .permission-cards {
    grid-template-columns: 1fr;
  }
  
  .highlight-box {
    flex-direction: column;
    text-align: center;
    gap: 16px;
  }
}
</style>
