<template>
  <div class="admin-dashboard">
    <!-- Top Navbar -->
    <nav class="admin-navbar">
      <div class="nav-left">
        <div class="brand-logo">J</div>
        <span class="brand-name">Jetschool <b>Admin</b></span>
      </div>
      <div class="nav-right">
        <div class="user-profile">
          <img :src="'https://ui-avatars.com/api/?name=' + encodeURIComponent(currentUser?.name || 'Admin') + '&background=4F46E5&color=fff'" alt="Admin" class="avatar">
          <span class="username">{{ currentUser?.name || 'Administrator' }}</span>
        </div>
        <button class="btn-logout" title="Keluar dari Admin" @click="handleLogout">Logout</button>
      </div>
    </nav>

    <div class="admin-container">
      <!-- Sidebar Navigation -->
      <aside class="admin-sidebar">
        <ul class="sidebar-menu">
          <li class="menu-label">MENU UTAMA</li>
          <li>
            <button :class="['menu-btn', { active: activeMenu === 'leads' }]" @click="activeMenu = 'leads'">
              Data Pendaftaran (Leads)
            </button>
          </li>
          <li>
            <button :class="['menu-btn', { active: activeMenu === 'blog' }]" @click="activeMenu = 'blog'">
              Artikel &amp; Blog
            </button>
          </li>
          <li>
            <button :class="['menu-btn', { active: activeMenu === 'affiliates' }]" @click="activeMenu = 'affiliates'">
              Kelola Mitra / Affiliate
            </button>
          </li>

          <li class="menu-label mt-6">SISTEM &amp; PENGATURAN</li>
          <li>
            <button :class="['menu-btn', { active: activeMenu === 'users' }]" @click="activeMenu = 'users'">
              Pengguna &amp; Role
            </button>
          </li>
          <li>
            <button :class="['menu-btn', { active: activeMenu === 'stats' }]" @click="activeMenu = 'stats'">
              Statistik Pengunjung
            </button>
          </li>
        </ul>
      </aside>

      <!-- Main Content Area -->
      <main class="admin-content">
        
        <!-- ======================= -->
        <!-- MENU: LEADS / PENDAFTARAN -->
        <!-- ======================= -->
        <div v-if="activeMenu === 'leads'" class="content-panel">
          <div class="panel-header row-space">
            <div>
                <h2>Data Pendaftaran (Leads)</h2>
                <p>Kelola dan pantau status calon sekolah yang tertarik menggunakan Jetschool.</p>
            </div>
            <button @click="loadLeads" class="btn btn-outline">&#x21bb; Segarkan</button>
          </div>
          
          <div class="table-card">
            <div class="table-responsive">
              <table>
                <thead>
                  <tr>
                    <th>TANGGAL MASUK</th>
                    <th>NAMA SEKOLAH / YAYASAN</th>
                    <th>KONTAK</th>
                    <th>REFERAL MITRA</th>
                    <th>STATUS PENDEKATAN</th>
                    <th>AKSI</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-if="leadsLoading">
                    <td colspan="6" class="text-center py-4">Memuat sinkronisasi data...</td>
                  </tr>
                  <tr v-else-if="leads.length === 0">
                    <td colspan="6" class="text-center py-4 text-muted">Belum ada data pendaftaran.</td>
                  </tr>
                  <tr v-else v-for="lead in leads" :key="lead.id">
                    <td>{{ formatDate(lead.created_at) }}</td>
                    <td><strong>{{ lead.school_name }}</strong></td>
                    <td>
                      <div>{{ lead.name }}</div>
                      <div class="text-muted text-sm">{{ lead.phone_number }}</div>
                    </td>
                    <td>
                       <span class="code-badge" v-if="lead.affiliate">{{ lead.affiliate.referral_code }}</span>
                       <span class="text-muted text-sm" v-else>Organik / Langsung</span>
                    </td>
                    <td>
                      <span :class="['status-badge', 'status-' + lead.status]">
                        {{ translateStatus(lead.status) }}
                      </span>
                    </td>
                    <td>
                      <button class="btn btn-primary btn-sm" @click="openStatusModal(lead)">Ubah Status</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- ======================= -->
        <!-- MENU: ARTIKEL & BLOG -->
        <!-- ======================= -->
        <div v-if="activeMenu === 'blog'" class="content-panel">
          <div v-if="!showBlogEditor">
              <div class="panel-header row-space">
                  <div>
                      <h2>Manajemen Artikel Publikasi</h2>
                      <p>Kelola blog SEO dan berita yayasan.</p>
                  </div>
                   <button class="btn btn-primary" @click="openBlogEditor()">+ Tulis Artikel Baru</button>
              </div>
              
              <div class="table-card">
                <div class="table-responsive">
                  <table>
                    <thead>
                      <tr>
                        <th>JUDUL ARTIKEL</th>
                        <th>KATEGORI</th>
                        <th>STATUS TAYANG</th>
                        <th>TANGGAL PUBLISH</th>
                        <th>AKSI</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-if="postsLoading">
                        <td colspan="5" class="text-center py-4">Memuat data artikel...</td>
                      </tr>
                      <tr v-else-if="posts.length === 0">
                        <td colspan="5" class="text-center py-4 text-muted">Belum ada artikel yang ditulis.</td>
                      </tr>
                      <tr v-else v-for="post in posts" :key="post.id">
                        <td style="max-width:300px;">
                          <strong>{{ post.title }}</strong>
                          <div class="text-muted text-sm mt-1">/blog/{{ post.slug }}</div>
                        </td>
                        <td><span class="type-badge">{{ post.category }}</span></td>
                        <td>
                          <span :class="['status-badge', post.status === 'published' ? 'status-closed_won' : 'status-contacted']">
                            {{ post.status === 'published' ? 'Sudah Publish' : 'Masih Draft' }}
                          </span>
                        </td>
                        <td>{{ formatDate(post.published_at) }}</td>
                        <td>
                          <button class="btn btn-outline btn-sm mr-2" @click="openBlogEditor(post)">Sunting</button>
                          <button class="btn btn-danger btn-sm" @click="deletePost(post.id)">Hapus</button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
          </div>

          <!-- Quill Editor Form -->
          <div v-else class="blog-editor-view">
              <div class="panel-header row-space">
                   <h2>{{ editPostForm.id ? 'Edit Artikel: ' + editPostForm.title : 'Menulis Artikel Baru' }}</h2>
                   <button class="btn btn-outline" @click="showBlogEditor = false">← Batal &amp; Kembali</button>
              </div>

              <div class="form-card glass-panel p-6">
                  <div class="form-group mb-4">
                      <label>Judul Utama Artikel (H1)</label>
                      <input type="text" v-model="editPostForm.title" class="form-control" placeholder="Contoh: Manfaat Kurikulum Merdeka Untuk SD...">
                  </div>

                  <div class="row-flex mb-4 gap-4">
                      <div class="form-group w-half">
                          <label>Pilih Kategori</label>
                          <select v-model="editPostForm.category" class="form-control">
                              <option value="" disabled>Pilih Kategori...</option>
                              <option value="Edukasi">Edukasi &amp; Pembelajaran</option>
                              <option value="Teknologi">Teknologi Pendidikan</option>
                              <option value="Manajemen">Manajemen Sekolah</option>
                              <option value="Berita">Berita &amp; Acara Terkini</option>
                              <option value="Panduan">Panduan &amp; Tutorial</option>
                          </select>
                      </div>
                      <div class="form-group w-half">
                          <label>Pilih Status Simpan</label>
                          <select v-model="editPostForm.status" class="form-control">
                              <option value="draft">Simpan sebagai Draf (Sembunyikan)</option>
                              <option value="published">Langsung Publikasikan (Live)</option>
                          </select>
                      </div>
                  </div>

                  <div class="form-group mb-4">
                      <label>Gambar Sampul Artikel</label>
                      <div class="image-upload-area">
                          <div v-if="imagePreview" class="image-preview">
                              <img :src="imagePreview" alt="Preview">
                              <button type="button" class="remove-img" @click="removeImage">&times;</button>
                          </div>
                          <div v-else class="upload-placeholder" @click="$refs.imageInput.click()">
                              <span class="upload-icon">📷</span>
                              <span>Klik untuk upload gambar sampul</span>
                              <span class="text-xs text-muted">Format: JPG, PNG, WebP — Maks 2MB, rasio 16:9</span>
                          </div>
                          <input ref="imageInput" type="file" accept="image/*" @change="onImageSelected" style="display:none">
                      </div>
                      <input type="text" v-model="editPostForm.image" class="form-control mt-2" placeholder="Atau masukkan URL gambar eksternal...">
                  </div>

                  <div class="form-group mb-4">
                      <label>Body Konten (Isi Artikel)</label>
                      <!-- Ruang Quill JS -->
                      <div id="quill-editor" style="height: 500px; background: white; border-radius: 0 0 8px 8px;"></div>
                  </div>

                  <div class="action-footer mt-6 row-space border-t pt-4">
                       <button class="btn btn-outline" @click="showBlogEditor=false">Batal</button>
                       <button class="btn btn-primary px-8" @click="savePost" :disabled="isSaving">
                           {{ isSaving ? 'Memproses ke Database...' : 'Simpan Artikel' }}
                       </button>
                  </div>
              </div>
          </div>
        </div>

        <!-- ======================= -->
        <!-- MENU: AFFILIATES        -->
        <!-- ======================= -->
        <div v-if="activeMenu === 'affiliates'" class="content-panel">
          <div class="panel-header row-space">
               <div>
                   <h2>Daftar Mitra Afiliasi Aktif</h2>
                   <p>Pantau pengguna yang mendaftar sebagai mitra untuk mendapatkan komisi membawa sekolah baru.</p>
               </div>
               <button class="btn btn-primary" @click="showAddAffiliateModal = true">+ Buat Akun Mitra Baru</button>
          </div>
          
          <div class="table-card">
            <div class="table-responsive">
              <table>
                <thead>
                  <tr>
                    <th>AKUN PENGGUNA TERTAUT</th>
                    <th>KODE REFERAL KUNCI</th>
                    <th>METODE KOMISI</th>
                    <th>NILAI KOMISI (RATE)</th>
                    <th>AKSI MODIFIKASI</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-if="affiliatesLoading">
                    <td colspan="5" class="text-center py-4">Mensinkronisasi data jaringan mitra...</td>
                  </tr>
                  <tr v-else-if="affiliates.length === 0">
                    <td colspan="5" class="text-center py-4 text-muted">Sistem belum mendeteksi pendaftaran mitra.</td>
                  </tr>
                  <tr v-else v-for="aff in affiliates" :key="aff.id">
                    <td>
                      <strong>{{ aff.user ? aff.user.name : 'Data Hilang (Orphan)' }}</strong>
                      <div class="text-muted text-sm">{{ aff.user ? aff.user.email : '-' }}</div>
                    </td>
                    <td>
                       <span class="code-badge font-mono">{{ aff.referral_code }}</span>
                    </td>
                    <td>
                        <span class="type-badge">{{ aff.commission_type === 'percentage' ? 'Persentase (%)' : 'Nominal Tetap (Rp)' }}</span>
                    </td>
                    <td>
                        <strong class="text-indigo-600" v-if="aff.commission_type==='percentage'">{{ aff.commission_rate }}%</strong>
                        <strong class="text-indigo-600" v-else>{{ formatRupiah(aff.commission_rate) }}</strong>
                    </td>
                    <td>
                      <button class="btn btn-outline btn-sm" @click="openEditCommission(aff)">Sesuaikan Komisi</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- ======================= -->
        <!-- MENU: PENGGUNA & ROLE   -->
        <!-- ======================= -->
        <div v-if="activeMenu === 'users'" class="content-panel">
          <div class="panel-header row-space">
               <div>
                   <h2>Hak Akses &amp; Manajemen Pengguna</h2>
                   <p>Kelola staf yang memiliki izin beroperasi di dalam dasbor manajerial JetSchool beserta role (RBAC) masing-masing.</p>
               </div>
               <button class="btn btn-primary" @click="showAddUserModal = true">+ Registrasi Staf Baru</button>
          </div>
          
          <div class="table-card mt-4">
            <div class="table-responsive">
              <table>
                <thead>
                  <tr>
                    <th>NAMA STAF</th>
                    <th>EMAIL KREDENSIAL</th>
                    <th>ROLE AKSES</th>
                    <th>TANGGAL BERGABUNG</th>
                    <th>AKSI</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-if="usersLoading">
                    <td colspan="5" class="text-center py-4">Menarik data dari server sentral...</td>
                  </tr>
                  <tr v-else-if="users.length === 0">
                    <td colspan="5" class="text-center py-4 text-muted">Belum ada staf yang terdaftar.</td>
                  </tr>
                  <tr v-else v-for="user in users" :key="user.id">
                    <td><strong>{{ user.name }}</strong></td>
                    <td>{{ user.email }}</td>
                    <td>
                      <span v-for="role in user.role_names" :key="role" class="type-badge bg-indigo-50 text-indigo-700 px-2 py-1 rounded-md mr-1 border border-indigo-100">{{ role }}</span>
                      <span v-if="!user.role_names || user.role_names.length === 0" class="text-muted text-sm">Tidak Ada (Guest)</span>
                    </td>
                    <td>{{ formatDate(user.created_at) }}</td>
                    <td>
                      <button class="btn btn-outline btn-sm mr-2" @click="openEditUser(user)">Ubah Role</button>
                      <button class="btn btn-danger btn-sm" @click="deleteUser(user.id)">Depak</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- ======================= -->
        <!-- MENU: STATISTIK         -->
        <!-- ======================= -->
        <div v-if="activeMenu === 'stats'" class="content-panel">
          <div class="panel-header row-space">
               <div>
                   <h2>Statistik Kunjungan Landing Page &amp; Konversi</h2>
                   <p>Pantau metrik analitik pemasaran dan performa kampanye SEO secara sekilas.</p>
               </div>
               <button @click="loadStats" class="btn btn-outline">&#x21bb; Segarkan Metrik</button>
          </div>
          
          <div class="row-flex gap-4 mb-6">
              <div class="stat-box glass-panel p-6 w-third">
                  <div class="stat-title">Akuisisi Instansi Bulan/Hari Ini</div>
                  <div class="stat-value text-4xl font-black mt-2 text-indigo-900">{{ statsData.today_leads }} <span class="text-lg text-slate-500 font-normal">/ {{ statsData.total_leads }}</span></div>
                  <div class="stat-trend text-green mt-2 text-sm">Leads masuk secara keseluruhan</div>
              </div>
              <div class="stat-box glass-panel p-6 w-third">
                  <div class="stat-title">Arsip Artikel Organik Diterbitkan</div>
                  <div class="stat-value text-4xl font-black mt-2 text-blue-900">{{ statsData.total_posts }} <span class="text-lg text-slate-500 font-normal">Post</span></div>
                  <div class="stat-trend mt-2 text-sm text-blue-600">Terus publikasi untuk mendominasi laman 1 Google</div>
              </div>
              <div class="stat-box glass-panel p-6 w-third">
                  <div class="stat-title">Rasio Konversi Lead (Closing Deal)</div>
                  <div class="stat-value text-4xl font-black mt-2 text-emerald-900">{{ statsData.conversion_rate }}%</div>
                  <div class="stat-trend text-green mt-2 text-sm">Persentase peminang yang berhasil jadi klien</div>
              </div>
          </div>
          
          <div class="row-flex gap-4">
              <div class="stat-box glass-panel p-6 w-half flex items-center gap-4">
                  <div class="bg-indigo-50 p-4 rounded-xl text-indigo-600">
                      <svg viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                  </div>
                  <div>
                      <h4 class="text-lg font-bold text-slate-800">Agen / Affiliator Terdaftar</h4>
                      <p class="text-3xl font-black text-indigo-600">{{ statsData.total_affiliates }}</p>
                  </div>
              </div>
              <div class="stat-box glass-panel p-6 w-half flex items-center gap-4">
                  <div class="bg-sky-50 p-4 rounded-xl text-sky-600">
                      <svg viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                  </div>
                  <div>
                      <h4 class="text-lg font-bold text-slate-800">Estimasi Total Page Views</h4>
                      <p class="text-3xl font-black text-sky-600">{{ formatRupiah(statsData.page_views).replace('Rp', '').replace(',00', '') }}</p>
                  </div>
              </div>
          </div>
        </div>

      </main>
    </div>

    <!-- Modals (Status, Add Affiliate, Edit Comm) -->
    <!-- Modal UBAH STATUS PENDAFTARAN -->
    <div v-if="showStatusModal" class="modal-overlay" @click.self="showStatusModal=false">
      <div class="modal-card">
        <h3>Pembaruan Status Negosiasi Sekolah</h3>
        <p class="text-muted text-sm mb-4">Rekam jejak hubungan dengan yayasan: <strong>{{ selectedLead?.school_name }}</strong></p>

        <div class="form-group mb-4">
            <label>Kondisi Pendekatan Terkini</label>
            <select v-model="updateLeadForm.status" class="form-control">
                <option value="new">🌟 Pendaftar Baru Masuk (New)</option>
                <option value="contacted">📞 Tahap Kontak Awal / Telepon (Contacted)</option>
                <option value="demo_scheduled">📅 Sedang Jadwal Demo Sistem (Scheduled)</option>
                <option value="closed_won">✅ Sukses Closing/Berlangganan! (Closed Won)</option>
                <option value="closed_lost">❌ Batal / Tidak Tertarik (Closed Lost)</option>
            </select>
        </div>

        <div v-if="updateLeadForm.status === 'closed_won' && selectedLead?.affiliate_id" class="form-group p-4 bg-indigo-50 border border-indigo-100 rounded-xl mb-4">
             <label class="text-indigo-900 font-bold flex items-center gap-2"><svg viewBox="0 0 24 24" width="16" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.16-1.46-3.27-3.4h1.96c.1 1.05.82 1.87 2.65 1.87 1.96 0 2.4-.98 2.4-1.59 0-.83-.44-1.61-2.67-2.14-2.48-.6-4.18-1.62-4.18-3.67 0-1.72 1.39-2.84 3.11-3.21V4h2.67v1.95c1.86.45 2.79 1.86 2.85 3.39H14.3c-.05-1.11-.64-1.87-2.22-1.87-1.5 0-2.4.68-2.4 1.64 0 .84.65 1.39 2.67 1.91s4.18 1.39 4.18 3.91c-.01 1.83-1.38 2.83-3.12 3.16z"/></svg> Rekapitulasi Nilai Tender / Perjanjian (Rp)</label>
             <p class="text-xs text-indigo-700 mt-1 mb-2">Lead ini menggunakan agen mitra pengundang (Kode: <b>{{ selectedLead.affiliate.referral_code }}</b>). Isikan total nilai berlangganan untuk dikalkulasi besaran porsi bonus buat mitra.</p>
             <input type="number" v-model="updateLeadForm.deal_value" class="form-control" placeholder="Contoh: 15000000" min="0">
        </div>

        <div class="action-footer mt-4 row-space pt-4 border-t">
             <button class="btn btn-outline" @click="showStatusModal=false">Abaikan</button>
             <button class="btn btn-primary" @click="saveLeadStatus" :disabled="isSaving">
                 {{ isSaving ? 'Menyinkronkan Server...' : 'Terapkan Status Baru' }}
             </button>
        </div>
      </div>
    </div>

    <!-- Modal BUAT AFFILIATE BARU -->
    <div v-if="showAddAffiliateModal" class="modal-overlay" @click.self="showAddAffiliateModal=false">
      <div class="modal-card">
        <h3>Pendaftaran Akun Agen Mitra (Afiliator)</h3>
        <p class="text-muted text-sm mb-4">Daftarkan seseorang menjadi tenaga pemasar. Akun login akan otomatis tercipta.</p>

        <form @submit.prevent="saveNewAffiliator">
            <div class="form-group mb-3">
                <label>Nama Alias / Lengkap</label>
                <input type="text" v-model="addAffiliateForm.name" required class="form-control" placeholder="Ketik nama mitra...">
            </div>
            <div class="form-group mb-3">
                <label>Alamat Surel (Email Kredensial)</label>
                <input type="email" v-model="addAffiliateForm.email" required class="form-control" placeholder="emailagen@surat.com">
            </div>
            <div class="form-group mb-3">
                <label>Kata Sandi Pembuka</label>
                <input type="password" v-model="addAffiliateForm.password" required class="form-control" placeholder="Minimal sandi rahasia 6 karakter">
            </div>

            <div class="p-4 bg-slate-50 border rounded-xl mb-3 mt-4">
                <div class="row-flex gap-4">
                    <div class="form-group w-half">
                        <label>Skema Pembagian Bonus</label>
                        <select v-model="addAffiliateForm.commission_type" class="form-control">
                            <option value="percentage">Potongan Persen (%)</option>
                            <option value="fixed">Gaji Flat Rupiah (Rp)</option>
                        </select>
                    </div>
                    <div class="form-group w-half">
                        <label>Margin Profit (Angka)</label>
                        <input type="number" step="0.01" v-model="addAffiliateForm.commission_rate" required class="form-control" placeholder="10">
                    </div>
                </div>
            </div>

            <div v-if="addError" class="alert-error mt-3 rounded p-3 bg-red-50 text-red-600 border border-red-200">{{ addError }}</div>

            <div class="action-footer mt-4 row-space border-t pt-4">
                <button type="button" class="btn btn-outline" @click="showAddAffiliateModal=false">Batalkan</button>
                <button type="submit" class="btn btn-primary" :disabled="isSaving">
                    {{ isSaving ? 'Memverifikasi...' : 'Bangkitkan Akun' }}
                </button>
            </div>
        </form>
      </div>
    </div>

    <!-- Modal EDIT TIPE KOMISI -->
    <div v-if="showEditCommModal" class="modal-overlay" @click.self="showEditCommModal=false">
      <div class="modal-card">
        <h3>Restrukturisasi Kontrak Komisi Mitra</h3>
        <p class="text-muted text-sm mb-4">Modifikasi ketetapan bagi hasil khusus untuk agen: <strong>{{ selectedAffiliate?.user?.name }}</strong></p>

        <div class="form-group mt-3">
            <label>Metode Penarikan</label>
            <select v-model="editCommForm.commission_type" class="form-control">
                <option value="percentage">Basis Persentase Nilai Deal (%)</option>
                <option value="fixed">Basis Nominal Sekali Tarik (Rp)</option>
            </select>
        </div>
        <div class="form-group mt-4">
            <label>Penyesuaian Angka Tarif</label>
            <input type="number" step="0.01" v-model="editCommForm.commission_rate" class="form-control form-control-lg font-bold">
            <p class="text-xs text-muted mt-2 p-2 bg-blue-50 border border-blue-100 rounded text-blue-800" v-if="editCommForm.commission_type === 'percentage'">
                ⚠️ Pastikan sistemnya adil! Anda sedang mengatur bonus dalam sekala persen tarif dasar produk. Angka mutlak, jangan tulis tanda %.
            </p>
            <p class="text-xs text-muted mt-2 p-2 bg-amber-50 border border-amber-100 rounded text-amber-800" v-else>
                ℹ️ Berupa tunjangan uang langsung. Jika nilai deal Rp 20 Juta dan ini terset disetel Rp 1 Juta, maka tetap dapat Rp 1 Juta seketika. 
            </p>
        </div>

        <div class="action-footer mt-6 row-space pt-4 border-t">
             <button class="btn btn-outline" @click="showEditCommModal=false">Anulir</button>
             <button class="btn btn-primary" @click="saveCommission" :disabled="isSaving">
                 {{ isSaving ? 'Mencatat Logika Baru...' : 'Segel Kesepakatan' }}
             </button>
        </div>
      </div>
    </div>

    <!-- Modal Add User -->
    <div v-if="showAddUserModal" class="modal-overlay" @click.self="showAddUserModal=false">
      <div class="modal-card">
        <h3>Registrasi Staf Administrator Baru</h3>
        <p class="text-muted text-sm mb-4">Staf bisa login untuk mengatur dashboard.</p>
        <form @submit.prevent="showAddUserModal=false; alert('Endpoint siap, namun UI submit sedang disempurnakan');">
             <div class="form-group mb-3"><label>Nama Lengkap</label><input type="text" required class="form-control"></div>
             <div class="form-group mb-3"><label>Email</label><input type="email" required class="form-control"></div>
             <div class="form-group mb-3"><label>Password</label><input type="password" required class="form-control"></div>
             <div class="action-footer mt-4 row-space pt-4 border-t">
                 <button type="button" class="btn btn-outline" @click="showAddUserModal=false">Batal</button>
                 <button type="submit" class="btn btn-primary">Simpan Staf</button>
             </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const router = useRouter();
