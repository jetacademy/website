<template>
  <div class="contact-page">
    <div class="container small-container">
      <section class="contact-header text-center">
        <h1 class="text-gradient">Hubungi Kami</h1>
        <p class="subtitle">Siap mendigitalkan sekolah Anda? Jadwalkan demo atau konsultasi gratis sekarang.</p>
      </section>

      <div class="contact-card glass-panel">
        <div class="form-side">
            <h2>Jadwalkan Demo</h2>
            <form @submit.prevent="submitForm">
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" v-model="form.name" required placeholder="Contoh: Budi Santoso" class="form-input">
                </div>
                
                <div class="form-group">
                    <label for="school">Nama Sekolah / Yayasan</label>
                    <input type="text" id="school" v-model="form.school" required placeholder="Contoh: SMA Harapan Bangsa" class="form-input">
                </div>

                <div class="form-group">
                    <label for="phone">Nomor WhatsApp</label>
                    <input type="tel" id="phone" v-model="form.phone" required placeholder="Contoh: 08123456789" class="form-input">
                </div>
                
                <div class="form-group">
                    <label for="role">Jabatan</label>
                    <select id="role" v-model="form.role" class="form-input">
                        <option value="Yayasan">Ketua Yayasan</option>
                        <option value="Kepala Sekolah">Kepala Sekolah</option>
                        <option value="Manajemen">Tim Manajemen</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="message">Pesan (Opsional)</label>
                    <textarea id="message" v-model="form.message" rows="3" placeholder="Ceritakan kebutuhan sekolah Anda..." class="form-input"></textarea>
                </div>

                <div class="form-group">
                    <label for="package">Paket yang diminati</label>
                    <select id="package" v-model="form.package" class="form-input">
                        <option value="">Belum Tahu (Konsultasi Dulu)</option>
                        <option value="Starter">Starter - Rp 3.000/siswa/bln</option>
                        <option value="School OS">School OS - Rp 5.000/siswa/bln (Paling Populer)</option>
                        <option value="Enterprise">Enterprise - Custom</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-full">Kirim Pesan via WhatsApp</button>
            </form>
        </div>

        <div class="info-side">
            <div class="info-item">
                <div class="icon-circle">🌍</div>
                <div>
                    <h4>Website</h4>
                    <p>jetschool.id</p>
                </div>
            </div>
            <div class="info-item">
                <div class="icon-circle">📧</div>
                <div>
                    <h4>Email</h4>
                    <p>info@jetschool.id</p>
                </div>
            </div>
            <div class="info-item">
                <div class="icon-circle">📱</div>
                <div>
                    <h4>WhatsApp</h4>
                    <p>+62 877 8626 4789</p>
                </div>
            </div>
            <div class="info-item">
                <div class="icon-circle">🏢</div>
                <div>
                    <h4>Kantor</h4>
                    <p>Menara Kuningan, Jl. H.R. Rasuna Said No.Kav 5, Jakarta Selatan</p>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';

const route = useRoute();

const form = reactive({
  name: '',
  school: '',
  phone: '',
  role: 'Yayasan',
  message: '',
  package: ''
});

// Read package from URL query params (e.g. /contact?package=Starter)
if (route.query.package) {
  form.package = route.query.package;
}

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

const submitForm = async () => {
    try {
        await axios.post('/api/leads', {
            name: form.name,
            school_name: form.school,
            phone_number: form.phone,
            heard_from: 'website_contact',
            package: form.package,
            ref: getReferralCode()
        });
    } catch(e) { /* ignore and proceed to simple WA message */ }

    const message = `Halo Jetschool, saya ingin menjadwalkan demo.\n\nNama: ${form.name}\nSekolah: ${form.school}\nJabatan: ${form.role}\nPesan: ${form.message}`;
    const whatsappUrl = `https://wa.me/6287786264789?text=${encodeURIComponent(message)}`;
    window.open(whatsappUrl, '_blank');
};
</script>

<style scoped>
.contact-page {
    padding: 140px 0 100px;
    background: linear-gradient(to bottom, #020617 0%, #0f172a 100%);
}

.small-container { max-width: 1000px; }

.contact-header { margin-bottom: 60px; }

.contact-header h1 {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 24px;
}

.contact-card {
    display: grid;
    grid-template-columns: 1.2fr 0.8fr;
    border-radius: 24px;
    overflow: hidden;
    background: rgba(255,255,255,0.02);
}

.form-side {
    padding: 48px;
    border-right: 1px solid rgba(255,255,255,0.1);
}

.form-side h2 {
    margin-bottom: 32px;
    font-size: 1.8rem;
}

.form-group {
    margin-bottom: 24px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.form-input {
    width: 100%;
    padding: 12px 16px;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 8px;
    color: white;
    font-family: inherit;
    transition: all 0.3s;
}

.form-input:focus {
    outline: none;
    border-color: var(--accent-primary);
    background: rgba(255,255,255,0.08);
}

.w-full { width: 100%; }

.info-side {
    padding: 48px;
    background: rgba(15, 23, 42, 0.4);
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 40px;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 20px;
}

.icon-circle {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: rgba(59, 130, 246, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    color: var(--accent-primary);
}

.info-item h4 {
    font-size: 0.9rem;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 4px;
}

.info-item p {
    color: white;
    font-size: 1.1rem;
}

@media (max-width: 768px) {
    .contact-card { grid-template-columns: 1fr; }
    .form-side { border-right: none; border-bottom: 1px solid rgba(255,255,255,0.1); }
}
</style>
