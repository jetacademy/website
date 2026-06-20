<script setup>
import { onMounted, ref } from 'vue';

const isVisible = ref(false);

onMounted(() => {
    setTimeout(() => {
        isVisible.value = true;
    }, 100);
});
</script>

<template>
  <div class="about-page">
    <!-- Background Decor (Light Theme) -->
    <div class="bg-orb orb-1"></div>
    <div class="bg-orb orb-2"></div>
    <div class="bg-grid-pattern"></div>
    
    <div class="container small-container" :class="{ 'reveal-active': isVisible }">
      <!-- HERO -->
      <section class="about-hero text-center slide-up stagger-1">
        <div class="badge-pill mb-4">Mengenal Jetschool</div>
        <h1 class="hero-title">
          <span class="text-gradient-primary">Arsitek Masa Depan</span><br/>
          Pendidikan Digital.
        </h1>
        <p class="subtitle mx-auto">Kami mengorkestrasi teknologi dan pedagogi untuk menciptakan ekosistem pembelajaran tanpa batas bagi generasi penerus.</p>
      </section>

      <!-- CORPORATE PROFILE / STATS -->
      <section class="corporate-bento slide-up stagger-2">
        <div class="bento-card bento-wide glass-panel glowing-border-light">
            <div class="profile-header">
                <span class="company-badge">PT JETSCHOOL ACADEMY INDONESIA</span>
                <h2>Sinergi Teknologi & Edukasi</h2>
            </div>
            <p class="intro-text">
                Sebagai mitra strategis yayasan pendidikan modern, kami menghadirkan solusi komprehensif. Bukan sekadar digitalisasi administrasi—kami meredefinisi seluruh pengalaman operasional dan pembelajaran untuk melampaui standar konvensional.
            </p>
            <div class="legal-grid">
                <div class="legal-item">
                    <span class="label">SK Kemenkumham</span>
                    <span class="value">AHU-0056382.AH.01.01.TAHUN 2020</span>
                </div>
                <div class="legal-item">
                    <span class="label">Kantor Pusat (Headquarters)</span>
                    <span class="value">Menara Kuningan, Jl. H.R. Rasuna Said Kav 5, Jakarta</span>
                </div>
            </div>
        </div>
      </section>

      <!-- VISION MISSION -->
      <section class="vision-mission-section slide-up stagger-3">
        <div class="vm-grid">
            <div class="vm-card glass-panel bento-hover">
                <div class="icon-wrapper glow-icon-blue">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>
                </div>
                <h3 class="gradient-text-blue">Manifesto Visi</h3>
                <p>Menjadi pelopor <strong>Sistem Operasi Pendidikan</strong> terkemuka di Indonesia yang memadukan manajemen, pembelajaran, dan kecerdasan buatan (AI) ke dalam satu ekosistem holistik.</p>
            </div>
            
            <div class="vm-card glass-panel bento-hover">
                <div class="icon-wrapper glow-icon-orange">
                     <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13.5 10.5L21 3"></path><path d="M16 3h5v5"></path><path d="M21 14v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5"></path></svg>
                </div>
                <h3 class="gradient-text-orange">Misi Strategis</h3>
                <ul class="mission-list">
                    <li><strong>Integrasi Penuh:</strong> Mengeliminasi fragmentasi aplikasi sekolah.</li>
                    <li><strong>Data-Driven:</strong> Mengubah data akademik menjadi wawasan strategis.</li>
                    <li><strong>Otomatisasi:</strong> Membebaskan waktu guru dari beban administratif.</li>
                    <li><strong>Personalisasi AI:</strong> Menyesuaikan jejak belajar spesifik tiap siswa.</li>
                </ul>
            </div>
        </div>
      </section>

      <!-- ECOSYSTEM -->
      <section class="services-section slide-up stagger-4">
        <div class="section-header text-center mb-12">
            <h2 class="text-gradient-primary">Pilar Ekosistem Kami</h2>
            <p class="section-desc">Layanan terpadu yang dirancang khusus untuk mengakselerasi transformasi digital sekolah Anda.</p>
        </div>
        
        <div class="ecosystem-grid">
            <div class="eco-card glass-panel group">
                <div class="eco-number text-gradient-primary">01</div>
                <h4>School OS</h4>
                <p>Platform ERP (Enterprise Resource Planning) SaaS untuk manajemen end-to-end yayasan.</p>
                <div class="eco-glow"></div>
            </div>
            <div class="eco-card glass-panel group">
                <div class="eco-number text-gradient-blue">02</div>
                <h4>Jetschool AI</h4>
                <p>Modul cerdas (Tutor, Grader, Generator Modul Ajar) untuk efisiensi di ruang kelas.</p>
                <div class="eco-glow"></div>
            </div>
            <div class="eco-card glass-panel group">
                <div class="eco-number text-gradient-orange">03</div>
                <h4>Jetschool Academy</h4>
                <p>Program sertifikasi kepemimpinan digital dan upskilling pedagogi bagi guru.</p>
                <div class="eco-glow"></div>
            </div>
            <div class="eco-card glass-panel group">
                <div class="eco-number text-gradient-primary">04</div>
                <h4>Virtual Space</h4>
                <p>Eksplorasi virtual campus dan metaverse edu-environment yang interaktif.</p>
                <div class="eco-glow"></div>
            </div>
        </div>
      </section>
    </div>
  </div>
