<template>
  <section class="comp">
    <div class="container">
      <div class="c-head">
        <span class="overline">{{ $t('comparison.overline') }}</span>
        <h2>{{ $t('comparison.title1') }} <em>{{ $t('comparison.title2') }}</em></h2>
      </div>

      <div class="comp-grid">
        <!-- Before -->
        <div class="comp-card before">
          <div class="cc-header">
            <span class="cc-label">{{ $t('comparison.beforeLabel') }}</span>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#F43F5E" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6M9 9l6 6"/></svg>
          </div>
          <div class="cc-items">
            <div class="cc-item" v-for="(b, i) in befores" :key="i">
              <span class="cc-x">✕</span>
              <span>{{ b }}</span>
            </div>
          </div>
        </div>

        <!-- Divider -->
        <div class="comp-divider">
          <div class="arrow-circle">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </div>
        </div>

        <!-- After -->
        <div class="comp-card after">
          <div class="cc-header">
            <span class="cc-label after-label">{{ $t('comparison.afterLabel') }}</span>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><path d="M22 4L12 14.01l-3-3"/></svg>
          </div>
          <div class="cc-items">
            <div class="cc-item" v-for="(a, i) in afters" :key="i">
              <span class="cc-check">✓</span>
              <span>{{ a }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const befores = computed(() => [
  t('comparison.befores[0]'),
  t('comparison.befores[1]'),
  t('comparison.befores[2]'),
  t('comparison.befores[3]'),
  t('comparison.befores[4]'),
])
const afters = computed(() => [
  t('comparison.afters[0]'),
  t('comparison.afters[1]'),
  t('comparison.afters[2]'),
  t('comparison.afters[3]'),
  t('comparison.afters[4]'),
])
</script>

<style scoped>
.comp { padding: var(--section-y) 0; background: var(--surface); }
.c-head { text-align: center; margin-bottom: 64px; }

.comp-grid { display: grid; grid-template-columns: 1fr auto 1fr; gap: 0; align-items: stretch; max-width: 900px; margin: 0 auto; }

.comp-card { border-radius: var(--r-xl); padding: 40px; }

.before { background: white; border: 1px solid var(--border); }
.after { background: var(--ink); color: white; border: 1px solid var(--ink); box-shadow: var(--sh-xl); }

.cc-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; }
.cc-label { font-weight: 700; font-size: 1.1rem; color: var(--ink-muted); }
.after-label { color: rgba(255,255,255,0.8); }

.cc-item { display: flex; gap: 14px; align-items: flex-start; margin-bottom: 20px; font-size: 1rem; line-height: 1.5; }
.cc-x { color: #F43F5E; font-weight: 800; flex-shrink: 0; font-size: 0.9rem; margin-top: 2px; }
.cc-check { color: #34D399; font-weight: 800; flex-shrink: 0; font-size: 0.9rem; margin-top: 2px; }
.before .cc-item span:last-child { color: var(--ink-muted); }
.after .cc-item span:last-child { color: rgba(255,255,255,0.8); }

/* Divider Arrow */
.comp-divider { display: flex; align-items: center; justify-content: center; padding: 0 24px; }
.arrow-circle {
  width: 56px; height: 56px; border-radius: 50%;
  background: var(--coral); box-shadow: 0 8px 24px rgba(249, 115, 22, 0.4);
  display: flex; align-items: center; justify-content: center;
}

@media (max-width: 768px) {
  .comp-grid { grid-template-columns: 1fr; gap: 24px; }
  .comp-divider { padding: 12px 0; }
  .arrow-circle svg { transform: rotate(90deg); }
}
</style>