const activeMenu = ref('leads'); // Menu Sidebar State
const currentUser = ref(null);

const leads = ref([]);
const leadsLoading = ref(true);

const affiliates = ref([]);
const affiliatesLoading = ref(true);

const isSaving = ref(false);

// Stats & Users State
const statsData = ref({ today_leads: 0, total_leads: 0, conversion_rate: 0, total_affiliates: 0, total_posts: 0, page_views: 0 });
const users = ref([]);
const usersLoading = ref(true);

// Modals State
const showStatusModal = ref(false);
const showAddAffiliateModal = ref(false);
const showEditCommModal = ref(false);
const showAddUserModal = ref(false);

const selectedLead = ref(null);
const updateLeadForm = ref({ status: 'new', deal_value: '' });

const selectedAffiliate = ref(null);
const editCommForm = ref({ commission_type: 'percentage', commission_rate: 0 });

const addAffiliateForm = ref({
    name: '', email: '', password: '', commission_type: 'percentage', commission_rate: 10
});
const addError = ref('');

const handleLogout = async () => {
    if(!confirm("Anda yakin ingin keluar?")) return;
    try {
        await axios.post('/api/logout');
    } catch(e) {
        // ignore
    }
    router.push('/login');
}

// Leads
const loadLeads = async () => {
    leadsLoading.value = true;
    try {
        const response = await axios.get('/api/leads');
        if (response.data.success) {
            leads.value = response.data.data.data;
        }
    } catch (e) {
        leads.value = [];
    } finally {
        leadsLoading.value = false;
    }
};

