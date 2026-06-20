<template>
  <section class="features-tabs">
    <div class="container">
      <div class="section-header">
        <span class="eyebrow">{{ $t('featuresSection.eyebrow') }}</span>
        <h2>{{ $t('featuresSection.title1') }} <em>{{ $t('featuresSection.title2') }}</em></h2>
      </div>

      <div class="tabs-wrapper">
        <!-- Tab Navigation (Left) -->
        <div class="tabs-nav">
          <button 
            v-for="(feat, index) in features" 
            :key="index"
            class="tab-btn"
            :class="{ 'active': activeTab === index }"
            @click="activeTab = index"
          >
            <div class="tb-icon" :class="feat.theme" v-html="feat.icon"></div>
            <div class="tb-info">
              <span class="tb-title">{{ feat.title }}</span>
              <span class="tb-desc">{{ feat.short }}</span>
            </div>
            <div class="tb-arrow" v-if="activeTab === index">→</div>
          </button>
        </div>

        <!-- Tab Content (Right) -->
        <div class="tab-content">
          <transition name="fade" mode="out-in">
            <div :key="activeTab" class="panel">
              <div class="panel-body">
                <div class="pb-header">
                  <span class="pb-badge" :class="features[activeTab].theme">{{ features[activeTab].badge }}</span>
                  <h3>{{ features[activeTab].title }}</h3>
                  <p>{{ features[activeTab].desc }}</p>
                </div>

                <div class="pb-visual" :class="{ 'doc-view': features[activeTab].preview }">
                  <img v-if="features[activeTab].image" :src="features[activeTab].image" class="feat-img" alt="Feature">
                  
                  <div v-else-if="features[activeTab].preview" class="doc-scroll">
                    <div v-html="features[activeTab].preview"></div>
                  </div>

                  <div v-else class="css-mockup" :class="features[activeTab].theme">
                    <div class="cm-icon" v-html="features[activeTab].icon"></div>
                    <span>{{ features[activeTab].title }} Interface</span>
                  </div>
                </div>

                <ul class="pb-list">
                  <li v-for="(item, i) in features[activeTab].list" :key="i">
                    <div class="check-circle">✓</div>
                    <div>
                      <strong>{{ item.title }}</strong>
                      <small>{{ item.sub }}</small>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </transition>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
const activeTab = ref(0)

