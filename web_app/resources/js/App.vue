<script setup>
import { RouterView, useRoute, useRouter } from 'vue-router'
import { ref, onMounted, onUnmounted, computed, watch } from 'vue'
import axios from 'axios'
import DemoModal from './components/DemoModal.vue'
import { appState } from './state'

const route = useRoute()
const router = useRouter()
const scrolled = ref(false)
const isMenuOpen = ref(false)

const handleScroll = () => { scrolled.value = window.scrollY > 40 }
const isScrolled = computed(() => scrolled.value || route.name !== 'home' && route.name !== undefined)

const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value
    if (isMenuOpen.value) {
        document.body.style.overflow = 'hidden'
    } else {
        document.body.style.overflow = ''
    }
}

const closeMenu = () => {
    isMenuOpen.value = false
    document.body.style.overflow = ''
}

const openDemoModal = () => {
    appState.isDemoModalOpen = true;
    closeMenu();
}

const isAdminRoute = computed(() => {
    return route.path.startsWith('/webadmin') || route.path === '/login' || route.path.startsWith('/affiliate/dashboard');
})

// Close menu when route changes
watch(() => route.fullPath, () => {
    closeMenu()
})

onMounted(() => {
  window.addEventListener('scroll', handleScroll);
  // Deteksi affiliate referral code dari URL (?ref=KODE)
  const urlParams = new URLSearchParams(window.location.search);
  const refCode = urlParams.get('ref');
  if (refCode) {
    localStorage.setItem('jetschool_affiliate_ref', JSON.stringify({
      code: refCode,
      expires: new Date().getTime() + (30 * 24 * 60 * 60 * 1000) // 30 hari
    }));
    // Track klik di server
    axios.post('/api/affiliate-click', { ref: refCode }).catch(() => {});
  }
})
onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll)
    document.body.style.overflow = ''
})
</script>

