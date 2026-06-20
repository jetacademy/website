<template>
  <div class="page-panel">
    <div class="panel-header row-space">
      <div>
        <h2>Pengguna &amp; Role</h2>
        <p>Kelola staf yang memiliki akses ke panel admin beserta role RBAC masing-masing.</p>
      </div>
      <button class="btn btn-primary" @click="showAddModal = true">+ Tambah Staf</button>
    </div>

    <div class="table-card">
      <div class="table-responsive">
        <table>
          <thead>
            <tr>
              <th>NAMA</th>
              <th>EMAIL</th>
              <th>ROLE</th>
              <th>BERGABUNG</th>
              <th>AKSI</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="loading"><td colspan="5" class="text-center py-4">Memuat data...</td></tr>
            <tr v-else-if="users.length === 0"><td colspan="5" class="text-center py-4 text-muted">Belum ada pengguna.</td></tr>
            <tr v-else v-for="user in users" :key="user.id">
              <td><strong>{{ user.name }}</strong></td>
              <td>{{ user.email }}</td>
              <td>
                <span v-for="role in user.role_names" :key="role" class="role-tag">{{ role }}</span>
                <span v-if="!user.role_names || user.role_names.length === 0" class="text-muted text-sm">Belum diatur</span>
              </td>
              <td>{{ formatDate(user.created_at) }}</td>
              <td>
                <button class="btn btn-outline btn-sm mr-2" @click="openEditRole(user)">Ubah Role</button>
                <button class="btn btn-danger btn-sm" @click="deleteUser(user.id)">Hapus</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal Tambah Staf -->
    <div v-if="showAddModal" class="modal-overlay" @click.self="showAddModal=false">
      <div class="modal-card">
        <h3>Tambah Staf Baru</h3>
        <p class="text-muted text-sm mb-4">Staf dapat login dan mengakses panel admin.</p>
        <form @submit.prevent="saveNewUser">
          <div class="form-group mb-3"><label>Nama Lengkap</label><input type="text" v-model="addForm.name" required class="form-control"></div>
          <div class="form-group mb-3"><label>Email</label><input type="email" v-model="addForm.email" required class="form-control"></div>
          <div class="form-group mb-3"><label>Password</label><input type="password" v-model="addForm.password" required class="form-control" placeholder="Min 6 karakter"></div>
          <div class="form-group mb-3">
            <label>Role</label>
            <select v-model="addForm.role" class="form-control">
              <option v-for="r in availableRoles" :key="r" :value="r">{{ r }}</option>
            </select>
          </div>
          <div v-if="addError" class="text-center text-sm p-3 bg-red-50 text-red-600 rounded-xl border border-red-200 mb-3">{{ addError }}</div>
          <div class="action-footer mt-4 row-space border-t pt-4">
            <button type="button" class="btn btn-outline" @click="showAddModal=false">Batal</button>
            <button type="submit" class="btn btn-primary" :disabled="saving">{{ saving ? 'Memproses...' : 'Simpan' }}</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Modal Edit Role -->
    <div v-if="showEditModal" class="modal-overlay" @click.self="showEditModal=false">
      <div class="modal-card">
        <h3>Ubah Role</h3>
        <p class="text-muted text-sm mb-4">Pengguna: <strong>{{ selectedUser?.name }}</strong></p>
        <div class="form-group mb-4">
          <label>Role Baru</label>
          <select v-model="editRole" class="form-control">
            <option v-for="r in availableRoles" :key="r" :value="r">{{ r }}</option>
          </select>
        </div>
        <div class="action-footer mt-4 row-space border-t pt-4">
          <button class="btn btn-outline" @click="showEditModal=false">Batal</button>
          <button class="btn btn-primary" @click="saveRole" :disabled="saving">{{ saving ? 'Menyimpan...' : 'Simpan Role' }}</button>
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

const users = ref([]);
const availableRoles = ref(['Super Admin', 'Operator', 'Affiliator']);
const loading = ref(true);
const saving = ref(false);
const showAddModal = ref(false);
const showEditModal = ref(false);
const selectedUser = ref(null);
const editRole = ref('Operator');
const addError = ref('');
const addForm = ref({ name: '', email: '', password: '', role: 'Operator' });

const loadUsers = async () => {
  loading.value = true;
  try {
    const res = await axios.get('/api/users');
    users.value = res.data.users || [];
    if (res.data.available_roles?.length) availableRoles.value = res.data.available_roles;
  } catch { users.value = []; }
  loading.value = false;
};

const saveNewUser = async () => {
  saving.value = true; addError.value = '';
  try {
    await axios.post('/api/users', { ...addForm.value, roles: [addForm.value.role] });
    showAddModal.value = false;
    addForm.value = { name: '', email: '', password: '', role: 'Operator' };
    toast.success('Staf baru berhasil ditambahkan.');
    loadUsers();
  } catch (e) {
    addError.value = e.response?.data?.message || 'Gagal menambahkan staf.';
  }
  saving.value = false;
};

const openEditRole = (user) => {
  selectedUser.value = user;
  editRole.value = user.role_names?.[0] || 'Operator';
  showEditModal.value = true;
};

const saveRole = async () => {
  saving.value = true;
  try {
    await axios.put(`/api/users/${selectedUser.value.id}`, {
      name: selectedUser.value.name,
      email: selectedUser.value.email,
      roles: [editRole.value]
    });
    showEditModal.value = false;
    toast.success('Role berhasil diperbarui.');
    loadUsers();
  } catch (e) { toast.error(e.response?.data?.message || 'Gagal menyimpan.'); }
  saving.value = false;
};

const deleteUser = async (id) => {
  if (!confirm('Yakin ingin menghapus akun ini?')) return;
  try { await axios.delete(`/api/users/${id}`); toast.success('Pengguna berhasil dihapus.'); loadUsers(); }
  catch (e) { toast.error(e.response?.data?.message || 'Gagal menghapus.'); }
};

const formatDate = (d) => d ? new Intl.DateTimeFormat('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }).format(new Date(d)) : '-';

onMounted(loadUsers);
</script>

<style scoped>
.role-tag { display: inline-block; background: #EEF2FF; color: #4F46E5; padding: 4px 12px; border-radius: 6px; font-size: 0.8rem; font-weight: 700; margin-right: 4px; border: 1px solid #C7D2FE; }
</style>
