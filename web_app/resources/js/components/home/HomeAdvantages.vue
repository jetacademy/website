<template>
  <section class="adv">
    <div class="container">
      <div class="a-head">
        <span class="overline">{{ $t('advantages.overline') }}</span>
        <h2>{{ $t('advantages.title1') }} <em>{{ $t('advantages.title2') }}</em></h2>
      </div>

      <div class="bento">
        <!-- Hero Card: Portofolio Berkelanjutan -->
        <div class="b-card hero-card">
          <div class="hc-text">
            <h3>{{ $t('advantages.heroTitle') }}</h3>
            <p v-html="$t('advantages.heroDesc')"></p>
          </div>
          <div class="hc-visual">
            <img src="/images/single data.webp" alt="Single Data Identity" class="hc-img">
          </div>
        </div>

        <!-- Feature Cards -->
        <div class="b-card feat" v-for="(f, i) in features" :key="i" :style="{ '--feat-color': f.color, '--feat-bg': f.bg }">
          <div class="f-icon" :style="{ background: f.bg }">
            <span v-html="f.icon"></span>
          </div>
          <h4>{{ f.title }}</h4>
          <p>{{ f.desc }}</p>
          <span class="f-tag">{{ f.tag }}</span>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const features = computed(() => [
  {
    title: t('advantages.f1.title'), desc: t('advantages.f1.desc'),
    tag: t('advantages.f1.tag'), color: '#6366F1', bg: '#EEF2FF',
    icon: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#6366F1" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>'
  },
  {
    title: t('advantages.f2.title'), desc: t('advantages.f2.desc'),
    tag: t('advantages.f2.tag'), color: '#E11D48', bg: '#FFF1F2',
    icon: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#E11D48" stroke-width="2"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>'
  },
  {
    title: t('advantages.f3.title'), desc: t('advantages.f3.desc'),
    tag: t('advantages.f3.tag'), color: '#F97316', bg: '#FFF7ED',
    icon: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#F97316" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 22 12 18.27 5.82 22 7 14.14l-5-4.87 6.91-1.01L12 2z"/></svg>'
  },
  {
    title: t('advantages.f4.title'), desc: t('advantages.f4.desc'),
    tag: t('advantages.f4.tag'), color: '#14B8A6', bg: '#F0FDFA',
    icon: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#14B8A6" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>'
  },
])
</script>

<style scoped>
.adv { padding: var(--section-y) 0; background: var(--page); }
.a-head { margin-bottom: 64px; }

/* Bento */
.bento { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }

.b-card {
  background: white; border: 1px solid var(--border); border-radius: var(--r-lg);
  transition: all 0.35s ease;
}
.b-card:hover { transform: translateY(-6px); box-shadow: var(--sh-lg); }

/* Hero Card */
.hero-card {
  grid-column: span 4; 
  background: var(--ink); 
  color: white; 
  border-color: var(--ink);
  display: flex; 
  align-items: center; 
  justify-content: space-between;
  padding: 0; 
  border-radius: var(--r-xl);
  overflow: hidden;
  max-height: 350px; /* Constraint height */
}

.hero-card:hover { border-color: var(--ink); }

.hc-text {
  padding: 48px;
  max-width: 55%;
  z-index: 2;
}

.hero-card h3 { color: white; font-size: 1.75rem; margin-bottom: 12px; }
.hero-card p { color: rgba(255,255,255,0.7); margin: 0; font-size: 0.95rem; line-height: 1.6; }

.hc-visual {
  flex: 1;
  height: 100%;
  display: flex;
  align-items: flex-end;
  justify-content: flex-end;
  position: relative;
}

/* Hero Image */
.hc-img {
  height: 100%;
  width: auto;
  object-fit: cover;
  object-position: left bottom;
  mask-image: linear-gradient(to right, transparent, black 20%);
}

/* Feature Cards */
.feat { grid-column: span 1; padding: 24px; position: relative; overflow: hidden; display: flex; flex-direction: column; }
.f-icon {
  width: 40px; height: 40px; border-radius: var(--r-md);
  display: flex; align-items: center; justify-content: center; margin-bottom: 16px;
}
h4 { font-size: 1rem; margin-bottom: 8px; }
.feat p { font-size: 0.93rem; color: var(--ink-muted); line-height: 1.55; margin-bottom: 20px; }
.f-tag {
  font-size: 0.7rem; font-weight: 700; letter-spacing: 0.08em; color: var(--feat-color);
  padding: 4px 10px; background: var(--feat-bg); border-radius: var(--r-full);
}

@media (max-width: 1024px) {
  .adv { padding: 60px 0; }
  .bento { grid-template-columns: 1fr; gap: 24px; }
  
  .hero-card { 
    grid-column: span 1; 
    flex-direction: column; 
    align-items: center;
    max-height: none; 
    height: auto;
    padding: 0;
    overflow: hidden;
  }
  
  .hc-text { 
    width: 100%; max-width: 100%; 
    padding: 32px 24px 0; 
    text-align: center;
    position: relative; z-index: 2;
  }
  
  .hc-visual { 
    width: 100%; 
    height: 300px;
    position: relative;
    margin-top: -20px;
  }
  
  .hc-img { 
    width: 100%; height: 100%;
    object-fit: contain;
    object-position: bottom center;
    border-radius: 0;
    mask-image: linear-gradient(to bottom, transparent, black 10%);
    -webkit-mask-image: linear-gradient(to bottom, transparent, black 10%);
  }

  .feat { grid-column: span 1; padding: 24px; }
}
</style>
