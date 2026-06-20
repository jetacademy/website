<template>
  <div class="page-panel">
    <div class="panel-header row-space">
      <div>
        <h2>Data Pendaftaran (Leads)</h2>
        <p>Kelola dan pantau status calon sekolah yang tertarik menggunakan Jetschool.</p>
      </div>
    </div>

    <div class="table-card">
      <div class="table-responsive">
        <table>
          <thead>
            <tr>
              <th>TANGGAL</th>
              <th>SEKOLAH / INSTANSI</th>
              <th>PENANGGUNG JAWAB</th>
              <th>NO. TELEPON</th>
              <th>STATUS</th>
              <th>SUMBER LEAD</th>
              <th>AKSI</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="loading">
              <td colspan="7" class="text-center py-4">Memuat data leads...</td>
            </tr>
            <tr v-else-if="leads.length === 0">
              <td colspan="7" class="text-center py-4 text-muted">Belum ada data pendaftaran.</td>
            </tr>
            <tr v-else v-for="lead in leads" :key="lead.id">
              <td>{{ formatDate(lead.created_at) }}</td>
              <td><strong>{{ lead.school_name }}</strong></td>
              <td>{{ lead.name }}</td>
              <td>{{ lead.phone_number }}</td>
              <td>
                <span :class="['status-badge', 'status-' + lead.status]">{{ translateStatus(lead.status) }}</span>
              </td>
              <td>
                <span v-if="lead.affiliate" class="code-badge">{{ lead.affiliate.referral_code }}</span>
                <span v-else class="text-muted text-sm">Organik</span>
              </td>
              <td>
                <button class="btn btn-outline btn-sm" @click="openStatusModal(lead)">Ubah Status</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal Ubah Status -->
    <div v-if="showStatusModal" class="modal-overlay" @click.self="showStatusModal=false">
      <div class="modal-card">
        <h3>Ubah Status Lead</h3>
        <p class="text-muted text-sm mb-4">Sekolah: <strong>{{ selectedLead?.school_name }}</strong></p>

        <div class="form-group mb-4">
          <label>Status Terkini</label>
          <select v-model="form.status" class="form-control">
            <option value="new">Baru Masuk</option>
            <option value="contacted">Sudah Dihubungi</option>
            <option value="demo_scheduled">Jadwal Demo</option>
            <option value="closed_won">Closing / Berlangganan</option>
            <option value="closed_lost">Batal / Tidak Tertarik</option>
          </select>
        </div>

        <div v-if="form.status === 'closed_won' && selectedLead?.affiliate_id" class="form-group mb-4 p-4 bg-indigo-50 rounded-xl border border-indigo-100">
          <label>Nilai Deal (Rp) — untuk kalkulasi komisi mitra</label>
          <input type="number" v-model="form.deal_value" class="form-control" placeholder="Contoh: 15000000" min="0">
        </div>

        <div class="action-footer mt-4 row-space pt-4 border-t">
          <button class="btn btn-outline" @click="showStatusModal=false">Batal</button>
          <button class="btn btn-primary" @click="saveStatus" :disabled="saving">
            {{ saving ? 'Menyimpan...' : 'Simpan Perubahan' }}
          </button>
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

const leads = ref([]);
const loading = ref(true);
const saving = ref(false);
const showStatusModal = ref(false);
const selectedLead = ref(null);
const form = ref({ status: 'new', deal_value: '' });

const loadLeads = async () => {
  loading.value = true;
  try {
    const res = await axios.get('/api/leads');
    leads.value = res.data.success ? (res.data.data.data || res.data.data) : [];
  } catch { leads.value = []; }
  loading.value = false;
};

const openStatusModal = (lead) => {
  selectedLead.value = lead;
  form.value = { status: lead.status, deal_value: '' };
  showStatusModal.value = true;
};

const saveStatus = async () => {
  saving.value = true;
  try {
    await axios.put(`/api/leads/${selectedLead.value.id}/status`, form.value);
    showStatusModal.value = false;
    toast.success('Status lead berhasil diperbarui.');
    loadLeads();
  } catch (e) {
    toast.error(e.response?.data?.message || 'Gagal menyimpan.');
  }
  saving.value = false;
};

const formatDate = (d) => d ? new Intl.DateTimeFormat('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }).format(new Date(d)) : '-';
const translateStatus = (s) => ({ new: 'Baru', contacted: 'Dihubungi', demo_scheduled: 'Demo', closed_won: 'Closing', closed_lost: 'Batal' })[s] || s;

onMounted(loadLeads);
</script>
<style src="./admin.css"></style>