</template>

<style scoped>
/* Base Setup & Animations (Light Theme) */
.about-page {
    position: relative;
    padding: 160px 0 120px;
    background: #F8FAFC; /* Slate 50 - Soft Light Background */
    color: #0F172A; /* Slate 900 - Dark Text */
    overflow: hidden;
    min-height: 100vh;
}

.bg-grid-pattern {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background-image: radial-gradient(#CBD5E1 1px, transparent 1px);
    background-size: 32px 32px;
    opacity: 0.4;
    z-index: 0;
    pointer-events: none;
}

.small-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 24px;
    position: relative;
    z-index: 10;
}

/* Background Glowing Orbs (Light Mode Adjusted) */
.bg-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(100px);
    opacity: 0.6;
    z-index: 1;
    animation: floatOrb 15s infinite alternate ease-in-out;
}
.orb-1 {
    top: -5%; left: -5%;
    width: 600px; height: 600px;
    background: radial-gradient(circle, rgba(99,102,241,0.15) 0%, rgba(255,255,255,0) 70%);
}
.orb-2 {
    bottom: 5%; right: -5%;
    width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(234,88,12,0.1) 0%, rgba(255,255,255,0) 70%);
    animation-delay: -5s;
}
@keyframes floatOrb {
    0% { transform: translate(0, 0) scale(1); }
    100% { transform: translate(50px, 50px) scale(1.1); }
}

/* Scroll Animations (Slide Up) */
.slide-up {
    opacity: 0;
    transform: translateY(40px);
    transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}
.reveal-active .stagger-1 { opacity: 1; transform: translateY(0); transition-delay: 0.1s; }
.reveal-active .stagger-2 { opacity: 1; transform: translateY(0); transition-delay: 0.25s; }
.reveal-active .stagger-3 { opacity: 1; transform: translateY(0); transition-delay: 0.4s; }
.reveal-active .stagger-4 { opacity: 1; transform: translateY(0); transition-delay: 0.55s; }

/* Utilities - Light Glassmorphism */
.glass-panel {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border: 1px solid rgba(255, 255, 255, 1);
    box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.05), inset 0 2px 0 rgba(255,255,255,0.5);
}

.badge-pill {
    display: inline-block;
    padding: 8px 20px;
    border-radius: 100px;
    background: white;
    border: 1px solid rgba(99,102,241,0.2);
    color: #4F46E5;
    font-size: 0.85rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin-bottom: 24px;
    box-shadow: 0 4px 15px rgba(99,102,241,0.08);
}