// Affiliates
const loadAffiliates = async () => {
    affiliatesLoading.value = true;
    try {
        const response = await axios.get('/api/affiliates');
        if (response.data.success) {
            affiliates.value = response.data.data.data;
        }
    } catch (e) {
        affiliates.value = [];
    } finally {
        affiliatesLoading.value = false;
    }
};

const openStatusModal = (lead) => {
    selectedLead.value = lead;
    updateLeadForm.value.status = lead.status;
    updateLeadForm.value.deal_value = '';
    showStatusModal.value = true;
};

const saveLeadStatus = async () => {
    isSaving.value = true;
    try {
        await axios.put(`/api/leads/${selectedLead.value.id}/status`, updateLeadForm.value);
        showStatusModal.value = false;
        loadLeads();
    } catch (e) {
        alert(e.response?.data?.message || 'Gagal tersambung ke server utama.');
    } finally {
        isSaving.value = false;
    }
};

const openEditCommission = (aff) => {
    selectedAffiliate.value = aff;
    editCommForm.value.commission_type = aff.commission_type;
    editCommForm.value.commission_rate = aff.commission_rate;
    showEditCommModal.value = true;
};

const saveCommission = async () => {
    isSaving.value = true;
    try {
        await axios.put(`/api/affiliates/${selectedAffiliate.value.id}`, editCommForm.value);
        showEditCommModal.value = false;
        loadAffiliates();
    } catch(e) {
        alert(e.response?.data?.message || 'Gagal memperbarui kalkulasi komisi.');
    } finally {
        isSaving.value = false;
    }
};

