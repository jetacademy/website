<template>
  <section class="pricing">
    <div class="container">
      <!-- Header -->
      <div class="p-head">
        <span class="overline">{{ $t('pricingSection.overline') }}</span>
        <h2>{{ $t('pricingSection.title1') }} <em>{{ $t('pricingSection.title2') }}</em> {{ $t('pricingSection.title3') }}</h2>
        <p class="p-sub">{{ $t('pricingSection.desc') }}</p>
      </div>

      <!-- Pricing Layout -->
      <div class="price-grid">

        <!-- Left: Benefits -->
        <div class="benefits-col">
          <h3>{{ $t('pricingSection.colTitle') }}</h3>
          <ul class="benefit-list">
            <li v-for="(b, i) in benefits" :key="i">
              <div class="bl-icon" :style="{ background: b.bg, color: b.color }">
                <span v-html="b.icon"></span>
              </div>
              <div class="bl-text">
                <strong>{{ b.title }}</strong>
                <small>{{ b.sub }}</small>
              </div>
            </li>
          </ul>
        </div>

        <!-- Right: Price Card -->
        <div class="price-card">
          <div class="pc-glow"></div>
          
          <div class="pc-badge">{{ $t('pricingSection.card.badge') }}</div>

          <div class="pc-body">
            <span class="pc-label">{{ $t('pricingSection.card.label') }}</span>
            <div class="pc-price">
              <span class="pc-rp">Rp</span>
              <span class="pc-amt">5.000</span>
            </div>
            <span class="pc-per">{{ $t('pricingSection.card.per') }}</span>



            <a href="#" @click.prevent="openDemoModal" class="pc-cta">
              {{ $t('pricingSection.card.btnText') }}
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <p class="pc-note">{{ $t('pricingSection.card.note') }}</p>
          </div>

          <!-- Promo Banner -->
          <div class="pc-promo">
            <div class="promo-sparkle">✨</div>
            <p><strong>{{ $t('pricingSection.card.promoPre') }}</strong> {{ $t('pricingSection.card.promoTxt') }}</p>
          </div>
        </div>

      </div>
      
      <!-- Bottom Trust -->
      <div class="trust-bar">
        <div class="trust-item" v-for="(t, i) in trusts" :key="i">
          <span class="ti-icon" v-html="t.icon"></span>
          <span class="ti-text">{{ t.text }}</span>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { appState } from '../../state'

const { t } = useI18n()

const openDemoModal = () => {
    appState.isDemoModalOpen = true;
}

const benefits = computed(() => [
  {
    title: t('pricingSection.benefits[0].title'),
    sub: t('pricingSection.benefits[0].sub'),
    color: '#3B82F6', bg: '#EFF6FF',
    icon: '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>'
  },
  {
    title: t('pricingSection.benefits[1].title'),
    sub: t('pricingSection.benefits[1].sub'),
    color: '#8B5CF6', bg: '#F5F3FF',
    icon: '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>'
  },
  {
    title: t('pricingSection.benefits[2].title'),
    sub: t('pricingSection.benefits[2].sub'),
    color: '#10B981', bg: '#ECFDF5',
    icon: '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>'
  },
  {
    title: t('pricingSection.benefits[3].title'),
    sub: t('pricingSection.benefits[3].sub'),
    color: '#F97316', bg: '#FFF7ED',
    icon: '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"/></svg>'
  },
  {
    title: t('pricingSection.benefits[4].title'),
    sub: t('pricingSection.benefits[4].sub'),
    color: '#EC4899', bg: '#FDF2F8',
    icon: '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"/><rect x="2" y="14" width="20" height="8" rx="2" ry="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/></svg>'
  }
])

const trusts = computed(() => [
  { icon: '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>', text: t('pricingSection.trust[0]') },
  { icon: '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>', text: t('pricingSection.trust[1]') },
  { icon: '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>', text: t('pricingSection.trust[2]') },
])
</script>