.text-gradient-primary {
    background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.text-gradient-blue {
    background: linear-gradient(135deg, #2563EB 0%, #0284C7 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.text-gradient-orange {
    background: linear-gradient(135deg, #EA580C 0%, #D97706 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Hero */
.about-hero { margin-bottom: 80px; }
.hero-title {
    font-size: 4rem;
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 24px;
    letter-spacing: -0.02em;
    color: #0F172A;
}
.subtitle {
    font-size: 1.25rem;
    color: #475569;
    line-height: 1.6;
    max-width: 700px;
}
.mb-4 { margin-bottom: 1rem; }
.mb-12 { margin-bottom: 3rem; }
.mx-auto { margin-left: auto; margin-right: auto; }

/* Bento Corporate Profile */
.corporate-bento { margin-bottom: 60px; }
.bento-card {
    border-radius: 24px;
    padding: 56px;
    position: relative;
    overflow: hidden;
}
.glowing-border-light::before {
    content: ''; position: absolute; top: -1px; left: -1px; right: -1px; bottom: -1px;
    background: linear-gradient(135deg, rgba(99,102,241,0.2), transparent 40%, transparent 60%, rgba(234,88,12,0.1));
    z-index: -1; border-radius: 25px; pointer-events: none;
}
.company-badge {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: 0.75rem; letter-spacing: 0.1em; color: #64748B; font-weight: 700;
    margin-bottom: 16px; text-transform: uppercase;
}
.profile-header h2 { font-size: 2.25rem; font-weight: 800; margin-bottom: 24px; color: #0F172A; letter-spacing: -0.01em;}
.intro-text { font-size: 1.15rem; color: #334155; line-height: 1.7; margin-bottom: 40px; }
.legal-grid { display: grid; grid-template-columns: 1fr 1.5fr; gap: 32px; border-top: 1px solid rgba(15,23,42,0.08); padding-top: 32px; }
.label { font-size: 0.75rem; text-transform: uppercase; color: #64748B; letter-spacing: 0.1em; margin-bottom: 6px; display: block; font-weight: 700; }
.value { color: #0F172A; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; font-size: 0.95rem; line-height: 1.5; display: block; font-weight: 600;}

/* Vision Mission Grid */
.vision-mission-section { margin-bottom: 100px; }
.vm-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
.vm-card {
    padding: 48px; border-radius: 24px;
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease, border-color 0.4s ease;
}
.bento-hover:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px -10px rgba(0,0,0,0.08);
    border-color: rgba(99,102,241,0.2);
}
.icon-wrapper {
    width: 64px; height: 64px; border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    background: white; margin-bottom: 24px;
}
.glow-icon-blue { color: #3B82F6; box-shadow: 0 8px 20px rgba(59,130,246,0.15); border: 1px solid rgba(59,130,246,0.1); }
.glow-icon-orange { color: #F97316; box-shadow: 0 8px 20px rgba(249,115,22,0.15); border: 1px solid rgba(249,115,22,0.1); }
.vm-card h3 { font-size: 1.75rem; font-weight: 800; margin-bottom: 16px; margin-top: 0; color: #0F172A; }
.gradient-text-blue { background: linear-gradient(135deg, #2563EB, #0284C7); -webkit-background-clip: text; -webkit-text-fill-color: transparent;}
.gradient-text-orange { background: linear-gradient(135deg, #EA580C, #D97706); -webkit-background-clip: text; -webkit-text-fill-color: transparent;}
.vm-card p { color: #475569; line-height: 1.6; font-size: 1.05rem; }
.mission-list { list-style: none; padding: 0; margin: 0; color: #475569; font-size: 1.05rem; }
.mission-list li { margin-bottom: 16px; padding-left: 28px; position: relative; line-height: 1.5; }
.mission-list li::before {
    content: ""; position: absolute; left: 0; top: 8px; width: 12px; height: 12px;
    background: linear-gradient(135deg, #FDBA74, #F97316); border-radius: 50%;
}
.mission-list li strong { color: #0F172A; }

/* Services Ecosystem */
.section-header h2 { font-size: 2.5rem; font-weight: 800; margin-bottom: 16px; margin-top: 0; }
.section-desc { color: #475569; font-size: 1.15rem; max-width: 600px; margin: 0 auto; line-height: 1.6; }
.ecosystem-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; }
.eco-card {
    padding: 40px; border-radius: 20px; position: relative; overflow: hidden;
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); cursor: pointer;
}
.eco-card:hover {
    transform: translateY(-6px); box-shadow: 0 16px 32px -8px rgba(0,0,0,0.06); border-color: white;
}
.eco-number { font-size: 3rem; font-weight: 800; opacity: 0.15; font-family: 'Inter', sans-serif; margin-bottom: 16px; transition: opacity 0.3s; }
.eco-card:hover .eco-number { opacity: 0.6; }
.eco-card h4 { font-size: 1.35rem; font-weight: 800; margin-bottom: 12px; color: #0F172A; margin-top: 0;}
.eco-card p { color: #475569; line-height: 1.6; margin: 0; font-weight: 500;}
.eco-glow {
    position: absolute; right: -20px; bottom: -20px; width: 100px; height: 100px;
    background: rgba(99,102,241,0.1); border-radius: 50%; filter: blur(40px);
    transition: all 0.4s ease; opacity: 0; pointer-events: none;
}
.eco-card:hover .eco-glow { opacity: 1; transform: scale(1.5); }

/* Responsive adjustments */
@media (max-width: 1024px) {
    .bg-orb { filter: blur(80px); }
}

@media (max-width: 768px) {
    .about-page { padding: 120px 0 80px; }
    .hero-title { font-size: 2.5rem; }
    .legal-grid { grid-template-columns: 1fr; gap: 24px; }
    .vm-grid { grid-template-columns: 1fr; }
    .ecosystem-grid { grid-template-columns: 1fr; }
    .bento-card { padding: 32px; }
}
</style>