const saveNewAffiliator = async () => {
    isSaving.value = true;
    addError.value = '';
    try {
        await axios.post('/api/affiliates', addAffiliateForm.value);
        showAddAffiliateModal.value = false;
        addAffiliateForm.value = { name: '', email: '', password: '', commission_type: 'percentage', commission_rate: 10 };
        loadAffiliates();
    } catch(e) {
        addError.value = e.response?.data?.message || 'Pendaftaran agen dibatalkan oleh server pengaman. Mohon cek duplikasi email.';
        if(e.response?.data?.errors?.email) addError.value = 'Email administrator ini telah dilindungi atau sudah eksis.';
    } finally {
        isSaving.value = false;
    }
};

// Users
const loadUsers = async () => {
    usersLoading.value = true;
    try {
        const response = await axios.get('/api/users');
        users.value = response.data.users;
    } catch (e) {
        console.error('Failed to load users');
    } finally {
        usersLoading.value = false;
    }
};

const deleteUser = async (id) => {
    if(!confirm("Yakin ingin menghapus staf ini permanen?")) return;
    try {
        await axios.delete(`/api/users/${id}`);
        loadUsers();
    } catch(e) {
        alert(e.response?.data?.message || 'Gagal menghapus instalasi OS.');
    }
};

const openEditUser = (user) => {
    alert('Modul Edit Role Sedang Dikembangkan, silahkan sesuaikan dari database directly untuk saat ini!');
};