<template>
  <div id="cosmic-app">
    <DemoModal />
    
    <!-- ─── HEADER ─── -->
    <header v-if="!isAdminRoute" :class="['c-header', { scrolled: isScrolled, 'menu-open': isMenuOpen }]">
      <div class="container header-row">
        <router-link to="/" class="logo" @click="closeMenu">
          <img src="/images/jetschool_logo.png" alt="Jetschool Logo" class="logo-img" />
        </router-link>

        <nav class="topnav">
          <router-link :to="{ name: 'home', hash: '#why' }">{{ $t('nav.why') }}</router-link>
          <router-link :to="{ name: 'home', hash: '#solusi' }">{{ $t('nav.solution') }}</router-link>
          <router-link :to="{ name: 'home', hash: '#fitur' }">{{ $t('nav.features') }}</router-link>
          <router-link :to="{ name: 'home', hash: '#harga' }">{{ $t('nav.pricing') }}</router-link>
          <router-link to="/blog">{{ $t('nav.blog') }}</router-link>
        </nav>

        <div class="header-end">
          <div class="lang-switcher">
            <select v-model="$i18n.locale" class="lang-select">
              <option value="id">{{ $t('lang.id') }}</option>
              <option value="en">{{ $t('lang.en') }}</option>
              <option value="zh">{{ $t('lang.zh') }}</option>
            </select>
          </div>
          
          <button class="mobile-toggle" @click="toggleMenu" :aria-label="isMenuOpen ? 'Close Menu' : 'Open Menu'">
            <div class="hamburger" :class="{ 'is-active': isMenuOpen }">
              <span></span>
              <span></span>
              <span></span>
            </div>
          </button>
        </div>
      </div>
    </header>

    <!-- Mobile Menu Overlay -->
    <transition name="slide-down">
      <div v-if="isMenuOpen" class="mobile-menu">
        <div class="mobile-menu-header">
           <router-link to="/" class="logo" @click="closeMenu">
            <img src="/images/jetschool_logo.png" alt="Jetschool Logo" class="logo-img" />
          </router-link>
          <button class="mobile-close" @click="closeMenu" aria-label="Close Menu">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
        </div>
        <div class="container mobile-menu-inner">
          <nav class="mobile-nav">
            <router-link :to="{ name: 'home', hash: '#why' }" @click="closeMenu">
              <span class="nav-num">01</span> {{ $t('nav.why') }}
            </router-link>
            <router-link :to="{ name: 'home', hash: '#solusi' }" @click="closeMenu">
              <span class="nav-num">02</span> {{ $t('nav.solution') }}
            </router-link>
            <router-link :to="{ name: 'home', hash: '#fitur' }" @click="closeMenu">
              <span class="nav-num">03</span> {{ $t('nav.features') }}
            </router-link>
            <router-link :to="{ name: 'home', hash: '#harga' }" @click="closeMenu">
               <span class="nav-num">04</span> {{ $t('nav.pricing') }}
            </router-link>
            <router-link to="/blog" @click="closeMenu">
               <span class="nav-num">05</span> {{ $t('nav.blog') }}
            </router-link>
          </nav>
          <div class="mobile-actions">
            <a href="#" @click.prevent="openDemoModal" class="btn-glow-primary w-full text-center">{{ $t('cta.scheduleDemoFree') }}</a>
          </div>
        </div>
      </div>
    </transition>

    <!-- ─── MAIN ─── -->
    <main>
      <RouterView v-slot="{ Component }">
        <transition name="fade" mode="out-in">
          <component :is="Component" />
        </transition>
      </RouterView>
    </main>

    <!-- ─── FOOTER ─── -->
    <footer v-if="!isAdminRoute" class="c-footer">
      <!-- CTA Band -->
      <div class="cta-band">
        <div class="container cta-inner">
          <div class="cta-text">
            <h3>{{ $t('cta.title') }}</h3>
            <p>{{ $t('cta.subtitle') }}</p>
          </div>
          <div class="cta-actions">
            <a href="#" @click.prevent="openDemoModal" class="btn-glow-primary">{{ $t('cta.scheduleDemoFree') }}</a>
            <a href="#" class="btn btn-outline btn-dark-outline">{{ $t('cta.contactSales') }}</a>
          </div>
        </div>
      </div>

      <div class="footer-body">
        <div class="container">
          <div class="f-grid">
            <div class="f-brand">
              <div class="logo mini">
                <img src="/images/jetschool_logo.png" alt="Jetschool Logo" class="logo-img small" />
              </div>
              <p class="company-desc">
                {{ $t('footer.companyDesc') }}
              </p>
            </div>
            <div class="f-links">
              <div class="f-col">
                <h6>{{ $t('footer.otherProducts') }}</h6>
                <a href="https://virtual.jetschool.id" target="_blank">Virtual Tour</a>
                <a href="https://academy.jetschool.id" target="_blank">Jetschool Academy</a>
                <a href="https://ai.jetschool.id" target="_blank">Jetschool AI</a>
                <a href="https://tahfizku.online" target="_blank">Tahfizku</a>
                <a href="https://silsilah.online" target="_blank">Silsilah Online</a>
              </div>
              <div class="f-col">
                <h6>{{ $t('footer.company') }}</h6>
                <router-link to="/about">{{ $t('footer.about') }}</router-link>
                <a href="#">{{ $t('footer.careers') }}</a>
                <router-link to="/blog">{{ $t('footer.blog') }}</router-link>
                <a href="#">{{ $t('footer.contact') }}</a>
              </div>
              <div class="f-col">
                <h6>{{ $t('footer.support') }}</h6>
                <span>{{ $t('footer.helpCenter') }}</span>
                <span>{{ $t('footer.status') }}</span>
                <span>{{ $t('footer.apiDocs') }}</span>
                <span>{{ $t('footer.community') }}</span>
              </div>
            </div>
          </div>
          <div class="f-bottom">
            <span>{{ $t('footer.copyright') }}</span>
            <div class="f-legal">
              <router-link to="/privacy">{{ $t('footer.privacy') }}</router-link>
              <router-link to="/terms">{{ $t('footer.terms') }}</router-link>
            </div>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>

<style>
html { scroll-behavior: smooth; }
body { overflow-x: hidden; }
</style>

