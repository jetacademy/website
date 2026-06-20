<template>
  <div class="page-panel">
    <div class="panel-header row-space">
      <div>
        <h2>Kelola Mitra / Affiliate</h2>
        <p>Pantau dan atur agen mitra yang mendatangkan klien sekolah baru.</p>
      </div>
      <button class="btn btn-primary" @click="showAddModal = true">+ Tambah Mitra Baru</button>
    </div>

    <div class="table-card">
      <div class="table-responsive">
        <table>
          <thead>
            <tr>
              <th>NAMA MITRA</th>
              <th>KODE REFERAL</th>
              <th>LINK AFFILIATE</th>
              <th>KLIK</th>
              <th>LEADS</th>
              <th>CLOSING</th>
              <th>KONVERSI</th>
              <th>TIPE KOMISI</th>
              <th>NILAI KOMISI</th>
              <th>AKSI</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="loading"><td colspan="10" class="text-center py-4">Memuat data...</td></tr>
            <tr v-else-if="affiliates.length === 0"><td colspan="10" class="text-center py-4 text-muted">Belum ada mitra terdaftar.</td></tr>
            <tr v-else v-for="aff in affiliates" :key="aff.id">
              <td>
                <strong>{{ aff.user ? aff.user.name : '-' }}</strong>
                <div class="text-muted text-sm">{{ aff.user ? aff.user.email : '' }}</div>
              </td>
              <td><span class="code-badge">{{ aff.referral_code }}</span></td>
              <td>
                <div class="link-cell">
                  <input :value="getAffLink(aff.referral_code)" readonly class="link-input" :id="'link-' + aff.id">
                  <button class="btn btn-sm btn-outline" @click="copyLink(aff)">Salin</button>
                </div>
              </td>
              <td class="text-center"><strong>{{ aff.total_clicks || 0 }}</strong></td>
              <td class="text-center"><strong>{{ aff.total_leads || 0 }}</strong></td>
              <td class="text-center"><strong class="text-green">{{ aff.total_closing || 0 }}</strong></td>
              <td class="text-center">
                <span :class="['perf-badge', (aff.conversion_rate || 0) > 0 ? 'perf-good' : '']">
                  {{ aff.conversion_rate || 0 }}%
                </span>
              </td>
              <td><span class="type-badge">{{ aff.commission_type === 'percentage' ? 'Persentase' : 'Nominal' }}</span></td>
              <td>
                <strong v-if="aff.commission_type==='percentage'">{{ aff.commission_rate }}%</strong>
                <strong v-else>{{ formatRupiah(aff.commission_rate) }}</strong>
              </td>
              <td>
                <button class="btn btn-outline btn-sm" @click="openEditComm(aff)">Sesuaikan Komisi</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal Tambah Mitra -->
    <div v-if="showAddModal" class="modal-overlay" @click.self="showAddModal=false">
      <div class="modal-card">
        <h3>Tambah Mitra Baru</h3>
        <p class="text-muted text-sm mb-4">Daftarkan seseorang sebagai tenaga pemasar.</p>
        <form @submit.prevent="saveNewAffiliate">
          <div class="form-group mb-3"><label>Nama Lengkap</label><input type="text" v-model="addForm.name" required class="form-control"></div>
          <div class="form-group mb-3"><label>Email</label><input type="email" v-model="addForm.email" required class="form-control"></div>
          <div class="form-group mb-3"><label>Password</label><input type="password" v-model="addForm.password" required class="form-control" placeholder="Min 6 karakter"></div>
          <div class="row-flex gap-4 mb-3">
            <div class="form-group w-half">
              <label>Tipe Komisi</label>
              <select v-model="addForm.commission_type" class="form-control">
                <option value="percentage">Persentase (%)</option>
                <option value="fixed">Nominal (Rp)</option>
              </select>
            </div>
            <div class="form-group w-half">
              <label>Nilai Komisi</label>
              <input type="number" step="0.01" v-model="addForm.commission_rate" required class="form-control" placeholder="10">
            </div>
          </div>
          <div v-if="addError" class="text-center text-sm p-3 bg-red-50 text-red-600 rounded-xl border border-red-200 mb-3">{{ addError }}</div>
          <div class="action-footer mt-4 row-space border-t pt-4">
            <button type="button" class="btn btn-outline" @click="showAddModal=false">Batal</button>
            <button type="submit" class="btn btn-primary" :disabled="saving">{{ saving ? 'Memproses...' : 'Simpan Mitra' }}</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Modal Edit Komisi -->
    <div v-if="showEditModal" class="modal-overlay" @click.self="showEditModal=false">
      <div class="modal-card">
        <h3>Sesuaikan Komisi</h3>
        <p class="text-muted text-sm mb-4">Mitra: <strong>{{ selectedAff?.user?.name }}</strong></p>
        <div class="form-group mb-3">
          <label>Tipe</label>
          <select v-model="editForm.commission_type" class="form-control">
            <option value="percentage">Persentase (%)</option>
            <option value="fixed">Nominal (Rp)</option>
          </select>
        </div>
        <div class="form-group mb-3">
          <label>Nilai</label>
          <input type="number" step="0.01" v-model="editForm.commission_rate" class="form-control">
        </div>
        <div class="action-footer mt-4 row-space border-t pt-4">
          <button class="btn btn-outline" @click="showEditModal=false">Batal</button>
          <button class="btn btn-primary" @click="saveCommission" :disabled="saving">{{ saving ? 'Menyimpan...' : 'Simpan' }}</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useToast } from '../../composables/useToast';