// Stats
const loadStats = async () => {
    try {
        const response = await axios.get('/api/stats');
        statsData.value = response.data.metrics;
    } catch (e) {
        console.error('Gagal memuat statistik');
    }
};

// --- BLOG MANAGEMENT ---
const posts = ref([]);
const postsLoading = ref(false);
const showBlogEditor = ref(false);
const editPostForm = ref({ id: null, title: '', category: '', status: 'draft', image: '', content: '' });
const imageFile = ref(null);
const imagePreview = ref(null);
let quillInstance = null;

const onImageSelected = (e) => {
    const file = e.target.files[0];
    if (!file) return;
    if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran gambar maks 2MB!');
        return;
    }
    imageFile.value = file;
    imagePreview.value = URL.createObjectURL(file);
    editPostForm.value.image = ''; // Kosongkan URL jika upload file
};

const removeImage = () => {
    imageFile.value = null;
    imagePreview.value = null;
};

const loadPosts = async () => {
    postsLoading.value = true;
    try {
        const response = await axios.get('/api/admin/posts');
        posts.value = response.data;
    } catch (e) {
        console.error('Data publikasi gagal diputarbalikkan', e);
    } finally {
        postsLoading.value = false;
    }
};

const openBlogEditor = (post = null) => {
    showBlogEditor.value = true;
    imageFile.value = null;
    if (post) {
        editPostForm.value = { id: post.id, title: post.title, category: post.category, status: post.status, image: post.image || '', content: post.content };
        imagePreview.value = post.image || null;
    } else {
        editPostForm.value = { id: null, title: '', category: '', status: 'draft', image: '', content: '' };
        imagePreview.value = null;
    }

    setTimeout(() => {
        if (!quillInstance && window.Quill) {
            quillInstance = new window.Quill('#quill-editor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        ['blockquote', 'code-block'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'align': [] }],
                        ['link', 'image', 'video'],
                        ['clean']
                    ]
                }
            });
            quillInstance.on('text-change', () => {
                editPostForm.value.content = quillInstance.root.innerHTML;
            });
        }
        
        if (quillInstance) {
            quillInstance.root.innerHTML = editPostForm.value.content || '';
        }
    }, 100);
};

