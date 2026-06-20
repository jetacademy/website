<template>
  <section class="modules">
    <div class="m-head container">
      <span class="overline">{{ $t('modules.overline') }}</span>
      <h2>{{ $t('modules.title1') }} <em>{{ $t('modules.title2') }}</em></h2>
      <p class="m-sub">{{ $t('modules.desc') }}</p>
    </div>

    <!-- Infinite Scroll Marquee -->
    <div class="marquee-wrapper">
      <div class="marquee-track">
        <div class="m-card" v-for="(m, i) in allModules" :key="i">
          <div class="mc-icon" :style="{ background: m.bg, color: m.color }">
            <span v-html="m.icon"></span>
          </div>
          
          <div class="mc-content">
            <h3>{{ m.title }}</h3>
            <span class="mc-sub">{{ m.subtitle }}</span>
            <div class="mc-div"></div>
            <ul class="mc-list">
              <li v-for="(f, idx) in m.features" :key="idx">
                <svg class="check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>
                {{ f }}
              </li>
            </ul>
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

const baseModules = computed(() => [
  {
    title: t('modules.m1.title'), subtitle: t('modules.m1.subtitle'),
    color: '#3B82F6', bg: '#EFF6FF',
    icon: '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 21h18M5 21V7l8-4 8-4v14M8 21v-9a4 4 0 0 1 4-4v0a4 4 0 0 1 4 4v9" stroke-linecap="round" stroke-linejoin="round"/></svg>',
    features: [t('modules.m1.f1'), t('modules.m1.f2'), t('modules.m1.f3'), t('modules.m1.f4')]
  },
  {
    title: t('modules.m2.title'), subtitle: t('modules.m2.subtitle'),
    color: '#8B5CF6', bg: '#F5F3FF',
    icon: '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 14l9-5-9-5-9 5 9 5z" /><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" /></svg>',
    features: [t('modules.m2.f1'), t('modules.m2.f2'), t('modules.m2.f3'), t('modules.m2.f4')]
  },
  {
    title: t('modules.m3.title'), subtitle: t('modules.m3.subtitle'),
    color: '#F97316', bg: '#FFF7ED',
    icon: '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>',
    features: [t('modules.m3.f1'), t('modules.m3.f2'), t('modules.m3.f3'), t('modules.m3.f4')]
  },
  {
    title: t('modules.m4.title'), subtitle: t('modules.m4.subtitle'),
    color: '#10B981', bg: '#ECFDF5',
    icon: '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>',
    features: [t('modules.m4.f1'), t('modules.m4.f2')]
  },
  {
    title: t('modules.m5.title'), subtitle: t('modules.m5.subtitle'),
    color: '#EC4899', bg: '#FDF2F8',
    icon: '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /><path stroke-linecap="round" stroke-linejoin="round" d="M9 10h.01M15 10h.01M9 10a1 1 0 100-2 1 1 0 000 2zm6 0a1 1 0 100-2 1 1 0 000 2z" /></svg>',
    features: [t('modules.m5.f1'), t('modules.m5.f2'), t('modules.m5.f3'), t('modules.m5.f4')]
  }
])

// Duplicate list 3 times for seamless loop
const allModules = computed(() => [...baseModules.value, ...baseModules.value, ...baseModules.value])
</script>

<style scoped>
.modules { padding: var(--section-y) 0; background: #F8FAFC; overflow: hidden; border-bottom: 1px solid #E2E8F0; }

.m-head { text-align: center; margin-bottom: 56px; }
.m-sub { max-width: 600px; margin: 16px auto 0; color: var(--ink-muted); }

/* Marquee Container */
.marquee-wrapper {
  width: 100%;
  position: relative;
  overflow: hidden;
  padding-bottom: 40px; /* Space for shadow */
  mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
}

.marquee-track {
  display: flex;
  gap: 32px;
  width: max-content;
  animation: scroll 40s linear infinite;
  padding-left: 32px;
}

.marquee-track:hover { animation-play-state: paused; }

@media (max-width: 768px) {
  .marquee-wrapper { 
    mask-image: none; 
    overflow-x: auto; 
    scroll-snap-type: x mandatory; 
    padding-bottom: 20px;
    -webkit-overflow-scrolling: touch;
  }
  .marquee-track { 
    width: auto; 
    animation: none; 
    padding: 0 20px; 
    padding-right: 40px; /* More space at end */
  }
  .m-card { 
    scroll-snap-align: start; 
    margin-right: 0; 
  }
}

@keyframes scroll {
  0% { transform: translateX(0); }
  100% { transform: translateX(calc(-100% / 3)); } /* Move 1/3 of total width (since we tripled content) */
}

/* Cards */
.m-card {
  width: 320px; max-width: 85vw; flex-shrink: 0;
  background: white;
  border-radius: 24px;
  padding: 32px;
  border: 1px solid #E2E8F0;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
  display: flex; flex-direction: column; gap: 24px;
}

.m-card:hover {
  transform: translateY(-5px) scale(1.02);
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
  border-color: #CBD5E1;
}

.mc-icon {
  width: 60px; height: 60px;
  border-radius: 16px;
  display: flex; align-items: center; justify-content: center;
}
.mc-icon :deep(svg) { width: 32px; height: 32px; }

h3 { font-size: 1.25rem; font-weight: 700; color: #0F172A; margin-bottom: 4px; }
.mc-sub { font-size: 0.9rem; color: #64748B; font-family: var(--serif); font-style: italic; }

.mc-div { height: 1px; background: #F1F5F9; width: 100%; }

.mc-list { list-style: none; padding: 0; margin: 0; }
.mc-list li {
  display: flex; gap: 10px; align-items: center;
  margin-bottom: 12px;
  font-size: 0.95rem; color: #475569;
}
.check { width: 18px; height: 18px; color: #10B981; flex-shrink: 0; }
</style>