<style scoped>
.pricing { 
  padding: 100px 0; 
  background: linear-gradient(180deg, #F8FAFC 0%, #EFF6FF 100%); 
}

/* Header */
.p-head { text-align: center; margin-bottom: 64px; }
.overline {
  font-size: 0.85rem; font-weight: 800; letter-spacing: 0.08em;
  color: #6366F1; text-transform: uppercase; display: block; margin-bottom: 16px;
}
h2 {
  font-size: 3rem; color: #0F172A; line-height: 1.1;
  font-family: var(--serif); margin: 0;
}
.p-sub { font-size: 1.1rem; color: #64748B; margin-top: 12px; }

/* Grid Layout */
.price-grid {
  display: grid; grid-template-columns: 1fr 1fr; gap: 48px;
  align-items: start; max-width: 1000px; margin: 0 auto;
}

/* Benefits Column */
.benefits-col h3 {
  font-size: 1.5rem; font-weight: 700; color: #0F172A; margin-bottom: 28px;
  font-family: var(--serif);
}
.benefit-list { list-style: none; padding: 0; margin: 0; }
.benefit-list li {
  display: flex; gap: 16px; align-items: center;
  padding: 16px 0; border-bottom: 1px solid #E2E8F0;
}
.benefit-list li:last-child { border-bottom: none; }
.bl-icon {
  width: 44px; height: 44px; border-radius: 12px;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.bl-text strong { display: block; font-size: 1rem; color: #0F172A; margin-bottom: 2px; }
.bl-text small { display: block; font-size: 0.85rem; color: #64748B; }

/* Price Card */
.price-card {
  position: relative; border-radius: 28px; overflow: hidden;
  background: #0F172A;
  box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.3);
}
.pc-glow {
  position: absolute; top: -60px; right: -60px;
  width: 200px; height: 200px; border-radius: 50%;
  background: radial-gradient(circle, rgba(99, 102, 241, 0.3), transparent);
  pointer-events: none;
}
.pc-badge {
  position: absolute; top: 20px; right: 20px;
  background: linear-gradient(135deg, #F59E0B, #D97706);
  color: white; font-size: 0.7rem; font-weight: 800;
  padding: 6px 14px; border-radius: 100px; letter-spacing: 0.05em;
}

.pc-body { padding: 48px 36px 36px; text-align: center; color: white; }

.pc-label { font-size: 0.95rem; opacity: 0.7; display: block; margin-bottom: 8px; }

.pc-price { display: flex; align-items: baseline; justify-content: center; gap: 4px; margin-bottom: 4px; }
.pc-rp { font-size: 1.5rem; font-weight: 600; opacity: 0.8; }
.pc-amt { font-size: 4.5rem; font-weight: 800; line-height: 1; letter-spacing: -0.02em; }

.pc-per { font-size: 0.9rem; opacity: 0.6; display: block; }

.pc-divider { height: 1px; background: rgba(255,255,255,0.1); margin: 28px 0; }

.pc-includes { list-style: none; padding: 0; margin: 0 0 28px; text-align: left; }
.pc-includes li {
  padding: 8px 0; font-size: 0.95rem; color: rgba(255,255,255,0.85);
  display: flex; align-items: center; gap: 10px;
}

.pc-cta {
  display: flex; align-items: center; justify-content: center; gap: 8px;
  width: 100%; padding: 16px;
  background: linear-gradient(135deg, #6366F1, #8B5CF6);
  color: white; border: none; border-radius: 16px;
  font-size: 1.05rem; font-weight: 700; cursor: pointer;
  text-decoration: none;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
}
.pc-cta:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(99, 102, 241, 0.5); }
.pc-cta svg { width: 18px; height: 18px; }

.pc-note { font-size: 0.8rem; color: rgba(255,255,255,0.5); margin-top: 12px; margin-bottom: 0; }

/* Promo */
.pc-promo {
  background: linear-gradient(90deg, #B45309, #D97706, #B45309);
  padding: 18px 24px;
  display: flex; align-items: center; gap: 10px;
  justify-content: center;
}
.promo-sparkle { font-size: 1.2rem; }
.pc-promo p { margin: 0; font-size: 0.85rem; color: white; line-height: 1.4; }

/* Trust Bar */
.trust-bar {
  display: flex; justify-content: center; gap: 40px;
  margin-top: 56px; padding-top: 40px;
  border-top: 1px solid #E2E8F0;
}
.trust-item { display: flex; align-items: center; gap: 8px; }
.ti-icon { color: #10B981; display: flex; }
.ti-text { font-size: 0.9rem; color: #64748B; font-weight: 500; }

/* Responsive */
@media (max-width: 768px) {
  .pricing { padding: 60px 0; }
  h2 { font-size: 2rem; }
  .price-grid { grid-template-columns: 1fr; gap: 32px; padding: 0 20px; }
  .benefits-col { order: 2; }
  .price-card { order: 1; }
  .pc-body { padding: 40px 24px 28px; }
  .pc-amt { font-size: 3.5rem; }
  .trust-bar { flex-direction: column; align-items: center; gap: 16px; }
}
</style>