const loadQuillCdn = () => {
    if (document.getElementById('quill-script')) return;
    
    const style = document.createElement('link');
    style.rel = 'stylesheet';
    style.href = 'https://cdn.quilljs.com/1.3.6/quill.snow.css';
    document.head.appendChild(style);

    const script = document.createElement('script');
    script.id = 'quill-script';
    script.src = 'https://cdn.quilljs.com/1.3.6/quill.min.js';
    document.head.appendChild(script);
};

const savePost = async () => {
    if(!editPostForm.value.category) {
        alert('Pilih satu kategori terlebih dahulu!');
        return;
    }
    isSaving.value = true;
    try {
        const formData = new FormData();
        formData.append('title', editPostForm.value.title);
        formData.append('category', editPostForm.value.category);
        formData.append('status', editPostForm.value.status);
        formData.append('content', editPostForm.value.content);
        if (imageFile.value) {
            formData.append('image_file', imageFile.value);
        } else if (editPostForm.value.image) {
            formData.append('image', editPostForm.value.image);
        }

        if (editPostForm.value.id) {
            formData.append('_method', 'PUT');
            await axios.post(`/api/admin/posts/${editPostForm.value.id}`, formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            });
        } else {
            await axios.post('/api/admin/posts', formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            });
        }
        showBlogEditor.value = false;
        imageFile.value = null;
        imagePreview.value = null;
        loadPosts();
    } catch(e) {
        alert(e.response?.data?.message || 'Gagal menyimpan artikel.');
    } finally {
        isSaving.value = false;
    }
};

