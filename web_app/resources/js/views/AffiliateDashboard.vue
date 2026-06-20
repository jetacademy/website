<template>
  <div class="aff-dash">
    <!-- Navbar -->
    <nav class="aff-nav">
      <div class="nav-inner">
        <div class="nav-brand">
          <div class="brand-icon">J</div>
          <span class="brand-text">Mitra<b>Jetschool</b></span>
        </div>
        <div class="nav-end">
          <div class="user-pill">
            <img :src="avatarUrl" alt="Avatar" class="nav-avatar">
            <span class="nav-name">{{ userName }}</span>
          </div>
          <button class="btn-logout" @click="handleLogout">Keluar</button>
        </div>
      </div>
    </nav>

    <!-- Main -->
    <main class="aff-main">
      <!-- Loading -->
      <div v-if="isLoading" class="center-state">
        <div class="spinner"></div>
        <p>Memuat dashboard...</p>
      </div>

      <!-- Error -->
      <div v-else-if="error" class="center-state">
        <div class="err-card">
          <h3>Tidak Dapat Memuat Data</h3>
          <p>{{ error }}</p>
          <button @click="loadDashboard" class="btn btn-primary" style="margin-top:16px">Coba Lagi</button>
        </div>
      </div>

      <!-- Dashboard Content -->
      <div v-else class="dash-body">
        <!-- Welcome -->
        <section class="welcome">
          <div>
            <h1>Halo, {{ userName }} 👋</h1>
            <p>Pantau performa tautan dan komisi Anda secara realtime.</p>
          </div>
        </section>

        <!-- Referral Link Card -->
        <section class="link-section">
          <div class="link-card">
            <div class="link-header">
              <h3>Tautan Afiliasi Anda</h3>
              <span class="link-hint">Bagikan link ini untuk mendapatkan komisi</span>
            </div>
            <div v-if="!isEditingLink" class="link-display">
              <div class="link-url">{{ affiliateLink }}</div>
              <div class="link-actions">
                <button @click="copyLink" :class="['btn btn-primary', { 'btn-success': copied }]">
                  {{ copied ? '✓ Disalin' : 'Salin Link' }}
                </button>
                <button @click="startEditLink" class="btn btn-ghost">Ubah Kode</button>
              </div>
            </div>
            <div v-else class="link-edit">
              <div class="edit-row">
                <span class="edit-prefix">{{ baseUrl }}/?ref=</span>
                <input type="text" v-model="editLinkValue" class="edit-input" placeholder="KODE-UNIK">
              </div>
              <div v-if="linkError" class="edit-error">{{ linkError }}</div>
              <div class="link-actions">
                <button @click="saveLink" :disabled="isSavingLink" class="btn btn-primary">
                  {{ isSavingLink ? 'Menyimpan...' : 'Simpan' }}
                </button>
                <button @click="cancelEditLink" class="btn btn-ghost">Batal</button>
              </div>
            </div>
          </div>
        </section>

        <!-- Performance Stats -->
        <section class="perf-section">
          <h2 class="section-title">Performa</h2>
          <div class="perf-grid">
            <div class="perf-card">
              <div class="perf-icon" style="background:#EFF6FF;color:#2563EB">👆</div>
              <div class="perf-data">
                <span class="perf-value">{{ stats.total_clicks }}</span>
                <span class="perf-label">Klik Link</span>
              </div>
            </div>
            <div class="perf-card">
              <div class="perf-icon" style="background:#F0FDF4;color:#16A34A">📋</div>
              <div class="perf-data">
                <span class="perf-value">{{ stats.total_leads }}</span>
                <span class="perf-label">Pendaftaran Demo</span>
              </div>
            </div>
            <div class="perf-card">
              <div class="perf-icon" style="background:#ECFDF5;color:#059669">🤝</div>
              <div class="perf-data">
                <span class="perf-value">{{ stats.total_deals }}</span>
                <span class="perf-label">Deal Berhasil</span>
              </div>
            </div>
            <div class="perf-card">
              <div class="perf-icon" style="background:#FDF4FF;color:#9333EA">📊</div>
              <div class="perf-data">
                <span class="perf-value">{{ stats.conversion_rate }}%</span>
                <span class="perf-label">Konversi</span>
              </div>
            </div>
          </div>
        </section>

        <!-- Commission Cards -->
        <section class="comm-section">
          <h2 class="section-title">Komisi</h2>
          <div class="comm-grid">
            <div class="comm-card comm-pending">
              <span class="comm-label">Komisi Tertunda</span>
              <span class="comm-value">{{ formatRupiah(stats.total_pending_commission) }}</span>
              <span class="comm-note">Menunggu pencairan</span>
            </div>
            <div class="comm-card comm-paid">
              <span class="comm-label">Total Pencairan</span>
              <span class="comm-value">{{ formatRupiah(stats.total_paid_commission) }}</span>
              <span class="comm-note">Sudah ditransfer ke rekening</span>
            </div>
          </div>
        </section>

        <!-- Leads Table -->
        <section class="table-section">
          <div class="table-top">
            <h2 class="section-title" style="margin:0">Riwayat Calon Klien</h2>
            <button @click="loadLeads" class="btn btn-ghost btn-sm">↻ Refresh</button>
          </div>
          <div class="table-wrap">
            <table>
              <thead>
                <tr>
                  <th>TANGGAL</th>
                  <th>SEKOLAH</th>
                  <th>KONTAK</th>
                  <th>STATUS</th>
                </tr>
              </thead>
              <tbody>
                <tr v-if="leadsLoading">
                  <td colspan="4" class="td-center">Memuat riwayat...</td>
                </tr>
                <tr v-else-if="leads.length === 0">
                  <td colspan="4" class="td-center td-muted">Belum ada calon klien. Bagikan tautan Anda!</td>
                </tr>
                <tr v-else v-for="lead in leads" :key="lead.id">
                  <td>{{ formatDate(lead.created_at) }}</td>
                  <td>
                    <strong>{{ lead.school_name }}</strong>
                    <div class="sub-text">{{ lead.name }}</div>
                  </td>
                  <td>{{ lead.phone_number }}</td>
                  <td>
                    <span :class="['status-pill', 'sp-' + lead.status]">
                      {{ translateStatus(lead.status) }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </section>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

const userName = ref('Mitra');
const isLoading = ref(true);
const leadsLoading = ref(true);
const error = ref(null);
const copied = ref(false);
const isEditingLink = ref(false);
const isSavingLink = ref(false);
const editLinkValue = ref('');
const linkError = ref('');
const baseUrl = ref(window.location.origin);
const leads = ref([]);

const stats = ref({
    referral_code: '', total_clicks: 0, total_leads: 0, total_deals: 0,
    conversion_rate: 0, total_pending_commission: 0, total_paid_commission: 0
});

const avatarUrl = computed(() => {
  const name = encodeURIComponent(userName.value);
  return `https://ui-avatars.com/api/?name=${name}&background=4F46E5&color=fff&size=80`;
});

const affiliateLink = computed(() => `${baseUrl.value}/?ref=${stats.value.referral_code || 'KODE'}`);

const handleLogout = async () => {
  try { await axios.post('/api/logout'); } catch (e) {}
  window.location.href = '/login';
};

const startEditLink = () => { editLinkValue.value = stats.value.referral_code; linkError.value = ''; isEditingLink.value = true; };
const cancelEditLink = () => { isEditingLink.value = false; linkError.value = ''; };

const saveLink = async () => {
    if (!editLinkValue.value || editLinkValue.value.length < 4) { linkError.value = 'Kode minimal 4 karakter.'; return; }
    isSavingLink.value = true; linkError.value = '';
    try {
        const res = await axios.put('/api/affiliates/referral-code', { referral_code: editLinkValue.value });
        if (res.data.success) { stats.value.referral_code = res.data.data.referral_code; isEditingLink.value = false; }
    } catch (err) {
        linkError.value = err.response?.data?.errors?.referral_code?.[0] || err.response?.data?.message || 'Gagal menyimpan.';
    } finally { isSavingLink.value = false; }
};

const copyLink = async () => {
    try { await navigator.clipboard.writeText(affiliateLink.value); copied.value = true; setTimeout(() => { copied.value = false; }, 2000); } catch {}
};

const formatRupiah = (n) => n ? new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(n) : 'Rp 0';
const formatDate = (d) => d ? new Intl.DateTimeFormat('id-ID', { day: '2-digit', month: 'long', year: 'numeric' }).format(new Date(d)) : '-';
const translateStatus = (s) => ({ new: 'Baru', contacted: 'Dihubungi', demo_scheduled: 'Jadwal Demo', closed_won: 'Deal ✓', closed_lost: 'Batal' }[s] || s);

const loadDashboard = async () => {
    isLoading.value = true; error.value = null;
    try {
        const meRes = await axios.get('/api/me');
        if (!meRes.data.user) { window.location.href = '/login'; return; }
        userName.value = meRes.data.user.name || 'Mitra';
        const res = await axios.get('/api/affiliates/dashboard');
        if (res.data.success) { stats.value = res.data.data; loadLeads(); }
        else { error.value = res.data.message || 'Gagal memuat.'; }
    } catch (err) {
        if (err.response?.status === 401) { window.location.href = '/login'; return; }
        error.value = err.response?.data?.message || 'Terjadi kesalahan.';
    } finally { isLoading.value = false; }
};

const loadLeads = async () => {
    leadsLoading.value = true;
    try { const r = await axios.get('/api/leads'); const d = r.data?.data; leads.value = Array.isArray(d) ? d : (d?.data || []); }
    catch {} finally { leadsLoading.value = false; }
};

onMounted(() => loadDashboard());
</script>

<style scoped>
* { box-sizing: border-box; }
.aff-dash { background: #F8FAFC; min-height: 100vh; font-family: 'Inter', -apple-system, sans-serif; color: #0F172A; }

/* NAV */
.aff-nav { background: #fff; border-bottom: 1px solid #E2E8F0; position: sticky; top: 0; z-index: 50; }
.nav-inner { max-width: 1100px; margin: 0 auto; padding: 0 24px; height: 64px; display: flex; align-items: center; justify-content: space-between; }
.nav-brand { display: flex; align-items: center; gap: 10px; }
.brand-icon { width: 36px; height: 36px; background: linear-gradient(135deg, #4F46E5, #3730A3); color: #fff; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 1.2rem; }
.brand-text { font-size: 1.05rem; color: #334155; } .brand-text b { color: #4F46E5; }
.nav-end { display: flex; align-items: center; gap: 12px; }
.user-pill { display: flex; align-items: center; gap: 8px; background: #F1F5F9; padding: 4px 12px 4px 4px; border-radius: 100px; }
.nav-avatar { width: 32px; height: 32px; border-radius: 50%; }
.nav-name { font-weight: 600; font-size: 0.85rem; color: #334155; }
.btn-logout { background: #FEF2F2; border: 1px solid #FECACA; color: #DC2626; padding: 7px 14px; border-radius: 8px; cursor: pointer; font-weight: 700; font-size: 0.78rem; transition: all 0.2s; }
.btn-logout:hover { background: #FEE2E2; }

/* MAIN */
.aff-main { max-width: 1100px; margin: 0 auto; padding: 32px 24px 80px; }

/* States */
.center-state { display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 50vh; gap: 16px; color: #64748B; }
.spinner { width: 40px; height: 40px; border: 4px solid #E2E8F0; border-top-color: #4F46E5; border-radius: 50%; animation: spin 0.7s linear infinite; }
@keyframes spin { to { transform: rotate(360deg); } }
.err-card { background: #fff; border: 1px solid #FECACA; border-radius: 16px; padding: 40px; text-align: center; max-width: 420px; }
.err-card h3 { color: #991B1B; margin: 0 0 8px; }
.err-card p { color: #64748B; margin: 0; }

/* Welcome */
.welcome { margin-bottom: 32px; }
.welcome h1 { font-size: 1.8rem; font-weight: 800; margin: 0 0 6px; font-family: 'Playfair Display', serif; }
.welcome p { color: #64748B; margin: 0; font-size: 1rem; }

/* Link Card */
.link-section { margin-bottom: 32px; }
.link-card { background: #fff; border: 1px solid #E2E8F0; border-radius: 16px; padding: 28px; box-shadow: 0 2px 8px rgba(0,0,0,0.03); }
.link-header { margin-bottom: 16px; }
.link-header h3 { font-size: 1.1rem; font-weight: 700; margin: 0 0 4px; }
.link-hint { font-size: 0.85rem; color: #94A3B8; }
.link-display { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
.link-url { flex: 1; padding: 14px 16px; background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; font-family: 'JetBrains Mono', monospace; font-size: 0.9rem; color: #334155; min-width: 200px; word-break: break-all; }
.link-actions { display: flex; gap: 8px; }
.link-edit { display: flex; flex-direction: column; gap: 12px; }
.edit-row { display: flex; align-items: stretch; border: 1.5px solid #4F46E5; border-radius: 10px; overflow: hidden; }
.edit-prefix { padding: 12px 14px; background: #F1F5F9; border-right: 1px solid #E2E8F0; font-size: 0.85rem; color: #64748B; display: flex; align-items: center; white-space: nowrap; }
.edit-input { flex: 1; padding: 12px 14px; border: none; font-size: 1rem; font-family: monospace; color: #0F172A; outline: none; }
.edit-error { color: #DC2626; font-size: 0.85rem; font-weight: 600; }

/* Buttons */
.btn { display: inline-flex; align-items: center; justify-content: center; padding: 10px 18px; font-weight: 700; border-radius: 10px; border: none; cursor: pointer; font-size: 0.85rem; transition: all 0.2s; }
.btn-primary { background: #4F46E5; color: #fff; }
.btn-primary:hover { background: #4338CA; }
.btn-primary:disabled { opacity: 0.5; cursor: not-allowed; }
.btn-success { background: #059669 !important; }
.btn-ghost { background: transparent; border: 1px solid #CBD5E1; color: #475569; }
.btn-ghost:hover { border-color: #4F46E5; color: #4F46E5; }
.btn-sm { padding: 6px 12px; font-size: 0.78rem; }

/* Section Titles */
.section-title { font-size: 1.15rem; font-weight: 800; margin: 0 0 16px; color: #0F172A; }

/* Performance */
.perf-section { margin-bottom: 32px; }
.perf-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; }
.perf-card { background: #fff; border: 1px solid #E2E8F0; border-radius: 14px; padding: 24px; display: flex; align-items: center; gap: 16px; box-shadow: 0 2px 6px rgba(0,0,0,0.02); transition: transform 0.2s, box-shadow 0.2s; }
.perf-card:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(0,0,0,0.06); }
.perf-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; flex-shrink: 0; }
.perf-data { display: flex; flex-direction: column; }
.perf-value { font-size: 1.6rem; font-weight: 900; line-height: 1.2; color: #0F172A; }
.perf-label { font-size: 0.8rem; color: #64748B; font-weight: 600; }

/* Commission */
.comm-section { margin-bottom: 32px; }
.comm-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.comm-card { border-radius: 14px; padding: 28px; display: flex; flex-direction: column; gap: 4px; }
.comm-pending { background: linear-gradient(135deg, #FFFBEB, #FEF3C7); border: 1px solid #FDE68A; }
.comm-paid { background: linear-gradient(135deg, #ECFDF5, #D1FAE5); border: 1px solid #A7F3D0; }
.comm-label { font-size: 0.85rem; font-weight: 700; color: #64748B; }
.comm-value { font-size: 1.8rem; font-weight: 900; color: #0F172A; }
.comm-note { font-size: 0.78rem; color: #94A3B8; }

/* Table */
.table-section { margin-bottom: 40px; }
.table-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
.table-wrap { background: #fff; border: 1px solid #E2E8F0; border-radius: 14px; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,0.02); }
table { width: 100%; border-collapse: collapse; text-align: left; }
th { background: #F8FAFC; padding: 14px 20px; font-size: 0.72rem; font-weight: 800; color: #64748B; letter-spacing: 0.05em; border-bottom: 1px solid #E2E8F0; }
td { padding: 16px 20px; border-bottom: 1px solid #F1F5F9; font-size: 0.9rem; color: #334155; }
tr:last-child td { border-bottom: none; }
tr:hover td { background: #FAFBFC; }
.td-center { text-align: center; padding: 32px 20px; }
.td-muted { color: #94A3B8; }
.sub-text { font-size: 0.8rem; color: #94A3B8; margin-top: 2px; }

/* Status Pills */
.status-pill { display: inline-block; padding: 5px 12px; border-radius: 100px; font-size: 0.72rem; font-weight: 700; }
.sp-new { background: #DBEAFE; color: #1E40AF; }
.sp-contacted { background: #FEF3C7; color: #92400E; }
.sp-demo_scheduled { background: #F3E8FF; color: #6B21A8; }
.sp-closed_won { background: #D1FAE5; color: #065F46; }
.sp-closed_lost { background: #FEE2E2; color: #991B1B; }

/* Responsive */
@media (max-width: 768px) {
  .perf-grid { grid-template-columns: repeat(2, 1fr); }
  .comm-grid { grid-template-columns: 1fr; }
  .link-display { flex-direction: column; }
  .link-url { min-width: 0; }
  .nav-name { display: none; }
  .welcome h1 { font-size: 1.4rem; }
  .aff-main { padding: 24px 16px 60px; }
  th { padding: 10px 14px; } td { padding: 12px 14px; }
}
@media (max-width: 480px) {
  .perf-grid { grid-template-columns: 1fr 1fr; gap: 10px; }
  .perf-card { padding: 16px; gap: 10px; }
  .perf-value { font-size: 1.3rem; }
  .perf-icon { width: 40px; height: 40px; font-size: 1.1rem; }
  .comm-value { font-size: 1.4rem; }
  .edit-prefix { font-size: 0.7rem; padding: 10px 8px; }
  .nav-inner { padding: 0 12px; }
  .user-pill { padding: 2px 8px 2px 2px; }
}
</style>
