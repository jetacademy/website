<template>
  <div class="security-container">
    <div class="container">
      <section class="security-hero text-center">
        <h1 class="text-gradient">Keamanan & Privasi</h1>
        <p class="subtitle">Standar keamanan kelas dunia untuk melindungi data pendidikan Anda.</p>
      </section>

      <div class="bento-grid">
        <div class="bento-card glass-panel">
          <div class="card-icon">🔒</div>
          <h3>Enkripsi End-to-End</h3>
          <p>Seluruh data dienkripsi saat transit dan saat disimpan (at rest) menggunakan standar industri terkini.</p>
        </div>

        <div class="bento-card glass-panel">
          <div class="card-icon">☁️</div>
          <h3>Cloud Auto Backup</h3>
          <p>Pencadangan data otomatis setiap hari ke server cloud yang aman dan terisolasi.</p>
        </div>

        <div class="bento-card glass-panel">
          <div class="card-icon">🛡️</div>
          <h3>Role-Based Access Control</h3>
          <p>Kontrol akses granular memastikan data hanya dapat dilihat oleh pihak yang berwenang (Yayasan, Guru, Siswa).</p>
        </div>

        <div class="bento-card glass-panel wide-card">
          <div class="card-content-flex">
            <div>
                <div class="card-icon">🏷️</div>
                <h3>100% Whitelabel</h3>
                <p>Aplikasi Mobile (Android & iOS) dengan nama, logo, dan branding sekolah Anda sendiri. Tersedia di App Store & Play Store.</p>
            </div>
            <div class="app-mockup">
                <!-- Visual placeholder for mobile app -->
                <div class="phone-frame">
                    <div class="screen">
                        <div class="app-header">Sekolah Anda</div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.security-container {
    padding: 140px 0 100px;
    background: linear-gradient(to bottom, #020617 0%, #0f172a 100%);
}

.security-hero h1 {
    font-size: 3.5rem;
    margin-bottom: 24px;
    font-weight: 800;
}

.subtitle {
    font-size: 1.25rem;
    color: var(--text-secondary);
    max-width: 700px;
    margin: 0 auto 80px;
}

.bento-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    grid-auto-rows: minmax(300px, auto);
    gap: 24px;
}

.bento-card {
    padding: 40px;
    border-radius: 24px;
    background: rgba(255,255,255,0.02);
    transition: transform 0.3s;
}

.bento-card:hover {
    background: rgba(255,255,255,0.04);
    transform: translateY(-5px);
}

.wide-card {
    grid-column: span 3;
}

.card-icon {
    font-size: 3rem;
    margin-bottom: 24px;
}

.bento-card h3 {
    font-size: 1.5rem;
    margin-bottom: 16px;
    color: #fff;
}

.bento-card p {
    color: var(--text-secondary);
    line-height: 1.6;
}

.card-content-flex {
    display: flex;
    align-items: center;
    gap: 40px;
}

.app-mockup {
    flex: 1;
    display: flex;
    justify-content: center;
}

.phone-frame {
    width: 200px;
    height: 300px; /* Cropped view */
    background: #1e293b;
    border-radius: 24px;
    border: 4px solid #334155;
    position: relative;
    overflow: hidden;
}

.screen {
    background: #0f172a;
    width: 100%;
    height: 100%;
}

.app-header {
    background: var(--accent-primary);
    padding: 16px;
    color: white;
    font-weight: bold;
    text-align: center;
    font-size: 0.9rem;
}

@media (max-width: 1024px) {
    .bento-grid { grid-template-columns: 1fr; }
    .wide-card { grid-column: span 1; }
    .card-content-flex { flex-direction: column; text-align: left; }
}
</style>
