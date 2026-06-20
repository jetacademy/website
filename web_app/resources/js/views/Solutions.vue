<template>
  <div class="page-container">
    <div class="container">
      <section class="page-hero text-center">
        <h1 class="text-gradient">Produk & Solusi</h1>
        <p class="subtitle">Platform terintegrasi dari hulu ke hilir untuk kebutuhan sekolah modern.</p>
      </section>

      <div class="solutions-grid">
        <div class="solution-card glass-panel">
          <div class="card-header">
            <span class="module-badge">A</span>
            <h2>Integrated School OS</h2>
          </div>
          <ul class="feature-list">
            <li>Satu ID Siswa Seumur Hidup</li>
            <li>Portofolio Berkelanjutan</li>
            <li>Data lintas unit & jenjang</li>
          </ul>
        </div>

        <div class="solution-card glass-panel">
          <div class="card-header">
            <span class="module-badge">B</span>
            <h2>Executive Dashboard</h2>
          </div>
          <ul class="feature-list">
            <li>Monitoring Yayasan</li>
            <li>Manajemen PTK</li>
            <li>Keputusan berbasis data</li>
          </ul>
        </div>

        <div class="solution-card glass-panel">
          <div class="card-header">
            <span class="module-badge">C</span>
            <h2>Akademik & Pembelajaran</h2>
          </div>
          <ul class="feature-list">
            <li>Smart Class Management</li>
            <li>LMS & Modul Ajar Deep Learning</li>
            <li>Jurnal & Absen Digital</li>
            <li>CBT (8 Tipe Soal) & AI Essay Grader</li>
          </ul>
        </div>

        <div class="solution-card glass-panel">
          <div class="card-header">
            <span class="module-badge">D</span>
            <h2>Fitur AI</h2>
          </div>
          <ul class="feature-list">
            <li>AI Assistant Guru</li>
            <li>AI Tutor Murid 24/7</li>
            <li>Adaptive Learning</li>
            <li>Gamification (XP, Level, Leaderboard)</li>
          </ul>
        </div>

        <div class="solution-card glass-panel">
          <div class="card-header">
            <span class="module-badge">E</span>
            <h2>Kesiswaan & Karakter</h2>
          </div>
          <ul class="feature-list">
            <li>BK & Kredit Poin</li>
            <li>SOS Anti Bullying</li>
            <li>Portofolio Murid</li>
          </ul>
        </div>

        <div class="solution-card glass-panel">
          <div class="card-header">
            <span class="module-badge">F</span>
            <h2>Tahfidz & Tahsin Tracker</h2>
          </div>
          <ul class="feature-list">
            <li>Monitoring Hafalan</li>
            <li>Laporan ke Orang Tua</li>
            <li>Target Hafalan Digital</li>
          </ul>
        </div>

        <div class="solution-card glass-panel">
          <div class="card-header">
            <span class="module-badge">G</span>
            <h2>Keuangan & Billing</h2>
          </div>
          <ul class="feature-list">
            <li>Billing Otomatis</li>
            <li>Multi-channel Payment</li>
            <li>Transparansi Laporan</li>
          </ul>
        </div>

        <div class="solution-card glass-panel">
          <div class="card-header">
            <span class="module-badge">H</span>
            <h2>SPMB (Penerimaan Baru)</h2>
          </div>
          <ul class="feature-list">
            <li>Form Dinamis & Landing Page</li>
            <li>Pengaturan Gelombang & Kuota</li>
            <li>Pembayaran Online</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.page-container {
    padding: 140px 0 100px;
    background: radial-gradient(circle at 50% 0%, rgba(59, 130, 246, 0.05) 0%, rgba(2, 6, 23, 0) 70%);
}

.page-hero h1 {
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

.solutions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 32px;
}

.solution-card {
    padding: 40px;
    border-radius: 20px;
    transition: all 0.3s ease;
    background: linear-gradient(180deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.01) 100%);
}

.solution-card:hover {
    border-color: rgba(59, 130, 246, 0.3);
    transform: translateY(-5px);
    box-shadow: 0 20px 40px -10px rgba(0,0,0,0.5);
}

.card-header {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 32px;
    padding-bottom: 24px;
    border-bottom: 1px solid rgba(255,255,255,0.05);
}

.module-badge {
    background: rgba(59, 130, 246, 0.1);
    color: var(--accent-primary);
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    font-weight: 700;
    font-family: var(--font-heading);
    font-size: 1.25rem;
    border: 1px solid rgba(59, 130, 246, 0.2);
}

.card-header h2 {
    font-size: 1.25rem;
    margin-bottom: 0;
    line-height: 1.3;
}

.feature-list {
    list-style: none;
}

.feature-list li {
    padding: 12px 0;
    color: var(--text-secondary);
    display: flex;
    align-items: start;
    font-size: 0.95rem;
}

.feature-list li::before {
    content: "→";
    color: var(--accent-primary);
    margin-right: 12px;
    font-weight: bold;
    opacity: 0.7;
}
</style>