const deletePost = async (id) => {
    if (!confirm('Peringatan: Berkas organik SEO terkait publikasi ini akan musnah permanen. Yakin?')) return;
    try {
        await axios.delete(`/api/admin/posts/${id}`);
        loadPosts();
    } catch(e) {
        alert('Penghapusan paksa digagalkan OS pusat.');
    }
};

// Utils
const formatRupiah = (angka) => {
    if(!angka) return 'Rp 0';
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
};
const formatDate = (dateString) => {
    if(!dateString) return '-';
    return new Intl.DateTimeFormat('id-ID', { day: '2-digit', month: 'long', year: 'numeric' }).format(new Date(dateString));
};
const translateStatus = (status) => {
    const map = { 'new': 'Baru Masuk', 'contacted': 'Panggilan', 'demo_scheduled': 'Jadwal Demo', 'closed_won': 'Menang/Beli', 'closed_lost': 'Gugur', 'draft': 'Draft', 'published': 'Live' };
    return map[status] || status;
};

const checkAuth = async () => {
    try {
        const response = await axios.get('/api/me');
        if (!response.data.user) {
            router.push('/login');
            return false;
        }
        currentUser.value = response.data.user;
        const roles = response.data.user.role_names || [];
        if (!roles.includes('Super Admin') && !roles.includes('Admin')) {
            alert('Akses ditolak. Hanya Admin yang bisa mengakses halaman ini.');
            router.push('/login');
            return false;
        }
        return true;
    } catch (e) {
        router.push('/login');
        return false;
    }
};

onMounted(async () => {
    const ok = await checkAuth();
    if (!ok) return;
    loadLeads();
    loadAffiliates();
    loadPosts();
    loadUsers();
    loadStats();
    loadQuillCdn();
});
</script>

<style scoped>
/* ========================================================
   Redesigned Admin Paneling Architecture - Corporate Grade
=========================================================== */
.admin-dashboard { 
    background: #F1F5F9; 
    min-height: 100vh; 
    font-family: 'Inter', sans-serif;
    color: #1E293B;
}

