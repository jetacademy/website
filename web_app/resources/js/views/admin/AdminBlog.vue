<template>
  <div class="page-panel">
    <!-- List View -->
    <div v-if="!showEditor">
      <div class="panel-header row-space">
        <div>
          <h2>Blog &amp; Artikel</h2>
          <p>Kelola konten SEO dan artikel untuk memperkuat kehadiran Jetschool.</p>
        </div>
        <button class="btn btn-primary" @click="openEditor()">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Tulis Artikel
        </button>
      </div>

      <!-- Filters & Search -->
      <div class="filter-bar">
        <div class="search-box">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input type="text" v-model="filters.search" placeholder="Cari judul artikel..." @input="debouncedSearch">
        </div>
        <div class="filter-group">
          <select v-model="filters.status" @change="loadPosts(1)" class="filter-select">
            <option value="">Semua Status</option>
            <option value="published">Published</option>
            <option value="draft">Draft</option>
          </select>
          <select v-model="filters.category" @change="loadPosts(1)" class="filter-select">
            <option value="">Semua Kategori</option>
            <option value="Edukasi">Edukasi</option>
            <option value="Teknologi">Teknologi</option>
            <option value="Manajemen">Manajemen</option>
            <option value="Berita">Berita</option>
            <option value="Panduan">Panduan</option>
          </select>
        </div>
      </div>

      <!-- Stats Summary -->
      <div class="blog-stats">
        <div class="stat-pill">
          <span class="stat-pill-value">{{ pagination.total }}</span>
          <span class="stat-pill-label">Total</span>
        </div>
        <div class="stat-pill stat-pill-green">
          <span class="stat-pill-value">{{ countPublished }}</span>
          <span class="stat-pill-label">Published</span>
        </div>
        <div class="stat-pill stat-pill-yellow">
          <span class="stat-pill-value">{{ countDraft }}</span>
          <span class="stat-pill-label">Draft</span>
        </div>
      </div>

      <!-- Posts Table -->
      <div class="table-card">
        <div class="table-responsive">
          <table>
            <thead>
              <tr>
                <th>ARTIKEL</th>
                <th>KATEGORI</th>
                <th>STATUS</th>
                <th>TANGGAL</th>
                <th style="text-align:right">AKSI</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="loading">
                <td colspan="5" class="text-center py-4">
                  <div class="table-loader"><span class="dot-pulse"></span> Memuat artikel...</div>
                </td>
              </tr>
              <tr v-else-if="posts.length === 0">
                <td colspan="5" class="text-center py-4">
                  <div class="empty-state-inline">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#94A3B8" stroke-width="1.5"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    <p>Belum ada artikel yang cocok.</p>
                  </div>
                </td>
              </tr>
              <tr v-else v-for="post in posts" :key="post.id">
                <td>
                  <div class="post-cell">
                    <div class="post-thumb" v-if="post.image">
                      <img :src="post.image" :alt="post.title">
                    </div>
                    <div class="post-thumb post-thumb-empty" v-else>
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    </div>
                    <div>
                      <strong class="post-title">{{ post.title }}</strong>
                      <div class="post-slug">/blog/{{ post.slug }}</div>
                    </div>
                  </div>
                </td>
                <td><span class="category-badge">{{ post.category || '-' }}</span></td>
                <td>
                  <span :class="['status-badge', post.status === 'published' ? 'status-closed_won' : 'status-contacted']">
                    {{ post.status === 'published' ? 'Published' : 'Draft' }}
                  </span>
                </td>
                <td class="date-cell">{{ formatDate(post.published_at || post.created_at) }}</td>
                <td style="text-align:right">
                  <div class="action-btns">
                    <button class="btn btn-outline btn-sm" @click="openEditor(post)" title="Edit">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </button>
                    <button class="btn btn-danger btn-sm" @click="deletePost(post.id)" title="Hapus">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div v-if="pagination.lastPage > 1" class="pagination-bar">
          <div class="pagination-info">
            Menampilkan {{ pagination.from }}–{{ pagination.to }} dari {{ pagination.total }} artikel
          </div>
          <div class="pagination-controls">
            <button class="page-btn" :disabled="pagination.currentPage <= 1" @click="loadPosts(pagination.currentPage - 1)">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <template v-for="page in visiblePages" :key="page">
              <button v-if="page === '...'" class="page-btn page-ellipsis" disabled>...</button>
              <button v-else :class="['page-btn', { active: page === pagination.currentPage }]" @click="loadPosts(page)">{{ page }}</button>
            </template>
            <button class="page-btn" :disabled="pagination.currentPage >= pagination.lastPage" @click="loadPosts(pagination.currentPage + 1)">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Editor View -->
    <div v-else class="editor-view">
      <div class="panel-header row-space">
        <h2>{{ form.id ? 'Edit Artikel' : 'Tulis Artikel Baru' }}</h2>
        <button class="btn btn-outline" @click="showEditor = false">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
          Kembali
        </button>
      </div>

      <div class="form-card p-6">
        <div class="form-group mb-4">
          <label>Judul Artikel</label>
          <input type="text" v-model="form.title" class="form-control" placeholder="Contoh: Manfaat Kurikulum Merdeka...">
        </div>

        <div class="row-flex mb-4 gap-4">
          <div class="form-group w-half">
            <label>Kategori</label>
            <select v-model="form.category" class="form-control">
              <option value="" disabled>Pilih Kategori...</option>
              <option value="Edukasi">Edukasi &amp; Pembelajaran</option>
              <option value="Teknologi">Teknologi Pendidikan</option>
              <option value="Manajemen">Manajemen Sekolah</option>
              <option value="Berita">Berita &amp; Acara</option>
              <option value="Panduan">Panduan &amp; Tutorial</option>
            </select>
          </div>
          <div class="form-group w-half">
            <label>Status</label>
            <select v-model="form.status" class="form-control">
              <option value="draft">Draft</option>
              <option value="published">Published</option>
            </select>
          </div>
        </div>

        <!-- Image Upload -->
        <div class="form-group mb-4">
          <label>Gambar Sampul</label>
          <div class="image-upload-area">
            <div v-if="imagePreview" class="image-preview">
              <img :src="imagePreview" alt="Preview sampul">
              <button type="button" class="remove-img" @click="removeImage">&times;</button>
            </div>
            <div v-else class="upload-placeholder" @click="triggerFileInput">
              <span style="font-size:2rem">📷</span>
              <span>Klik untuk upload gambar sampul</span>
              <span class="text-xs text-muted">JPG, PNG, WebP — Maks 2MB, rasio 16:9</span>
            </div>
            <input ref="imageInput" type="file" accept="image/*" @change="onImageSelected" style="display:none">
          </div>
          <input type="text" v-model="form.image" class="form-control mt-2" placeholder="Atau masukkan URL gambar eksternal...">
        </div>

        <!-- Quill Editor -->
        <div class="form-group mb-4">
          <label>Isi Artikel</label>
          <div id="quill-editor" style="height:400px;background:#fff;border-radius:0 0 8px 8px"></div>
        </div>

        <div class="action-footer mt-4 row-space border-t pt-4">
          <button class="btn btn-outline" @click="showEditor=false">Batal</button>
          <button class="btn btn-primary px-8" @click="savePost" :disabled="saving">
            {{ saving ? 'Menyimpan...' : 'Simpan Artikel' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, nextTick } from 'vue';
import axios from 'axios';
import { useToast } from '../../composables/useToast';

const toast = useToast();

const posts = ref([]);
const loading = ref(true);
const saving = ref(false);
const showEditor = ref(false);
const form = ref({ id: null, title: '', category: '', status: 'draft', image: '', content: '' });
const imageFile = ref(null);
const imagePreview = ref(null);
const imageInput = ref(null);
let quillInstance = null;

// Pagination state
const pagination = ref({
  currentPage: 1,
  lastPage: 1,
  total: 0,
  from: 0,
  to: 0,
  perPage: 10,
});

// Filters
const filters = ref({
  search: '',
  status: '',
  category: '',
});

// Counts
const countPublished = ref(0);
const countDraft = ref(0);

// Debounce search
let searchTimeout = null;
const debouncedSearch = () => {
  clearTimeout(searchTimeout);
  searchTimeout = setTimeout(() => loadPosts(1), 400);
};

// Compute visible page numbers
const visiblePages = computed(() => {
  const current = pagination.value.currentPage;
  const last = pagination.value.lastPage;
  const pages = [];

  if (last <= 7) {
    for (let i = 1; i <= last; i++) pages.push(i);
    return pages;
  }

  pages.push(1);
  if (current > 3) pages.push('...');

  const start = Math.max(2, current - 1);
  const end = Math.min(last - 1, current + 1);
  for (let i = start; i <= end; i++) pages.push(i);

  if (current < last - 2) pages.push('...');
  pages.push(last);

  return pages;
});

const loadPosts = async (page = 1) => {
  loading.value = true;
  try {
    const params = {
      page,
      per_page: pagination.value.perPage,
    };
    if (filters.value.search) params.search = filters.value.search;
    if (filters.value.status) params.status = filters.value.status;
    if (filters.value.category) params.category = filters.value.category;

    const res = await axios.get('/api/admin/posts', { params });
    const data = res.data;

    posts.value = data.data;
    pagination.value = {
      currentPage: data.current_page,
      lastPage: data.last_page,
      total: data.total,
      from: data.from || 0,
      to: data.to || 0,
      perPage: data.per_page,
    };

    // Count published/draft from total (approximate from current filter)
    if (!filters.value.status) {
      countPublished.value = posts.value.filter(p => p.status === 'published').length;
      countDraft.value = posts.value.filter(p => p.status === 'draft').length;
      // If on first page with no filter, use total for better accuracy
      if (page === 1 && !filters.value.search && !filters.value.category) {
        // We'll do a quick count from the data
        countPublished.value = data.data.filter(p => p.status === 'published').length;
        countDraft.value = data.data.filter(p => p.status === 'draft').length;
      }
    }
  } catch {
    posts.value = [];
  }
  loading.value = false;
};

const openEditor = (post = null) => {
  showEditor.value = true;
  imageFile.value = null;
  if (post) {
    form.value = { id: post.id, title: post.title, category: post.category, status: post.status, image: post.image || '', content: post.content };
    imagePreview.value = post.image || null;
  } else {
    form.value = { id: null, title: '', category: '', status: 'draft', image: '', content: '' };
    imagePreview.value = null;
  }
  nextTick(() => {
    setTimeout(() => initQuill(), 150);
  });
};

const initQuill = () => {
  const el = document.getElementById('quill-editor');
  if (!el || !window.Quill) return;
  if (quillInstance) { quillInstance.root.innerHTML = form.value.content || ''; return; }
  quillInstance = new window.Quill('#quill-editor', {
    theme: 'snow',
    modules: {
      toolbar: [
        [{ header: [1, 2, 3, false] }],
        ['bold', 'italic', 'underline', 'strike'],
        ['blockquote', 'code-block'],
        [{ list: 'ordered' }, { list: 'bullet' }],
        [{ align: [] }],
        ['link', 'image', 'video'],
        ['clean']
      ]
    }
  });
  quillInstance.on('text-change', () => { form.value.content = quillInstance.root.innerHTML; });
  quillInstance.root.innerHTML = form.value.content || '';
};

const triggerFileInput = () => { imageInput.value?.click(); };
const onImageSelected = (e) => {
  const file = e.target.files[0];
  if (!file) return;
  if (file.size > 2 * 1024 * 1024) { toast.error('Ukuran gambar maksimal 2MB!'); return; }
  imageFile.value = file;
  imagePreview.value = URL.createObjectURL(file);
  form.value.image = '';
};
const removeImage = () => { imageFile.value = null; imagePreview.value = null; };

const savePost = async () => {
  if (!form.value.title.trim()) { toast.error('Judul artikel wajib diisi!'); return; }
  if (!form.value.category) { toast.error('Pilih kategori terlebih dahulu!'); return; }
  saving.value = true;
  try {
    const fd = new FormData();
    fd.append('title', form.value.title);
    fd.append('category', form.value.category);
    fd.append('status', form.value.status);
    fd.append('content', form.value.content);
    if (imageFile.value) fd.append('image_file', imageFile.value);
    else if (form.value.image) fd.append('image', form.value.image);

    if (form.value.id) {
      fd.append('_method', 'PUT');
      await axios.post(`/api/admin/posts/${form.value.id}`, fd, { headers: { 'Content-Type': 'multipart/form-data' } });
    } else {
      await axios.post('/api/admin/posts', fd, { headers: { 'Content-Type': 'multipart/form-data' } });
    }
    showEditor.value = false;
    imageFile.value = null;
    imagePreview.value = null;
    toast.success('Artikel berhasil disimpan!');
    loadPosts(pagination.value.currentPage);
  } catch (e) { toast.error(e.response?.data?.message || 'Gagal menyimpan artikel.'); }
  saving.value = false;
};

const deletePost = async (id) => {
  if (!confirm('Yakin ingin menghapus artikel ini?')) return;
  try {
    await axios.delete(`/api/admin/posts/${id}`);
    toast.success('Artikel berhasil dihapus.');
    // If last item on page, go back one page
    if (posts.value.length === 1 && pagination.value.currentPage > 1) {
      loadPosts(pagination.value.currentPage - 1);
    } else {
      loadPosts(pagination.value.currentPage);
    }
  } catch { toast.error('Gagal menghapus artikel.'); }
};

const formatDate = (d) => d ? new Intl.DateTimeFormat('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }).format(new Date(d)) : '-';

onMounted(() => {
  loadPosts();
  // Load Quill CDN
  if (!document.getElementById('quill-css')) {
    const css = document.createElement('link');
    css.id = 'quill-css';
    css.rel = 'stylesheet';
    css.href = 'https://cdn.quilljs.com/1.3.6/quill.snow.css';
    document.head.appendChild(css);
  }
  if (!document.getElementById('quill-js')) {
    const js = document.createElement('script');
    js.id = 'quill-js';
    js.src = 'https://cdn.quilljs.com/1.3.6/quill.min.js';
    document.head.appendChild(js);
  }
});
</script>

<style src="./admin.css"></style>
<style scoped>
/* ═══ FILTER BAR ═══ */
.filter-bar {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 20px;
  flex-wrap: wrap;
}

.search-box {
  display: flex;
  align-items: center;
  gap: 10px;
  background: #fff;
  border: 1.5px solid #E2E8F0;
  border-radius: 10px;
  padding: 0 14px;
  height: 40px;
  flex: 1;
  min-width: 200px;
  max-width: 320px;
  transition: border-color 0.2s, box-shadow 0.2s;
}

.search-box:focus-within {
  border-color: #6366F1;
  box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.08);
}

.search-box svg {
  color: #94A3B8;
  flex-shrink: 0;
}

.search-box input {
  border: none;
  outline: none;
  background: transparent;
  font-size: 0.88rem;
  color: #1E293B;
  width: 100%;
  height: 100%;
}

.search-box input::placeholder {
  color: #94A3B8;
}

.filter-group {
  display: flex;
  gap: 8px;
}

.filter-select {
  height: 40px;
  padding: 0 12px;
  border: 1.5px solid #E2E8F0;
  border-radius: 10px;
  background: #fff;
  font-size: 0.85rem;
  font-weight: 600;
  color: #475569;
  cursor: pointer;
  transition: border-color 0.2s;
  appearance: auto;
}

.filter-select:focus {
  outline: none;
  border-color: #6366F1;
}

/* ═══ BLOG STATS ═══ */
.blog-stats {
  display: flex;
  gap: 10px;
  margin-bottom: 20px;
}

.stat-pill {
  display: flex;
  align-items: center;
  gap: 8px;
  background: #fff;
  border: 1px solid #E2E8F0;
  border-radius: 100px;
  padding: 6px 16px;
}

.stat-pill-value {
  font-weight: 800;
  font-size: 0.95rem;
  color: #0F172A;
}

.stat-pill-label {
  font-size: 0.78rem;
  font-weight: 600;
  color: #64748B;
}

.stat-pill-green .stat-pill-value { color: #059669; }
.stat-pill-green { border-color: #BBF7D0; background: #F0FDF4; }
.stat-pill-yellow .stat-pill-value { color: #D97706; }
.stat-pill-yellow { border-color: #FDE68A; background: #FFFBEB; }

/* ═══ POST CELL ═══ */
.post-cell {
  display: flex;
  align-items: center;
  gap: 14px;
}

.post-thumb {
  width: 48px;
  height: 48px;
  border-radius: 10px;
  overflow: hidden;
  flex-shrink: 0;
  border: 1px solid #E2E8F0;
}

.post-thumb img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.post-thumb-empty {
  display: flex;
  align-items: center;
  justify-content: center;
  background: #F8FAFC;
  color: #94A3B8;
}

.post-title {
  font-size: 0.9rem;
  font-weight: 700;
  color: #0F172A;
  display: block;
  max-width: 280px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.post-slug {
  font-size: 0.75rem;
  color: #94A3B8;
  margin-top: 2px;
  font-family: 'JetBrains Mono', monospace;
}

.category-badge {
  font-weight: 700;
  font-size: 0.8rem;
  color: #6366F1;
  background: #EEF2FF;
  padding: 4px 10px;
  border-radius: 6px;
}

.date-cell {
  font-size: 0.82rem;
  color: #64748B;
  white-space: nowrap;
}

.action-btns {
  display: flex;
  gap: 6px;
  justify-content: flex-end;
}

/* ═══ PAGINATION ═══ */
.pagination-bar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 16px 20px;
  border-top: 1px solid #F1F5F9;
  background: #FAFBFC;
}

.pagination-info {
  font-size: 0.82rem;
  color: #64748B;
  font-weight: 600;
}

.pagination-controls {
  display: flex;
  align-items: center;
  gap: 4px;
}

.page-btn {
  width: 34px;
  height: 34px;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 1px solid #E2E8F0;
  border-radius: 8px;
  background: #fff;
  color: #475569;
  font-size: 0.82rem;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.15s;
}

.page-btn:hover:not(:disabled):not(.active) {
  border-color: #6366F1;
  color: #6366F1;
  background: #EEF2FF;
}

.page-btn.active {
  background: #6366F1;
  border-color: #6366F1;
  color: #fff;
}

.page-btn:disabled {
  opacity: 0.4;
  cursor: not-allowed;
}

.page-ellipsis {
  border: none;
  background: transparent;
  color: #94A3B8;
}

/* ═══ TABLE LOADER ═══ */
.table-loader {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  color: #64748B;
  font-weight: 600;
  font-size: 0.88rem;
  padding: 20px 0;
}

.dot-pulse {
  width: 8px;
  height: 8px;
  background: #6366F1;
  border-radius: 50%;
  animation: dotPulse 1s ease-in-out infinite;
}

@keyframes dotPulse {
  0%, 100% { transform: scale(1); opacity: 1; }
  50% { transform: scale(1.5); opacity: 0.5; }
}

.empty-state-inline {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
  padding: 24px 0;
}

.empty-state-inline p {
  color: #94A3B8;
  font-weight: 600;
  font-size: 0.88rem;
  margin: 0;
}

/* ═══ RESPONSIVE ═══ */
@media (max-width: 768px) {
  .filter-bar {
    flex-direction: column;
    align-items: stretch;
  }

  .search-box {
    max-width: none;
  }

  .filter-group {
    flex-wrap: wrap;
  }

  .blog-stats {
    flex-wrap: wrap;
  }

  .post-thumb {
    width: 40px;
    height: 40px;
  }

  .post-title {
    max-width: 160px;
  }

  .pagination-bar {
    flex-direction: column;
    gap: 12px;
    align-items: center;
  }

  .pagination-info {
    text-align: center;
  }
}

@media (max-width: 480px) {
  .post-thumb {
    display: none;
  }

  .post-title {
    max-width: 140px;
  }

  .page-btn {
    width: 30px;
    height: 30px;
    font-size: 0.75rem;
  }
}
</style>