<style scoped>
/* ─── HEADER ─── */
.c-header {
  position: fixed; top: 0; left: 0; right: 0; z-index: 100;
  height: 80px; display: flex; align-items: center;
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}
.scrolled {
  background: rgba(255,251,247,0.9);
  backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
  border-bottom: 1px solid var(--border-light);
  box-shadow: var(--sh-sm);
}

.menu-open {
  background: white !important;
  box-shadow: none !important;
}

.header-row { display: flex; align-items: center; justify-content: space-between; gap: 24px; position: relative; z-index: 101; }

/* Logo */
.logo { display: flex; align-items: center; gap: 12px; text-decoration: none; flex-shrink: 0; }
.logo-img { 
  height: 34px; 
  width: auto; 
  object-fit: contain; 
  transition: filter 0.3s ease; 
}

/* Logo Filter for Dark Background (Initial State) */
.c-header:not(.scrolled):not(.menu-open) .logo-img {
  filter: brightness(0) invert(1); 
}

/* Scrolled State - Original Color */
.scrolled .logo-img, .menu-open .logo-img {
  filter: none;
}

.topnav { display: flex; gap: 32px; align-items: center; }
.topnav a { font-size: 0.95rem; font-weight: 500; color: rgba(255,255,255,0.8); transition: color 0.2s; text-decoration: none; }
.topnav a:hover { color: white; }
.topnav a.router-link-active { color: white; font-weight: 600; }

.scrolled .topnav a { color: var(--ink-soft); }
.scrolled .topnav a:hover, .scrolled .topnav a.router-link-active { color: var(--indigo); }

.header-end { display: flex; align-items: center; gap: 24px; flex-shrink: 0; }