const features = computed(() => [
  {
    title: t('featuresSection.f1.title'),
    short: t('featuresSection.f1.short'),
    desc: t('featuresSection.f1.desc'),
    badge: t('featuresSection.f1.badge'),
    theme: 'amber',
    image: '/images/aitutor.webp',
    icon: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3 7h7l-6 4 2 7-6-5-6 5 2-7-6-4h7z"/></svg>',
    list: [
      { title: t('featuresSection.f1.list[0].title'), sub: t('featuresSection.f1.list[0].sub') },
      { title: t('featuresSection.f1.list[1].title'), sub: t('featuresSection.f1.list[1].sub') },
      { title: t('featuresSection.f1.list[2].title'), sub: t('featuresSection.f1.list[2].sub') }
    ]
  },
  {
    title: t('featuresSection.f2.title'),
    short: t('featuresSection.f2.short'),
    desc: t('featuresSection.f2.desc'),
    badge: t('featuresSection.f2.badge'),
    theme: 'blue',
    image: '/images/modulai.webp',
    icon: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>',
    list: [
      { title: t('featuresSection.f2.list[0].title'), sub: t('featuresSection.f2.list[0].sub') },
      { title: t('featuresSection.f2.list[1].title'), sub: t('featuresSection.f2.list[1].sub') },
      { title: t('featuresSection.f2.list[2].title'), sub: t('featuresSection.f2.list[2].sub') },
      { title: t('featuresSection.f2.list[3].title'), sub: t('featuresSection.f2.list[3].sub') },
      { title: t('featuresSection.f2.list[4].title'), sub: t('featuresSection.f2.list[4].sub') },
      { title: t('featuresSection.f2.list[5].title'), sub: t('featuresSection.f2.list[5].sub') }
    ]
  },
  {
    title: t('featuresSection.f3.title'),
    desc: t('featuresSection.f3.desc'),
    short: t('featuresSection.f3.short'),
    badge: t('featuresSection.f3.badge'),
    theme: 'violet',
    image: '/images/cbt.webp',
    icon: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"></path><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>',
    list: [
      { title: t('featuresSection.f3.list[0].title'), sub: t('featuresSection.f3.list[0].sub') },
      { title: t('featuresSection.f3.list[1].title'), sub: t('featuresSection.f3.list[1].sub') },
      { title: t('featuresSection.f3.list[2].title'), sub: t('featuresSection.f3.list[2].sub') }
    ]
  },
  {
    title: t('featuresSection.f4.title'),
    desc: t('featuresSection.f4.desc'),
    short: t('featuresSection.f4.short'),
    badge: t('featuresSection.f4.badge'),
    theme: 'emerald',
    image: '/images/payment.webp',
    icon: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>',
    list: [
      { title: t('featuresSection.f4.list[0].title'), sub: t('featuresSection.f4.list[0].sub') },
      { title: t('featuresSection.f4.list[1].title'), sub: t('featuresSection.f4.list[1].sub') },
      { title: t('featuresSection.f4.list[2].title'), sub: t('featuresSection.f4.list[2].sub') },
      { title: t('featuresSection.f4.list[3].title'), sub: t('featuresSection.f4.list[3].sub') }
    ]
  },
  {
    title: t('featuresSection.f5.title'),
    short: t('featuresSection.f5.short'),
    desc: t('featuresSection.f5.desc'),
    badge: t('featuresSection.f5.badge'),
    theme: 'rose',
    image: '/images/sos.webp',
    icon: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>',
    list: [
      { title: t('featuresSection.f5.list[0].title'), sub: t('featuresSection.f5.list[0].sub') },
      { title: t('featuresSection.f5.list[1].title'), sub: t('featuresSection.f5.list[1].sub') },
      { title: t('featuresSection.f5.list[2].title'), sub: t('featuresSection.f5.list[2].sub') }
    ]
  },
  {
    title: t('featuresSection.f6.title'),
    short: t('featuresSection.f6.short'),
    desc: t('featuresSection.f6.desc'),
    badge: t('featuresSection.f6.badge'),
    theme: 'cyan',
    image: '/images/class.webp',
    icon: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>',
    list: [
      { title: t('featuresSection.f6.list[0].title'), sub: t('featuresSection.f6.list[0].sub') },
      { title: t('featuresSection.f6.list[1].title'), sub: t('featuresSection.f6.list[1].sub') },
      { title: t('featuresSection.f6.list[2].title'), sub: t('featuresSection.f6.list[2].sub') }
    ]
  },
  {
    title: t('featuresSection.f7.title'),
    short: t('featuresSection.f7.short'),
    desc: t('featuresSection.f7.desc'),
    badge: t('featuresSection.f7.badge'),
    theme: 'indigo',
    image: '/images/dasboard2.webp',
    icon: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path><path d="M22 12A10 10 0 0 0 12 2v10z"></path></svg>',
    list: [
      { title: t('featuresSection.f7.list[0].title'), sub: t('featuresSection.f7.list[0].sub') },
      { title: t('featuresSection.f7.list[1].title'), sub: t('featuresSection.f7.list[1].sub') },
      { title: t('featuresSection.f7.list[2].title'), sub: t('featuresSection.f7.list[2].sub') }
    ]
  }
])
</script>

<style scoped>
.features-tabs {
  padding: 100px 0;
  background: #F8FAFC;
}

/* Header Styling */
.section-header { text-align: center; margin-bottom: 64px; }

.eyebrow {
  font-size: 0.9rem; font-weight: 800; letter-spacing: 0.08em;
  color: #6366F1; text-transform: uppercase; display: block; margin-bottom: 16px;
}

h2 {
  font-size: 3.5rem; color: #0F172A; line-height: 1.1;
  font-family: var(--serif); margin: 0;
}

.tabs-wrapper {
  display: grid; grid-template-columns: 360px 1fr; gap: 40px; /* Split Layout */
  background: white; border-radius: 32px;
  box-shadow: 0 20px 40px -5px rgba(15, 23, 42, 0.05); /* Card look */
  padding: 32px;
  border: 1px solid #E2E8F0;
}

