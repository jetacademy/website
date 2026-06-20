<template>
  <section class="hero">
    <!-- Animated Gradient Orbs -->
    <div class="orbs">
      <div class="orb orb-1"></div>
      <div class="orb orb-2"></div>
      <div class="orb orb-3"></div>
    </div>

    <div class="container hero-inner">
      <div class="hero-content">
        <!-- Decoration Line -->
        <div class="hero-decor">
          <span class="hd-line"></span>
          <span class="hd-star">✦</span>
          <span class="hd-line"></span>
        </div>

        <h1>
          <span class="block-serif">{{ $t('hero.title1') }}</span>
          <em class="block-italic">{{ $t('hero.title2') }}</em>
        </h1>

        <p class="lead">
          {{ $t('hero.desc') }}
        </p>

        <div class="hero-ctas">
          <button @click="openDemoModal" class="btn btn-primary">
            {{ $t('hero.btnDemo') }}
          </button>
        </div>
      </div>

      <div class="hero-visual">
        <div class="visual-container">
          <img src="/images/dasboard2.webp" alt="Dashboard Jetschool" class="dash-img" />
          
          <!-- Floating Chips -->
          <div class="f-chip chip-users">
            <span class="fc-icon">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            </span>
            <span class="fc-label">{{ $t('hero.chip1') }}</span>
          </div>
          
          <div class="f-chip chip-ai">
            <span class="fc-icon">✦</span>
            <span class="fc-label">{{ $t('hero.chip2') }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Marquee Trust Bar -->
    <div class="marquee-wrap">
      <div class="marquee-track">
        <div class="marquee-content">
          <span v-for="n in 3" :key="n" class="marquee-set">
             <span class="trust-item">{{ $t('hero.marquee.t1') }}</span><span class="trust-dot">◆</span>
             <span class="trust-item">{{ $t('hero.marquee.t2') }}</span><span class="trust-dot">◆</span>
             <span class="trust-item">{{ $t('hero.marquee.t3') }}</span><span class="trust-dot">◆</span>
             <span class="trust-item">{{ $t('hero.marquee.t4') }}</span><span class="trust-dot">◆</span>
             <span class="trust-item">{{ $t('hero.marquee.t5') }}</span><span class="trust-dot">◆</span>
             <span class="trust-item">{{ $t('hero.marquee.t6') }}</span><span class="trust-dot">◆</span>
          </span>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { appState } from '../../state'

const openDemoModal = () => {
    appState.isDemoModalOpen = true;
}
</script>

<style scoped>
.hero {
  position: relative; background: #0F172A; min-height: 100vh;
  display: flex; flex-direction: column; justify-content: center;
  padding: 100px 0 0; overflow: hidden;
  color: white;
}

/* ═══ ORBS ═══ */
.orbs { position: absolute; inset: 0; pointer-events: none; overflow: hidden; z-index: 0; }
.orb { position: absolute; border-radius: 50%; filter: blur(100px); opacity: 0.5; animation: float 15s infinite ease-in-out; }
.orb-1 { width: 800px; height: 800px; background: radial-gradient(circle, #4F46E5 0%, transparent 70%); top: -30%; left: 50%; transform: translateX(-50%); }
.orb-2 { width: 600px; height: 600px; background: radial-gradient(circle, #EC4899 0%, transparent 70%); bottom: -20%; right: -10%; animation-delay: -5s; }
.orb-3 { width: 500px; height: 500px; background: radial-gradient(circle, #06B6D4 0%, transparent 70%); top: 40%; left: -10%; opacity: 0.3; animation-delay: -10s; }

@keyframes float { 0%,100% { transform: translate(0,0); } 50% { transform: translate(30px, -30px); } }

/* ═══ CONTENT ═══ */
.hero-inner {
  position: relative; z-index: 2;
  display: flex; flex-direction: column; align-items: center; text-align: center;
  gap: 60px; padding-bottom: 80px;
}

.hero-content {
  display: flex; flex-direction: column; align-items: center; max-width: 800px;
}

.hero-decor {
  display: flex; align-items: center; gap: 16px; margin-bottom: 24px; opacity: 0.6;
}
.hd-line { width: 60px; height: 1px; background: linear-gradient(90deg, transparent, white, transparent); }
.hd-star { color: #F59E0B; font-size: 1.2rem; animation: pulse 2s infinite; }

h1 { line-height: 1.1; margin-bottom: 24px; }
.block-serif { display: block; font-family: var(--serif); font-size: 3.5rem; font-weight: 500; letter-spacing: -0.02em; color: #ffffff; text-shadow: 0 2px 10px rgba(0,0,0,0.3); }
.block-italic { display: block; font-family: var(--serif); font-size: 3.5rem; font-weight: 400; font-style: italic; color: #94A3B8; }

.lead { font-size: 1.1rem; line-height: 1.6; color: #CBD5E1; max-width: 600px; margin-bottom: 40px; }

/* ═══ BUTTONS ═══ */
.hero-ctas { display: flex; gap: 20px; align-items: center; justify-content: center; }

.btn {
  display: inline-flex; align-items: center; gap: 12px;
  height: 52px; padding: 0 32px; border-radius: 100px;
  font-weight: 600; font-size: 1rem; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.btn-primary {
  background: linear-gradient(135deg, #6366F1 0%, #4F46E5 100%);
  color: white;
  box-shadow: 0 4px 20px rgba(79, 70, 229, 0.4), inset 0 1px 0 rgba(255,255,255,0.2);
}
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(79, 70, 229, 0.5); }

.btn-glass {
  background: rgba(255, 255, 255, 0.05); color: white;
  border: 1px solid rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(8px);
}
.btn-glass:hover { background: rgba(255, 255, 255, 0.1); border-color: rgba(255, 255, 255, 0.2); }

.play-icon {
  width: 24px; height: 24px; border-radius: 50%; background: white; color: #0F172A;
  display: flex; align-items: center; justify-content: center;
}

/* ═══ VISUAL ═══ */
.hero-visual { width: 100%; display: flex; justify-content: center; perspective: 1000px; }

.visual-container {
  position: relative; width: 100%; max-width: 1000px;
  /* Removed 3D tilt for cleaner look as requested previously */
}

.dash-img {
  display: block; width: 100%; height: auto;
  border-radius: 12px;
}

/* Chips */
.f-chip {
  position: absolute; display: flex; align-items: center; gap: 12px;
  background: rgba(30, 41, 59, 0.9); backdrop-filter: blur(12px);
  border: 1px solid rgba(255,255,255,0.1); padding: 8px 16px;
  border-radius: 100px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

.chip-users { top: -20px; right: 40px; }
.fc-val { font-weight: 700; color: #10B981; font-size: 1rem; }
.fc-label { color: white; font-size: 0.85rem; font-weight: 500; }

.chip-ai { bottom: -20px; left: 40px; }
.fc-icon { color: #F59E0B; }

/* ═══ RESPONSIVE ═══ */
@media (max-width: 768px) {
  .hero { padding-top: 80px; min-height: auto; padding-bottom: 60px; }
  .block-serif, .block-italic { font-size: 2rem; }
  .lead { font-size: 1rem; margin-bottom: 32px; }
  .f-chip { display: none; }
  .hero-content { padding: 0 20px; }
  .hero-ctas { flex-direction: column; width: 100%; gap: 12px; }
  .btn { width: 100%; justify-content: center; }
}

/* ═══ MARQUEE ═══ */
.marquee-wrap { border-top: 1px solid rgba(255,255,255,0.05); padding: 24px 0; background: #0F172A; margin-top: -40px; position: relative; z-index: 3; }
.marquee-content { display: flex; animation: marquee 30s linear infinite; width: max-content; }
.marquee-set { display: flex; align-items: center; gap: 40px; padding-right: 40px; }
.trust-item { font-weight: 700; color: #64748B; letter-spacing: 0.05em; font-size: 0.9rem; }
.trust-dot { color: #334155; font-size: 0.7rem; }
@keyframes marquee { from { transform: translateX(0); } to { transform: translateX(-50%); } }
</style>
