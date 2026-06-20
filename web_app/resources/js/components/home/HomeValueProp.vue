<template>
  <section class="value">
    <div class="container">
      <!-- Asymmetric Header -->
      <div class="v-header">
        <div class="v-left">
          <span class="overline">{{ $t('valueProp.overline') }}</span>
          <h2>{{ $t('valueProp.title') }}</h2>
        </div>
        <div class="v-right">
          <p>{{ $t('valueProp.desc') }}</p>
          <a href="#" class="text-link">{{ $t('valueProp.link') }}</a>
        </div>
      </div>

      <!-- Impact Numbers -->
      <div class="impact-row">
        <div class="impact" v-for="(item, i) in impacts" :key="i">
          <span class="i-number" :style="{ color: item.color }">{{ item.num }}</span>
          <span class="i-label">{{ item.label }}</span>
          <p class="i-desc">{{ item.desc }}</p>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const impacts = computed(() => [
  { num: t('valueProp.impacts[0].num'), label: t('valueProp.impacts[0].label'), desc: t('valueProp.impacts[0].desc'), color: '#F43F5E' },
  { num: t('valueProp.impacts[1].num'), label: t('valueProp.impacts[1].label'), desc: t('valueProp.impacts[1].desc'), color: '#F97316' },
  { num: t('valueProp.impacts[2].num'), label: t('valueProp.impacts[2].label'), desc: t('valueProp.impacts[2].desc'), color: '#6366F1' },
])
</script>

<style scoped>
.value { padding: var(--section-y) 0; background: var(--page); }

/* Header */
.v-header { display: grid; grid-template-columns: 1.5fr 1fr; gap: 64px; align-items: end; margin-bottom: 80px; }
.v-right { padding-bottom: 8px; }
.v-right p { margin-bottom: 16px; }
.text-link { font-weight: 700; font-size: 0.95rem; color: var(--indigo); transition: all 0.2s; }
.text-link:hover { color: var(--coral); }

/* Impact Numbers */
.impact-row {
  display: grid; grid-template-columns: repeat(3, 1fr); gap: 0;
  border: 1px solid var(--border); border-radius: var(--r-xl); overflow: hidden;
  background: white; margin-bottom: 64px; box-shadow: var(--sh-sm);
}
.impact { padding: 48px 40px; border-right: 1px solid var(--border); text-align: center; }
.impact:last-child { border-right: none; }
.i-number { font-family: var(--serif); font-size: 2rem; line-height: 1.2; display: block; margin-bottom: 8px; font-weight: 700; }
.i-label { font-weight: 700; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.06em; color: var(--ink); display: block; margin-bottom: 12px; }
.i-desc { font-size: 0.9rem; color: var(--ink-muted); line-height: 1.5; max-width: 280px; margin: 0 auto; }

/* Problem Cards */
.problem-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
.p-card {
  background: white; border: 1px solid var(--border); border-radius: var(--r-lg);
  overflow: hidden; transition: all 0.35s ease;
}
.p-card:hover { transform: translateY(-8px); box-shadow: var(--sh-lg); }
.p-accent { height: 4px; }
.p-body { padding: 32px; }

.p-icon {
  width: 48px; height: 48px; border-radius: var(--r-md);
  display: flex; align-items: center; justify-content: center; margin-bottom: 24px;
}

h4 { font-size: 1.2rem; margin-bottom: 12px; }
.p-body p { font-size: 0.95rem; color: var(--ink-muted); line-height: 1.6; margin: 0; }

@media (max-width: 1024px) {
  .v-header { grid-template-columns: 1fr; gap: 24px; }
  .impact-row { grid-template-columns: 1fr; }
  .impact { border-right: none; border-bottom: 1px solid var(--border); }
  .impact:last-child { border-bottom: none; }
  .problem-grid { grid-template-columns: 1fr; }
}
</style>