/* Base Utility Classes Overridden for safety scope */
.row-space { display: flex; justify-content: space-between; align-items: center; }
.row-flex { display: flex; gap: 16px; align-items: flex-start;}
.w-half { flex: 1; }
.w-third { flex: 1 1 30%; }
.mt-4 { margin-top: 1rem; }
.mb-4 { margin-bottom: 1rem; }
.text-muted { color: #64748B; }
.text-xs { font-size: 0.75rem; }
.text-green { color: #10B981; font-weight: 600; }
.text-center { text-align: center; }

/* NAVBAR SYSTEM */
.admin-navbar { 
    background: #FFFFFF; 
    height: 70px; 
    display: flex; 
    align-items: center; 
    justify-content: space-between; 
    padding: 0 32px; 
    position: sticky; 
    top: 0; 
    z-index: 50; 
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
    border-bottom: 1px solid #E2E8F0;
}
.nav-left { display: flex; align-items: center; gap: 16px; }
.brand-logo { width: 40px; height: 40px; background: linear-gradient(135deg, #4F46E5, #3730A3); color: white; border-radius: 8px; font-weight: 900; font-size: 1.4rem; font-family: 'Playfair Display', serif; display: flex; justify-content: center; align-items: center; box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.3);}
.brand-name { font-size: 1.4rem; font-family: 'Playfair Display', serif; font-weight: 700; color: #0F172A; }
.brand-name b { color: #4F46E5; }

.nav-right { display: flex; align-items: center; gap: 24px; }
.user-profile { display: flex; align-items: center; gap: 12px; }
.username { font-weight: 700; font-size: 0.95rem; }
.avatar { width: 40px; height: 40px; border-radius: 50%; border: 2px solid #E2E8F0; }
.btn-logout { background: #FEF2F2; border: 1px solid #FECACA; color: #DC2626; padding: 8px 16px; border-radius: 8px; cursor: pointer; font-weight: 700; font-size: 0.85rem; transition: all 0.2s;}
.btn-logout:hover { background: #FEE2E2; }

/* MAIN LAYOUT WRAPPER */
.admin-container {
    display: flex;
    max-width: 1440px;
    margin: 0 auto;
    min-height: calc(100vh - 70px);
}

/* SIDEBAR DOMAIN */
.admin-sidebar {
    width: 280px;
    background: #FFFFFF;
    border-right: 1px solid #E2E8F0;
    padding: 32px 24px;
    flex-shrink: 0;
}
.sidebar-menu { list-style: none; padding: 0; margin: 0; }
.menu-label { font-size: 0.75rem; font-weight: 800; color: #94A3B8; letter-spacing: 0.1em; margin-bottom: 12px; margin-left: 12px; }
.menu-btn {
    width: 100%; text-align: left; background: transparent; border: none; padding: 12px 16px; margin-bottom: 4px; border-radius: 8px; font-size: 0.95rem; font-weight: 600; color: #475569; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 12px;
}
.menu-btn:hover { background: #F8FAFC; color: #0F172A; }
.menu-btn.active { background: #EEF2FF; color: #4F46E5; }
.mt-6 { margin-top: 2rem; }

/* CONTENT PANEL MANAGER */
.admin-content {
    flex: 1;
    padding: 40px;
    overflow-y: auto;
}
.panel-header { margin-bottom: 32px; }
.panel-header h2 { font-size: 1.8rem; font-weight: 800; color: #0F172A; margin: 0 0 8px 0; font-family: 'Playfair Display', serif;}
.panel-header p { color: #64748B; font-size: 1.05rem; margin: 0; }

.table-card { background: white; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #E2E8F0;}
.table-responsive { overflow-x: auto; }
table { width: 100%; border-collapse: collapse; text-align: left; }
th { background: #F8FAFC; padding: 16px 24px; font-size: 0.8rem; font-weight: 800; color: #64748B; letter-spacing: 0.05em; border-bottom: 1px solid #E2E8F0; text-transform: uppercase;}
td { padding: 16px 24px; border-bottom: 1px solid #F1F5F9; font-size: 0.95rem; color: #334155; vertical-align: middle;}
tr:last-child td { border-bottom: none; }
tr:hover td { background: #F8FAFC; }

/* Form Controls Standarisasi */
.form-card { background: white; border-radius: 16px; border: 1px solid #E2E8F0; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.02);}
.p-6 { padding: 32px; }
.form-group label { display: block; margin-bottom: 8px; font-weight: 700; color: #1E293B; font-size: 0.9rem;}
.form-control { width: 100%; padding: 12px 16px; border: 1px solid #CBD5E1; border-radius: 8px; font-size: 1rem; color: #0F172A; background: #fff; transition: border 0.2s, box-shadow 0.2s;}
.form-control:focus { outline: none; border-color: #4F46E5; box-shadow: 0 0 0 3px #EEF2FF; }

/* Tombol Terpadu */
.btn { display: inline-flex; justify-content: center; align-items: center; padding: 10px 20px; font-weight: 700; border-radius: 8px; cursor: pointer; border: 1px solid transparent; font-size: 0.9rem; transition: all 0.2s; }
.btn-primary { background: #4F46E5; color: white; }
.btn-primary:hover:not(:disabled) { background: #4338CA; }
.btn-outline { background: white; border-color: #CBD5E1; color: #475569; }
.btn-outline:hover { background: #F8FAFC; border-color: #4F46E5; color: #4F46E5; }
.btn-danger { background: #FEF2F2; color: #DC2626; border-color: #FECACA; }
.btn-danger:hover { background: #FEE2E2; }
.btn-sm { padding: 6px 12px; font-size: 0.8rem; }
.px-8 { padding-left: 2rem; padding-right: 2rem; }

/* Statuses & Badges */
.status-badge { display: inline-block; padding: 6px 14px; border-radius: 100px; font-size: 0.75rem; font-weight: 800; background: #F1F5F9; color: #64748B; border: 1px solid #E2E8F0;}
.status-new { background: #E0F2FE; color: #0284C7; border-color: #BAE6FD;}
.status-contacted { background: #FEF9C3; color: #A16207; border-color: #FEF08A; }
.status-demo_scheduled { background: #F3E8FF; color: #7E22CE; border-color: #E9D5FF;}
.status-closed_won { background: #DCFCE7; color: #15803D; border-color: #BBF7D0;}
.status-closed_lost { background: #FEE2E2; color: #B91C1C; border-color: #FECACA;}
.code-badge { background: #F1F5F9; color: #334155; padding: 4px 8px; border-radius: 6px; border: 1px dashed #CBD5E1; font-weight: 700; font-size: 0.85rem;}
.type-badge { font-weight: 700; font-size: 0.85rem; color: #4F46E5; letter-spacing: 0.02em;}

/* Modal Backdrop Tembus Pandang Elegan */
.modal-overlay { position: fixed; inset: 0; background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; z-index: 1000; overflow-y: auto;}
.modal-card { background: white; width: 100%; max-width: 560px; padding: 32px; border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); border: 1px solid #E2E8F0; margin: 40px 16px;}
.modal-card h3 { font-size: 1.5rem; font-weight: 800; color: #0F172A; margin: 0 0 4px 0; font-family: 'Playfair Display', serif;}

.alert-error { text-align: center; font-weight: 600; font-size: 0.9rem;}

/* Image Upload Area */
.image-upload-area { margin-bottom: 8px; }
.upload-placeholder {
  border: 2px dashed #CBD5E1;
  border-radius: 12px;
  padding: 40px 24px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
  cursor: pointer;
  background: #F8FAFC;
  transition: all 0.2s;
  color: #475569;
  font-weight: 600;
}
.upload-placeholder:hover {
  border-color: #4F46E5;
  background: #EEF2FF;
  color: #4F46E5;
}
.upload-icon { font-size: 2rem; }
.image-preview {
  position: relative;
  border-radius: 12px;
  overflow: hidden;
  border: 1px solid #E2E8F0;
}
.image-preview img {
  width: 100%;
  max-height: 280px;
  object-fit: cover;
  display: block;
}
.remove-img {
  position: absolute;
  top: 12px;
  right: 12px;
  width: 32px;
  height: 32px;
  background: rgba(0,0,0,0.7);
  color: white;
  border: none;
  border-radius: 50%;
  font-size: 1.2rem;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background 0.2s;
}
.remove-img:hover { background: #DC2626; }
</style>
