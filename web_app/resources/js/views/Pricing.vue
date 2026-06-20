<template>
  <div class="pricing-container">
    <div class="container text-center">
      <section class="pricing-header">
        <h1 class="text-gradient-blue text-4xl font-bold mb-4">Investasi Pendidikan Masa Depan</h1>
        <p class="subtitle text-slate-500 max-w-2xl mx-auto mb-12">Pilih paket yang sesuai dengan kebutuhan sekolah Anda. Transparan, hemat, dan bernilai tinggi.</p>
      </section>

      <div class="pricing-grid">
        <!-- Basic Plan -->
        <div class="pricing-card basic">
          <div class="card-header">
            <h3>Starter</h3>
            <p class="price">Rp 3.000<span class="period">/siswa/bln</span></p>
            <p class="desc">Untuk sekolah yang baru memulai digitalisasi.</p>
          </div>
          <ul class="features">
            <li>✅ Sistem PPDB Online</li>
            <li>✅ Manajemen Data Siswa</li>
            <li>✅ Laporan Keuangan Dasar</li>
            <li>✅ Mobile App Wali Murid</li>
          </ul>
          <router-link to="/contact?package=Starter" class="btn btn-secondary w-full mt-6">Pilih Starter</router-link>
        </div>

        <!-- Pro Plan (Highlighted) -->
        <div class="pricing-card pro">
          <div class="popular-tag">Paling Populer</div>
          <div class="card-header">
            <h3>School OS</h3>
            <p class="low-price">Hanya</p>
            <p class="price">Rp 5.000<span class="period">/siswa/bln</span></p>
            <p class="desc">Solusi lengkap untuk sekolah modern.</p>
          </div>
          <ul class="features">
            <li>✅ <strong>Semua Fitur Starter</strong></li>
            <li>✅ <strong>50+ Modul Akademik & Kesiswaan</strong></li>
            <li>✅ Ujian Online (CBT) & AI Grading</li>
            <li>✅ Dashboard Yayasan Real-time</li>
            <li>✅ Whitelabel Mobile Apps (Android/iOS)</li>
            <li>✅ Integrasi Payment Gateway</li>
          </ul>
          <router-link to="/contact?package=School+OS" class="btn btn-primary w-full mt-6">Pilih School OS</router-link>
        </div>

        <!-- Enterprise -->
        <div class="pricing-card enterprise">
          <div class="card-header">
            <h3>Enterprise</h3>
            <p class="price">Custom</p>
            <p class="desc">Untuk jaringan sekolah besar & franchise.</p>
          </div>
          <ul class="features">
            <li>✅ Dedicated Server & Database</li>
            <li>✅ Custom Modul Development</li>
            <li>✅ Prioritas Support 24/7</li>
            <li>✅ Integrasi API Pihak Ketiga</li>
            <li>✅ On-site Training Berkelanjutan</li>
          </ul>
          <router-link to="/contact?package=Enterprise" class="btn btn-secondary w-full mt-6">Hubungi Kami</router-link>
        </div>
      </div>

      <!-- Promo Section -->
      <div class="promo-banner mt-16 p-8 rounded-2xl bg-blue-50 border border-blue-100">
        <h3 class="text-2xl font-bold text-blue-900 mb-2">🎁 Promo Spesial Tahun Ajaran Baru</h3>
        <p class="text-slate-600 mb-6">Gratis Biaya Setup & Implementasi (Senilai Rp 15.000.000) untuk kontrak minimal 3 tahun.</p>
        <router-link to="/contact?package=School+OS&amp;promo=setup-free" class="btn btn-primary">Klaim Promo Sekarang</router-link>
      </div>
    </div>
  </div>
</template>

<style scoped>
.pricing-container {
    padding: 120px 0 100px;
    background: #f8fafc;
}

.pricing-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 32px;
    align-items: stretch; /* Cards same height */
    max-width: 1100px;
    margin: 0 auto;
}

.pricing-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 40px 32px;
    border: 1px solid #e2e8f0;
    transition: all 0.3s;
    position: relative;
    display: flex;
    flex-direction: column;
}

.pricing-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    border-color: var(--accent-primary);
}

.pricing-card.pro {
    border: 2px solid var(--accent-primary);
    background: #eff6ff;
    transform: scale(1.05);
    z-index: 10;
    box-shadow: 0 25px 50px -12px rgba(37, 99, 235, 0.15);
}

.pricing-card.pro:hover {
    transform: scale(1.05) translateY(-5px);
}

.popular-tag {
    position: absolute;
    top: -16px;
    left: 50%;
    transform: translateX(-50%);
    background: var(--accent-gold);
    color: white;
    padding: 6px 16px;
    border-radius: 100px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    box-shadow: 0 4px 6px -1px rgba(217, 119, 6, 0.4);
}

.card-header {
    text-align: center;
    margin-bottom: 32px;
    border-bottom: 1px solid rgba(0,0,0,0.05);
    padding-bottom: 24px;
}

.pricing-card h3 {
    font-size: 1.5rem;
    margin-bottom: 12px;
    color: var(--text-primary);
}

.low-price {
    font-size: 0.9rem;
    color: var(--text-secondary);
    margin-bottom: -4px;
}

.price {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--text-primary);
    line-height: 1;
}

.pro .price {
    color: var(--accent-primary);
}

.period {
    font-size: 1rem;
    color: var(--text-secondary);
    font-weight: 400;
}

.desc {
    margin-top: 12px;
    color: var(--text-secondary);
    font-size: 0.95rem;
}

.features {
    list-style: none;
    text-align: left;
    flex: 1; /* Push button to bottom */
}

.features li {
    margin-bottom: 16px;
    color: var(--text-secondary);
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* Response Mobile */
@media (max-width: 900px) {
    .pricing-grid { grid-template-columns: 1fr; max-width: 500px; }
    .pricing-card.pro { transform: scale(1); }
    .pricing-card.pro:hover { transform: translateY(-5px); }
}
</style>
