<template>
  <section class="trust-strip">
    <div class="container trust-inner">
      <div class="t-item" v-for="t in items" :key="t.title">
        <span v-html="t.icon" class="t-icon"></span>
        <div>
          <strong>{{ t.title }}</strong>
          <span>{{ t.sub }}</span>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
const items = [
  { title: 'Scalable Performance', sub: 'Information Security', icon: '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#6366F1" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>' },
  { title: 'AES-256 Bit', sub: 'Bank-Grade Encryption', icon: '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#6366F1" stroke-width="1.5"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>' },
  { title: '99.98% Uptime', sub: 'SLA Guarantee', icon: '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#6366F1" stroke-width="1.5"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>' },
  { title: 'Auto Backup', sub: 'Every 6 Hours', icon: '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#6366F1" stroke-width="1.5"><path d="M21.5 2v6h-6M2.5 22v-6h6"/><path d="M2.51 8.87a10 10 0 0118.22-1.37M21.49 15.13a10 10 0 01-18.22 1.37"/></svg>' },
]
</script>

<style scoped>
.trust-strip { padding: 56px 0; background: white; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); }
.trust-inner { display: flex; justify-content: space-between; align-items: center; gap: 32px; }
.t-item { display: flex; align-items: center; gap: 16px; }
.t-icon { flex-shrink: 0; display: flex; }
.t-item strong { display: block; font-size: 1rem; color: var(--ink); font-weight: 700; }
.t-item span { font-size: 0.85rem; color: var(--ink-muted); }

@media (max-width: 1024px) {
  .trust-inner { flex-wrap: wrap; justify-content: center; gap: 40px; }
}
</style>
