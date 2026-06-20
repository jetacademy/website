<template>
  <div class="page-panel">
    <div class="panel-header row-space">
      <div>
        <h2>Statistik &amp; Metrik</h2>
        <p>Ringkasan kinerja website Jetschool secara keseluruhan.</p>
      </div>
      <button class="btn btn-outline" @click="loadStats">↻ Refresh Data</button>
    </div>

    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-label">Lead Hari Ini</div>
        <div class="stat-number">{{ data.today_leads }}</div>
        <div class="stat-sub">dari total {{ data.total_leads }} lead</div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Artikel Terbit</div>
        <div class="stat-number">{{ data.total_posts }}</div>
        <div class="stat-sub">konten SEO aktif</div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Rasio Konversi</div>
        <div class="stat-number text-green">{{ data.conversion_rate }}%</div>
        <div class="stat-sub">lead menjadi pelanggan</div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Mitra Affiliasi</div>
        <div class="stat-number">{{ data.total_affiliates }}</div>
        <div class="stat-sub">agen aktif terdaftar</div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Total Klik Affiliate</div>
        <div class="stat-number">{{ formatNumber(data.total_clicks) }}</div>
        <div class="stat-sub">klik link referal</div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Total Staff</div>
        <div class="stat-number">{{ data.total_users }}</div>
        <div class="stat-sub">pengguna terdaftar</div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const data = ref({ today_leads: 0, total_leads: 0, conversion_rate: 0, total_affiliates: 0, total_posts: 0, total_clicks: 0, total_users: 0 });

const loadStats = async () => {
  try {
    const res = await axios.get('/api/stats');
    data.value = res.data.metrics;
  } catch { /* silent */ }
};

const formatNumber = (n) => n ? n.toLocaleString('id-ID') : '0';

onMounted(loadStats);
</script>

<style scoped>
.stats-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 20px; }
.stat-card { background: #fff; border-radius: 16px; padding: 28px; border: 1px solid #E2E8F0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.04); }
.stat-label { font-size: 0.85rem; font-weight: 700; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px; }
.stat-number { font-size: 2.5rem; font-weight: 900; color: #0F172A; line-height: 1.1; margin-bottom: 4px; }
.stat-number.text-green { color: #059669; }
.stat-sub { font-size: 0.85rem; color: #94A3B8; font-weight: 500; }

@media (max-width: 768px) {
  .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
  .stat-card { padding: 20px; }
  .stat-number { font-size: 1.8rem; }
}
@media (max-width: 480px) {
  .stats-grid { grid-template-columns: 1fr; }
}
</style>
