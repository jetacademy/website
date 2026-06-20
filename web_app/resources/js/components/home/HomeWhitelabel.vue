<template>
  <section class="wl">
    <div class="container wl-grid">
      <div class="wl-text">
        <span class="overline">{{ $t('whiteLabel.overline') }}</span>
        <h2>{{ $t('whiteLabel.title1') }} <em>{{ $t('whiteLabel.title2') }}</em></h2>
        <p>{{ $t('whiteLabel.desc') }}</p>
        <div class="wl-features">
          <div class="wf" v-for="(f, i) in features" :key="i">
            <div class="wf-icon" :style="{ background: f.bg }">
              <span v-html="f.icon"></span>
            </div>
            <div>
              <strong>{{ f.title }}</strong>
              <span>{{ f.desc }}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="wl-visual">
        <img src="/images/mobile.webp" alt="Aplikasi Mobile" class="phone-img" loading="lazy" />
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const features = computed(() => [
  { title: t('whiteLabel.features[0].title'), desc: t('whiteLabel.features[0].desc'), bg: '#EEF2FF', icon: '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#6366F1" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 22 12 18.27 5.82 22 7 14.14l-5-4.87 6.91-1.01L12 2z"/></svg>' },
  { title: t('whiteLabel.features[1].title'), desc: t('whiteLabel.features[1].desc'), bg: '#FFF7ED', icon: '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#F97316" stroke-width="2"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/></svg>' },
  { title: t('whiteLabel.features[2].title'), desc: t('whiteLabel.features[2].desc'), bg: '#F0FDFA', icon: '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#14B8A6" stroke-width="2"><path d="M23 4v6h-6M1 20v-6h6"/><path d="M3.51 9a9 9 0 0114.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0020.49 15"/></svg>' },
])
</script>

<style scoped>
.wl { padding: var(--section-y) 0; background: var(--page); border-top: 1px solid var(--border); }
.wl-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: center; }
.wl-text p { margin-bottom: 40px; }

.wl-features { display: flex; flex-direction: column; gap: 24px; }
.wf { display: flex; gap: 16px; align-items: flex-start; }
.wf-icon { width: 44px; height: 44px; border-radius: var(--r-md); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.wf strong { display: block; font-size: 1rem; color: var(--ink); margin-bottom: 4px; }
.wf span { font-size: 0.9rem; color: var(--ink-muted); }

.wl-visual { display: flex; justify-content: center; }
.phone-img {
  max-width: 550px; width: 100%; border-radius: var(--r-xl);
  filter: drop-shadow(0 30px 60px rgba(0,0,0,0.12));
}

@media (max-width: 1024px) {
  .wl-grid { grid-template-columns: 1fr; text-align: center; }
  .wl-features { align-items: center; text-align: left; }
  .phone-img { max-width: 100%; width: 420px; margin-top: 40px; }
}
</style>
