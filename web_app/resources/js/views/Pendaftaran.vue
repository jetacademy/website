<template>
  <div class="pendaftaran-view">
    <!-- Hero Section -->
    <section class="hero-section text-center">
      <div class="container">
        <span class="overline">Kemitraan Sekolah</span>
        <h1 class="hero-title text-gradient">Langkah Mudah Bergabung Jetschool</h1>
        <p class="hero-subtitle">
          Temukan timeline pendaftaran sekolah mitra baru, ikuti prosedurnya, dan dapatkan jawaban lengkap seputar ekosistem digital Jetschool.
        </p>
      </div>
    </section>

    <!-- Main Content Grid -->
    <section class="content-section">
      <div class="container grid-container">
        
        <!-- Timeline Side -->
        <div class="timeline-container">
          <h2 class="section-title">Timeline Pendaftaran</h2>
          <p class="section-desc">Ikuti tahapan-tahapan berikut untuk memulai transformasi digital di sekolah Anda.</p>
          
          <div class="timeline-flow" v-if="timelinesList.length > 0">
            <div 
              v-for="(item, index) in timelinesList" 
              :key="item.id || index" 
              class="timeline-item"
            >
              <div class="timeline-marker">
                <span class="marker-dot"></span>
                <span class="marker-line" v-if="index < timelinesList.length - 1"></span>
              </div>
              <div class="timeline-card">
                <div class="timeline-date">{{ item.date }}</div>
                <h3 class="timeline-title">{{ item.title }}</h3>
                <p class="timeline-text">{{ item.description }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Form Side -->
        <div class="form-container">
          <div class="register-card">
            <h3>Ajukan Pendaftaran Sekolah</h3>
            <p>Isi formulir di bawah ini untuk menjadwalkan sesi presentasi & demo trial gratis bersama tim ahli Jetschool.</p>
            
            <form @submit.prevent="submitLead" class="register-form" v-if="!registrationSuccess">
              <div class="form-group">
                <label for="name">Nama Lengkap Penanggung Jawab <span class="required">*</span></label>
                <input type="text" id="name" v-model="form.name" required placeholder="Contoh: Drs. H. Ahmad Fauzi" class="form-input">
              </div>
              
              <div class="form-group">
                <label for="school">Nama Sekolah / Yayasan <span class="required">*</span></label>
                <input type="text" id="school" v-model="form.school_name" required placeholder="Contoh: SMA Negeri 1 Utama" class="form-input">
              </div>

              <div class="form-group">
                <label for="phone">Nomor WhatsApp Aktif <span class="required">*</span></label>
                <input type="tel" id="phone" v-model="form.phone_number" required placeholder="Contoh: 081234567890" class="form-input">
              </div>

              <div class="form-group">
                <label for="role">Jabatan Anda <span class="required">*</span></label>
                <select id="role" v-model="form.role" class="form-input">
                  <option value="Yayasan">Ketua / Pengurus Yayasan</option>
                  <option value="Kepala Sekolah">Kepala Sekolah</option>
                  <option value="Wakasek">Wakil Kepala Sekolah</option>
                  <option value="Admin">Operator / Admin IT Sekolah</option>
                  <option value="Lainnya">Lainnya</option>
                </select>
              </div>

              <div class="form-group">
                <label for="students">Estimasi Jumlah Siswa <span class="required">*</span></label>
                <select id="students" v-model="form.student_estimate" class="form-input">
                  <option value="< 200">Kurang dari 200 siswa</option>
                  <option value="200 - 500">200 - 500 siswa</option>
                  <option value="500 - 1000">500 - 1000 siswa</option>
                  <option value="> 1000">Lebih dari 1000 siswa</option>
                </select>
              </div>

              <div class="form-group">
                <label for="heard_from">Tahu Asrama/Jetschool dari mana? <span class="required">*</span></label>
                <select id="heard_from" v-model="form.heard_from" required class="form-input">
                  <option value="" disabled>Pilih salah satu...</option>
                  <option value="Rekomendasi Teman / Kolega">Rekomendasi Teman / Kolega</option>
                  <option value="Instagram / Media Sosial">Instagram / Media Sosial</option>
                  <option value="Google Search / Internet">Google Search / Internet</option>
                  <option value="Brosur / Spanduk">Brosur / Spanduk</option>
                  <option value="Event / Pameran / Seminar">Event / Pameran / Seminar</option>
                  <option value="Lainnya">Lainnya</option>
                </select>
              </div>

              <button type="submit" class="btn btn-primary w-full" :disabled="submitting">
                {{ submitting ? 'Memproses...' : 'Kirim Pengajuan Pendaftaran' }}
              </button>
            </form>

            <div class="success-message" v-if="registrationSuccess">
              <span class="success-icon">✓</span>
              <div>
                <h4>Pengajuan Berhasil Dikirim!</h4>
                <p>Terima kasih. Pengajuan Anda telah kami terima. Tim Jetschool akan segera menghubungi Anda dalam waktu 1x24 jam.</p>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
      <div class="container max-w-4xl">
        <div class="text-center mb-12">
          <span class="overline">TANYA JAWAB</span>
          <h2 class="section-title">FAQ Seputar Pendaftaran</h2>
          <p class="section-desc">Punya pertanyaan? Temukan jawabannya di bawah ini atau tanyakan langsung melalui layanan bantuan kami.</p>
        </div>

        <div class="faq-accordion" v-if="faqsList.length > 0">
          <div 
            v-for="(item, index) in faqsList" 
            :key="item.id || index" 
            :class="['faq-item', { active: activeFaqIndex === index }]"
            @click="toggleFaq(index)"
          >
            <div class="faq-question">
              <h4>{{ item.question }}</h4>
              <span class="faq-toggle-icon">{{ activeFaqIndex === index ? '−' : '+' }}</span>
            </div>
            <div class="faq-answer-wrapper" v-if="activeFaqIndex === index">
              <div class="faq-answer">
                <p>{{ item.answer }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import axios from 'axios';

const timelines = ref([]);
const faqs = ref([]);
const loading = ref(true);

const form = reactive({
  name: '',
  school_name: '',
  phone_number: '',
  role: 'Yayasan',
  student_estimate: '200 - 500',
  heard_from: ''
});

const submitting = ref(false);
const registrationSuccess = ref(false);
const activeFaqIndex = ref(null);

const getReferralCode = () => {
  const cachedRef = localStorage.getItem('jetschool_affiliate_ref');
  if (cachedRef) {
    try {
      const parsedData = JSON.parse(cachedRef);
      if (new Date().getTime() < parsedData.expires) {
        return parsedData.code;
      }
    } catch (e) {}
  }
  return null;
};

const loadData = async () => {
  loading.value = true;
  try {
    const res = await axios.get('/api/pendaftaran');
    if (res.data.success) {
      timelines.value = res.data.data.timelines || [];
      faqs.value = res.data.data.faqs || [];
    }
  } catch (err) {
    console.error('Gagal mengambil data pendaftaran:', err);
  } finally {
    loading.value = false;
  }
};

const toggleFaq = (index) => {
  activeFaqIndex.value = activeFaqIndex.value === index ? null : index;
};

// Fallback lists
const fallbackTimelines = [
  {
    date: 'Gelombang 1: 1 Nov - 31 Des 2026',
    title: 'Pengisian Formulir Pendaftaran',
    description: 'Sekolah melakukan pendaftaran awal dengan mengisi identitas sekolah, penanggung jawab, dan estimasi jumlah siswa.'
  },
  {
    date: '1 - 10 Januari 2027',
    title: 'Verifikasi & Jadwal Demo',
    description: 'Tim ahli Jetschool memverifikasi berkas, melakukan koordinasi, serta menjadwalkan presentasi/demo interaktif secara online maupun offline.'
  },
  {
    date: '15 Januari 2027',
    title: 'Persetujuan & Kerja Sama',
    description: 'Penandatanganan Memorandum of Understanding (MoU) kemitraan digitalisasi sekolah bersama manajemen Jetschool.'
  },
  {
    date: '20 - 25 Januari 2027',
    title: 'Implementasi & Pelatihan',
    description: 'Proses konfigurasi server sekolah, migrasi data siswa & guru, serta pelaksanaan pelatihan intensif bagi seluruh staf pengajar dan administrator.'
  }
];

const fallbackFaqs = [
  {
    question: 'Bagaimana cara mendaftarkan sekolah kami ke Jetschool?',
    answer: 'Anda dapat mengisi formulir pengajuan pendaftaran di halaman ini. Tim kami akan menghubungi Anda dalam waktu 1x24 jam untuk menjadwalkan demo produk dan diskusi lebih lanjut.'
  },
  {
    question: 'Apakah ada biaya pendaftaran awal?',
    answer: 'Tidak ada biaya pendaftaran awal. Kemitraan dengan Jetschool berbasis sewa sistem bulanan (subscription) yang dihitung secara transparan per siswa per bulan.'
  },
  {
    question: 'Berapa lama proses implementasi sistem hingga siap digunakan?',
    answer: 'Proses setup sistem, konfigurasi server, serta migrasi data siswa dan guru memakan waktu antara 3 hingga 7 hari kerja sejak dokumen kerja sama disetujui.'
  },
  {
    question: 'Apakah guru dan staf kami akan mendapatkan pelatihan?',
    answer: 'Tentu saja. Kami menyediakan sesi pelatihan intensif terpandu (onboarding) baik secara online maupun offline untuk seluruh guru, staf administrasi, serta materi panduan khusus bagi wali murid.'
  }
];

const timelinesList = computed(() => {
  return timelines.value.length > 0 ? timelines.value : fallbackTimelines;
});

const faqsList = computed(() => {
  return faqs.value.length > 0 ? faqs.value : fallbackFaqs;
});

const submitLead = async () => {
  submitting.value = true;
  registrationSuccess.value = false;
  try {
    await axios.post('/api/leads', {
      name: form.name,
      school_name: form.school_name,
      phone_number: form.phone_number,
      heard_from: form.heard_from,
      ref: getReferralCode()
    });
    
    registrationSuccess.value = true;
    
    // Redirect to WhatsApp with a professional message
    const message = `Halo Jetschool, saya telah mengirim pengajuan di halaman pendaftaran mitra.\n\nNama: ${form.name}\nSekolah: ${form.school_name}\nJabatan: ${form.role}\nEstimasi Siswa: ${form.student_estimate}\nTahu dari: ${form.heard_from}`;
    const whatsappUrl = `https://wa.me/6287786264789?text=${encodeURIComponent(message)}`;
    
    // Reset form
    form.name = '';
    form.school_name = '';
    form.phone_number = '';
    form.role = 'Yayasan';
    form.heard_from = '';
    
    setTimeout(() => {
      window.open(whatsappUrl, '_blank');
    }, 1000);
  } catch (err) {
    alert('Terjadi kesalahan saat mengirim pengajuan. Silakan coba lagi.');
  } finally {
    submitting.value = false;
  }
};

onMounted(loadData);
</script>

<style scoped>
.pendaftaran-view {
  padding-top: 80px;
  background: var(--page);
}

/* Hero Section */
.hero-section {
  padding: 80px 0 60px;
  background: radial-gradient(circle at 50% 10%, #eff6ff 0%, var(--page) 60%);
}

.hero-title {
  font-size: clamp(2.5rem, 5vw, 3.75rem);
  font-weight: 800;
  margin-bottom: 20px;
  line-height: 1.2;
}

.text-gradient {
  background: linear-gradient(135deg, var(--indigo) 0%, var(--coral) 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.hero-subtitle {
  font-size: 1.25rem;
  color: var(--ink-soft);
  max-width: 800px;
  margin: 0 auto;
  line-height: 1.6;
}

/* Grid Layout */
.grid-container {
  display: grid;
  grid-template-columns: 1.1fr 0.9fr;
  gap: 64px;
  padding: 40px 32px 80px;
}

.section-title {
  font-size: 2.25rem;
  font-weight: 700;
  margin-bottom: 12px;
  color: var(--ink);
}

.section-desc {
  color: var(--ink-soft);
  margin-bottom: 40px;
  font-size: 1.1rem;
}

/* Timeline CSS */
.timeline-flow {
  display: flex;
  flex-direction: column;
  position: relative;
  padding-left: 20px;
}

.timeline-item {
  display: flex;
  gap: 24px;
  position: relative;
  padding-bottom: 40px;
}

.timeline-item:last-child {
  padding-bottom: 0;
}

.timeline-marker {
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.marker-dot {
  width: 16px;
  height: 16px;
  border-radius: 50%;
  background: var(--indigo);
  border: 4px solid var(--indigo-light);
  box-shadow: 0 0 12px var(--indigo);
  z-index: 2;
}

.marker-line {
  width: 2px;
  background: var(--border);
  flex-grow: 1;
  position: absolute;
  top: 16px;
  bottom: -40px;
  z-index: 1;
}

.timeline-card {
  background: var(--card);
  padding: 24px;
  border-radius: var(--r-md);
  border: 1px solid var(--border-light);
  box-shadow: var(--sh-sm);
  transition: all 0.3s ease;
  flex-grow: 1;
}

.timeline-card:hover {
  transform: translateX(6px);
  box-shadow: var(--sh-md);
  border-color: var(--indigo);
}

.timeline-date {
  font-size: 0.85rem;
  font-weight: 700;
  color: var(--indigo);
  text-transform: uppercase;
  letter-spacing: 0.05em;
  margin-bottom: 8px;
}

.timeline-title {
  font-family: var(--sans);
  font-size: 1.25rem;
  font-weight: 700;
  color: var(--ink);
  margin-bottom: 8px;
}

.timeline-text {
  font-size: 0.95rem;
  color: var(--ink-soft);
  line-height: 1.6;
}

/* Register Card Form */
.register-card {
  background: var(--card);
  border: 1px solid var(--border);
  border-radius: var(--r-lg);
  padding: 40px;
  box-shadow: var(--sh-md);
  position: sticky;
  top: 120px;
}

.register-card h3 {
  font-size: 1.75rem;
  font-weight: 700;
  margin-bottom: 8px;
  color: var(--ink);
}

.register-card p {
  font-size: 0.95rem;
  color: var(--ink-soft);
  margin-bottom: 28px;
}

.register-form {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.form-group {
  display: flex;
  flex-direction: column;
}

.form-group label {
  font-weight: 600;
  font-size: 0.88rem;
  margin-bottom: 8px;
  color: var(--ink-soft);
}

.required {
  color: #EF4444;
}

.form-input {
  width: 100%;
  padding: 12px 16px;
  background: var(--page);
  border: 1.5px solid var(--border);
  border-radius: var(--r-sm);
  color: var(--ink);
  font-family: inherit;
  font-size: 0.95rem;
  transition: all 0.3s;
}

.form-input:focus {
  outline: none;
  border-color: var(--indigo);
  background: #fff;
  box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
}

.w-full {
  width: 100%;
}

.btn-primary {
  background: var(--indigo);
  color: white;
}

.btn-primary:hover:not(:disabled) {
  background: #4F46E5;
  transform: translateY(-2px);
  box-shadow: var(--sh-md);
}

.btn-primary:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.success-message {
  padding: 16px;
  background: var(--teal-light);
  border: 1px solid var(--teal);
  border-radius: var(--r-sm);
  display: flex;
  gap: 12px;
  align-items: flex-start;
}

.success-icon {
  background: var(--teal);
  color: white;
  width: 24px;
  height: 24px;
  border-radius: 50%;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
  flex-shrink: 0;
}

.success-message h4 {
  font-size: 1rem;
  font-weight: 700;
  color: var(--ink);
  margin-bottom: 4px;
}

.success-message p {
  font-size: 0.85rem;
  color: var(--ink-soft);
  margin-bottom: 0;
}

/* FAQ Accordion Section */
.faq-section {
  padding: 100px 0;
  background: var(--surface);
  border-top: 1px solid var(--border-light);
}

.max-w-4xl {
  max-w: 800px;
  margin: 0 auto;
}

.mb-12 {
  margin-bottom: 48px;
}

.faq-accordion {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.faq-item {
  background: var(--card);
  border: 1px solid var(--border-light);
  border-radius: var(--r-md);
  padding: 24px;
  cursor: pointer;
  transition: all 0.3s ease;
}

.faq-item:hover {
  border-color: var(--indigo);
  box-shadow: var(--sh-sm);
}

.faq-item.active {
  border-color: var(--indigo);
  box-shadow: var(--sh-md);
}

.faq-question {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 16px;
}

.faq-question h4 {
  font-family: var(--sans);
  font-size: 1.15rem;
  font-weight: 700;
  color: var(--ink);
}

.faq-toggle-icon {
  font-size: 1.5rem;
  font-weight: 400;
  color: var(--indigo);
  transition: transform 0.3s;
}

.faq-answer-wrapper {
  transition: max-height 0.3s ease;
}

.faq-answer {
  margin-top: 16px;
  padding-top: 16px;
  border-top: 1px solid var(--border-light);
}

.faq-answer p {
  font-size: 1rem;
  color: var(--ink-soft);
  line-height: 1.7;
}

/* Responsive Styles */
@media (max-width: 1024px) {
  .grid-container {
    grid-template-columns: 1fr;
    gap: 48px;
  }
  
  .register-card {
    position: static;
  }
}

@media (max-width: 640px) {
  .hero-section {
    padding: 60px 0 40px;
  }
  
  .grid-container {
    padding: 20px 16px 60px;
  }
  
  .register-card {
    padding: 24px;
  }
}
</style>