/* ─── LANG SWITCHER ─── */
.lang-switcher { display: flex; align-items: center; }
.lang-select { 
  background: transparent; color: rgba(255,255,255,0.8); 
  border: 1px solid rgba(255,255,255,0.3); padding: 6px; 
  border-radius: var(--r-sm); font-size: 0.85rem; outline: none; cursor: pointer; transition: all 0.3s;
}
.lang-select:hover { border-color: white; color: white; }
.lang-select option { color: #333; }
.scrolled .lang-select, .menu-open .lang-select { border-color: var(--border); color: var(--ink-soft); }
.scrolled .lang-select:hover, .menu-open .lang-select:hover { border-color: var(--indigo); color: var(--indigo); }

/* ─── MOBILE TOGGLE ─── */
.mobile-toggle {
  display: none;
  background: none; border: none;
  padding: 8px; cursor: pointer;
  z-index: 102;
}

.hamburger {
  width: 24px; height: 18px;
  position: relative;
  display: flex; flex-direction: column; justify-content: space-between;
}

.hamburger span {
  display: block; height: 2px; width: 100%;
  background: white; border-radius: 2px;
  transition: all 0.3s ease;
}

.scrolled .hamburger span, .menu-open .hamburger span {
  background: var(--ink);
}

.hamburger.is-active span:nth-child(1) { transform: translateY(8px) rotate(45deg); }
.hamburger.is-active span:nth-child(2) { opacity: 0; }
.hamburger.is-active span:nth-child(3) { transform: translateY(-8px) rotate(-45deg); }

/* ─── MOBILE MENU ─── */
.mobile-menu {
  position: fixed; top: 0; left: 0; right: 0; bottom: 0;
  background: var(--page); z-index: 2000;
  display: flex; flex-direction: column;
}

.mobile-menu-header {
  height: 80px; display: flex; align-items: center; justify-content: space-between;
  padding: 0 32px; border-bottom: 1px solid var(--border-light);
}

.mobile-close {
  background: none; border: none; color: var(--ink); cursor: pointer;
  padding: 8px; display: flex; align-items: center; justify-content: center;
}

.mobile-menu-inner {
  display: flex; flex-direction: column; flex: 1;
  padding-top: 40px; padding-bottom: 40px;
  overflow-y: auto;
}

.mobile-nav {
  display: flex; flex-direction: column; gap: 4px; margin-bottom: 40px;
}

.mobile-nav a {
  font-family: var(--display);
  font-size: 2.2rem; font-weight: 800; color: var(--ink);
  text-decoration: none; padding: 16px 0;
  border-bottom: 1px solid var(--border-light);
  transition: all 0.3s ease;
  display: flex; align-items: baseline; gap: 16px;
  letter-spacing: -0.02em;
}
.mobile-nav a .nav-num {
    font-family: var(--sans);
    font-size: 0.9rem; font-weight: 700; color: var(--indigo);
    opacity: 0.5;
}
.mobile-nav a:last-child { border-bottom: none; }
.mobile-nav a:active { color: var(--indigo); padding-left: 8px; }

.mobile-actions { margin-top: auto; }

/* Transitions */
.slide-down-enter-active, .slide-down-leave-active { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
.slide-down-enter-from, .slide-down-leave-to { opacity: 0; transform: translateY(-20px); }

/* ─── MAIN ─── */
main { min-height: 100vh; }

/* ─── FOOTER ─── */
.cta-band { 
  background: radial-gradient(circle at 70% 50%, #1E293B 0%, #0F172A 100%);
  padding: 80px 0; 
  border-top: 1px solid rgba(255,255,255,0.05);
}
.cta-inner { display: flex; justify-content: space-between; align-items: center; gap: 40px; }
.cta-text h3 { 
  color: white; font-family: var(--serif); font-size: 2.5rem; margin-bottom: 12px; 
  text-shadow: 0 2px 10px rgba(0,0,0,0.3);
}
.cta-text p { color: #94A3B8; font-size: 1.1rem; margin: 0; line-height: 1.6; }
.cta-actions { display: flex; gap: 16px; flex-shrink: 0; align-items: center; }

/* Buttons */
.btn-glow-primary {
  background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
  color: white; padding: 14px 32px; border-radius: 100px;
  font-weight: 700; font-size: 1rem; text-decoration: none;
  box-shadow: 0 4px 20px rgba(249, 115, 22, 0.4), inset 0 1px 0 rgba(255,255,255,0.2);
  transition: all 0.3s ease;
  display: inline-block;
}
.btn-glow-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 30px rgba(249, 115, 22, 0.6);
}

.btn-dark-outline { 
  border: 1px solid rgba(255,255,255,0.15) !important; 
  color: white !important; 
  padding: 14px 32px; border-radius: 100px;
  font-weight: 600; font-size: 1rem; text-decoration: none;
  background: rgba(255,255,255,0.02);
  transition: all 0.3s ease;
}
.btn-dark-outline:hover { 
  border-color: rgba(255,255,255,0.5) !important; 
  background: rgba(255,255,255,0.08) !important; 
  transform: translateY(-2px);
}

.footer-body { background: var(--page); padding: 64px 0 32px; border-top: 1px solid var(--border); }
.f-grid { display: grid; grid-template-columns: 1.3fr 2fr; gap: 80px; margin-bottom: 48px; }
.f-brand p { font-size: 0.95rem; color: var(--ink-muted); margin: 16px 0 20px; max-width: 300px; }

.mini { display: flex; align-items: center; gap: 10px; }

.f-links { display: grid; grid-template-columns: repeat(3, 1fr); gap: 32px; }
.f-col h6 { font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: var(--ink-light); margin-bottom: 20px; }
.f-col a, .f-col span { display: block; font-size: 0.95rem; color: var(--ink-muted); margin-bottom: 14px; transition: color 0.2s; }
.f-col a:hover { color: var(--indigo); }

.f-bottom { border-top: 1px solid var(--border); padding-top: 24px; display: flex; justify-content: space-between; font-size: 0.85rem; color: var(--ink-light); }
.f-legal { display: flex; gap: 24px; }
.f-legal a { color: var(--ink-muted); }
.f-legal a:hover { color: var(--indigo); }

@media (max-width: 1024px) {
  .topnav { display: none; }
  .mobile-toggle { display: block; }
  .header-end { gap: 12px; }
  
  .cta-inner { flex-direction: column; text-align: center; }
  .cta-actions { justify-content: center; flex-wrap: wrap; }
  .f-grid { grid-template-columns: 1fr; gap: 48px; }
  .f-links { grid-template-columns: repeat(2, 1fr); }
  .f-bottom { flex-direction: column; gap: 16px; text-align: center; }
  .f-legal { justify-content: center; }
}
</style>