const toast = useToast();

const affiliates = ref([]);
const loading = ref(true);
const saving = ref(false);
const showAddModal = ref(false);
const showEditModal = ref(false);
const selectedAff = ref(null);
const addError = ref('');
const addForm = ref({ name: '', email: '', password: '', commission_type: 'percentage', commission_rate: 10 });
const editForm = ref({ commission_type: 'percentage', commission_rate: 0 });

const load = async () => {
  loading.value = true;
  try {
    const res = await axios.get('/api/affiliates');
    affiliates.value = res.data.success ? (res.data.data.data || res.data.data) : [];
  } catch { affiliates.value = []; }
  loading.value = false;
};

const saveNewAffiliate = async () => {
  saving.value = true; addError.value = '';
  try {
    await axios.post('/api/affiliates', addForm.value);
    showAddModal.value = false;
    addForm.value = { name: '', email: '', password: '', commission_type: 'percentage', commission_rate: 10 };
    toast.success('Mitra baru berhasil ditambahkan.');
    load();
  } catch (e) {
    addError.value = e.response?.data?.message || 'Gagal mendaftarkan mitra.';
  }
  saving.value = false;
};

const openEditComm = (aff) => {
  selectedAff.value = aff;
  editForm.value = { commission_type: aff.commission_type, commission_rate: aff.commission_rate };
  showEditModal.value = true;
};

const saveCommission = async () => {
  saving.value = true;
  try { await axios.put(`/api/affiliates/${selectedAff.value.id}`, editForm.value); showEditModal.value = false; toast.success('Komisi berhasil diperbarui.'); load(); }
  catch (e) { toast.error(e.response?.data?.message || 'Gagal menyimpan.'); }
  saving.value = false;
};

const getAffLink = (code) => {
  return `${window.location.origin}/?ref=${code}`;
};

const copyLink = (aff) => {
  const link = getAffLink(aff.referral_code);
  navigator.clipboard.writeText(link).then(() => {
    toast.success('Link affiliate berhasil disalin!');
  }).catch(() => {
    const el = document.getElementById('link-' + aff.id);
    if (el) { el.select(); document.execCommand('copy'); toast.success('Link berhasil disalin!'); }
  });
};

const formatRupiah = (n) => n ? new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(n) : 'Rp 0';

onMounted(load);
</script>
<style src="./admin.css"></style>