/* Tabs Nav */
.tabs-nav { display: flex; flex-direction: column; gap: 8px; }

.tab-btn {
  display: flex; align-items: center; gap: 16px;
  padding: 16px; border-radius: 16px; width: 100%; text-align: left;
  border: 1px solid transparent; background: transparent;
  cursor: pointer; transition: all 0.2s;
}
.tab-btn:hover { background: #F1F5F9; }
.tab-btn.active { background: #EFF6FF; border-color: #DBEAFE; box-shadow: 0 4px 6px -2px rgba(59, 130, 246, 0.1); }

.tb-icon {
  width: 40px; height: 40px; border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0; background: #F8FAFC; color: #64748B;
}
.tb-icon svg { width: 20px; height: 20px; }

/* Active Icon Colors */
.tab-btn.active .tb-icon.amber { background: #FEF3C7; color: #D97706; }
.tab-btn.active .tb-icon.blue { background: #EFF6FF; color: #2563EB; }
.tab-btn.active .tb-icon.violet { background: #F5F3FF; color: #7C3AED; }
.tab-btn.active .tb-icon.emerald { background: #ECFDF5; color: #059669; }
.tab-btn.active .tb-icon.rose { background: #FFF1F2; color: #E11D48; }
.tab-btn.active .tb-icon.cyan { background: #CFFAFE; color: #0891B2; }
.tab-btn.active .tb-icon.indigo { background: #E0E7FF; color: #4F46E5; }

.tb-info { flex: 1; overflow: hidden; }
.tb-title { display: block; font-weight: 700; color: #334155; font-size: 1rem; margin-bottom: 2px; }
.tab-btn.active .tb-title { color: #0F172A; }
.tb-desc { display: block; font-size: 0.8rem; color: #94A3B8; text-overflow: ellipsis; white-space: nowrap; overflow: hidden; }

.tb-arrow { color: #3B82F6; font-weight: 700; }

/* Content Panel */
.tab-content { position: relative; min-height: 500px; }

.panel {
  height: 100%; display: flex; flex-direction: column; 
  /* animation */
}

.panel-body {
  height: 100%; padding: 16px 24px;
  display: flex; flex-direction: column;
}

.pb-header { margin-bottom: 32px; }

.pb-badge {
  display: inline-block; font-size: 0.7rem; font-weight: 800; padding: 6px 12px; 
  border-radius: 100px; margin-bottom: 16px; letter-spacing: 0.05em;
}
.pb-badge.amber { background: #FEF3C7; color: #D97706; }
.pb-badge.blue { background: #EFF6FF; color: #2563EB; }
.pb-badge.violet { background: #F5F3FF; color: #7C3AED; }
.pb-badge.emerald { background: #ECFDF5; color: #059669; }
.pb-badge.rose { background: #FFF1F2; color: #E11D48; }
.pb-badge.cyan { background: #CFFAFE; color: #0891B2; }
.pb-badge.indigo { background: #E0E7FF; color: #4F46E5; }

.pb-header h3 { font-size: 2rem; font-family: var(--serif); color: #0F172A; margin-bottom: 12px; }
.pb-header p { font-size: 1.05rem; color: #475569; line-height: 1.6; }

.pb-visual {
  flex: 1; border-radius: 20px; overflow: hidden;
  background: transparent; display: flex; align-items: center; justify-content: center;
  margin-bottom: 32px; min-height: auto; position: relative;
  border: none;
}
.pb-visual.doc-view {
  background: #F1F5F9; align-items: flex-start; justify-content: center;
  padding: 20px; overflow-y: auto; overflow-x: hidden;
  max-height: 420px; border: 1px solid #E2E8F0; min-height: 280px;
}

.feat-img {
  width: 100%; height: auto; object-fit: contain; max-height: 320px;
}

.doc-scroll { width: 100%; display: flex; justify-content: center; }

.css-mockup {
  display: flex; flex-direction: column; align-items: center; gap: 12px;
  font-weight: 600; color: #94A3B8;
}
.cm-icon { padding: 20px; border-radius: 50%; background: white; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); }
.cm-icon svg { width: 32px; height: 32px; stroke-width: 1.5; }
.css-mockup.blue svg { color: #3B82F6; }
.css-mockup.cyan svg { color: #06B6D4; }
.css-mockup.indigo svg { color: #4F46E5; }

.pb-list {
  display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;
  padding-top: 24px; border-top: 1px solid #E2E8F0;
}
.pb-list li { display: flex; gap: 12px; align-items: flex-start; }
.check-circle {
  width: 24px; height: 24px; background: #DCFCE7; color: #16A34A;
  border-radius: 50%; display: flex; align-items: center; justify-content: center;
  font-size: 0.8rem; font-weight: 800; flex-shrink: 0;
}
.pb-list strong { display: block; font-size: 0.95rem; color: #1E293B; margin-bottom: 2px; }
.pb-list small { display: block; font-size: 0.85rem; color: #64748B; line-height: 1.4; }


/* Transitions */
.fade-enter-active, .fade-leave-active { transition: opacity 0.3s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }

@media (max-width: 1024px) {
  .features-tabs { padding: 60px 0; }
  h2 { font-size: 2rem; }
  .section-header { margin-bottom: 32px; padding: 0 20px; }
  
  .tabs-wrapper { 
    grid-template-columns: 1fr; gap: 0; overflow: hidden; 
    padding: 0; /* Maximize width */
    background: transparent; border: none; box-shadow: none;
  }
  
  .tabs-nav { 
    flex-direction: row; overflow-x: auto; 
    padding: 0 20px 16px; margin: 0;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
  }
  .tabs-nav::-webkit-scrollbar { display: none; }
  
  .tab-btn { 
    width: 280px; flex-shrink: 0; 
    scroll-snap-align: start;
    background: white; border: 1px solid #E2E8F0;
    margin-right: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
  }
  .tab-btn.active { 
    background: #0F172A; color: white; border-color: #0F172A;
  }
  .tab-btn.active .tb-title { color: white; }
  .tab-btn.active .tb-desc { color: rgba(255,255,255,0.7); }
  .tab-btn.active .tb-icon { background: rgba(255,255,255,0.1); color: white; }
  
  .tab-content { min-height: auto; }
  .panel-body { 
    padding: 24px 20px; 
    background: white; border-radius: 24px;
    border: 1px solid #E2E8F0;
    margin: 0 20px;
  }

  .pb-list { grid-template-columns: 1fr; gap: 16px; }
  .pb-visual { min-height: 200px; }
  .feat-img { max-height: 240px; }
}

/* Document Preview Styling - Deep Selectors since content is v-html */
.features-tabs :deep(.doc-paper) {
  background: white; width: 100%; max-width: 480px;
  padding: 24px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
  font-family: 'Times New Roman', Times, serif; font-size: 11px;
  color: #1E293B; line-height: 1.4; border-radius: 4px;
}
.features-tabs :deep(.doc-head h4) { font-size: 13px; font-weight: bold; margin-bottom: 8px; font-family: sans-serif; }
.features-tabs :deep(.doc-head hr) { border-top: 2px solid #000; margin-bottom: 12px; }
.features-tabs :deep(.doc-sec) { margin-bottom: 12px; }
.features-tabs :deep(.doc-sec h5) { 
  font-size: 10px; font-weight: bold; background: #EFF6FF; 
  padding: 4px; margin-bottom: 6px; font-family: sans-serif; border-left: 3px solid #2563EB;
}
.features-tabs :deep(.doc-grid) { display: grid; grid-template-columns: 1fr 1fr; gap: 4px; }
.features-tabs :deep(.pillar-grid) { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 6px; text-align: center; }
.features-tabs :deep(.pil) { padding: 6px; border-radius: 4px; font-size: 10px; border: 1px solid #E2E8F0; }
.features-tabs :deep(.p-m) { background: #FEF9C3; border-color: #FDE047; }
.features-tabs :deep(.p-me) { background: #FCE7F3; border-color: #FBCFE8; }
.features-tabs :deep(.p-j) { background: #DCFCE7; border-color: #86EFAC; }
.features-tabs :deep(.step) { 
  margin-bottom: 4px; padding-left: 8px; border-left: 2px solid #CBD5E1; 
}
</style>
