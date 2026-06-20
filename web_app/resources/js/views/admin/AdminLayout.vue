<template>
  <div class="admin-shell" v-if="!loading">
    <!-- Sidebar -->
    <aside :class="['sidebar', { collapsed: sidebarCollapsed, open: sidebarMobileOpen }]">
      <div class="sidebar-header">
        <div class="sidebar-brand">
          <div class="brand-mark">
            <svg width="28" height="28" viewBox="0 0 48 48" fill="none">
              <rect width="48" height="48" rx="12" fill="url(#sideGrad)" />
              <path d="M16 32V20l8-6 8 6v12l-8 4-8-4z" fill="rgba(255,255,255,0.9)" />
              <path d="M24 14l8 6v12l-8 4V14z" fill="rgba(255,255,255,0.6)" />
              <defs>
                <linearGradient id="sideGrad" x1="0" y1="0" x2="48" y2="48">
                  <stop stop-color="#6366F1" />
                  <stop offset="1" stop-color="#8B5CF6" />
                </linearGradient>
              </defs>
            </svg>
          </div>
          <Transition name="fade-text">
            <span v-if="!sidebarCollapsed" class="brand-text">Jetschool</span>
          </Transition>
        </div>
        <button class="collapse-btn" @click="toggleSidebar" aria-label="Toggle sidebar">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline :points="sidebarCollapsed ? '9 18 15 12 9 6' : '15 18 9 12 15 6'" />
          </svg>
        </button>
      </div>

      <nav class="sidebar-nav">
        <div class="nav-section">
          <span v-if="!sidebarCollapsed" class="nav-label">Menu Utama</span>
          <router-link
            v-for="item in mainMenu"
            :key="item.to"
            :to="item.to"
            :class="['nav-item', { active: activeMenu === item.key }]"
            @click="closeMobileSidebar"
            :title="item.label"
          >
            <span class="nav-icon" v-html="item.icon"></span>
            <Transition name="fade-text">
              <span v-if="!sidebarCollapsed" class="nav-text">{{ item.label }}</span>
            </Transition>
            <Transition name="fade-text">
              <span v-if="!sidebarCollapsed && item.badge" class="nav-badge">{{ item.badge }}</span>
            </Transition>
          </router-link>
        </div>

        <div class="nav-section">
          <span v-if="!sidebarCollapsed" class="nav-label">Sistem</span>
          <router-link
            v-for="item in systemMenu"
            :key="item.to"
            :to="item.to"
            :class="['nav-item', { active: activeMenu === item.key }]"
            @click="closeMobileSidebar"
            :title="item.label"
          >
            <span class="nav-icon" v-html="item.icon"></span>
            <Transition name="fade-text">
              <span v-if="!sidebarCollapsed" class="nav-text">{{ item.label }}</span>
            </Transition>
          </router-link>
        </div>
      </nav>

      <div class="sidebar-footer">
        <button class="nav-item logout-item" @click="handleLogout" :title="'Logout'">
          <span class="nav-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" /><polyline points="16 17 21 12 16 7" /><line x1="21" y1="12" x2="9" y2="12" />
            </svg>
          </span>
          <Transition name="fade-text">
            <span v-if="!sidebarCollapsed" class="nav-text">Keluar</span>
          </Transition>
        </button>
      </div>
    </aside>

    <!-- Mobile Backdrop -->
    <Transition name="fade">
      <div v-if="sidebarMobileOpen" class="mobile-backdrop" @click="closeMobileSidebar"></div>
    </Transition>

    <!-- Main Area -->
    <div class="main-area">
      <!-- Top Bar -->
      <header class="topbar">
        <div class="topbar-left">
          <button class="mobile-menu-btn" @click="sidebarMobileOpen = true" aria-label="Open menu">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="3" y1="6" x2="21" y2="6" /><line x1="3" y1="12" x2="21" y2="12" /><line x1="3" y1="18" x2="21" y2="18" />
            </svg>
          </button>
          <div class="page-title">
            <h1>{{ currentPageTitle }}</h1>
          </div>
        </div>

        <div class="topbar-right">
          <div class="user-chip" @click="userMenuOpen = !userMenuOpen">
            <img :src="avatarUrl" alt="User" class="user-avatar" />
            <span class="user-name">{{ currentUser?.name || 'Admin' }}</span>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="6 9 12 15 18 9" />
            </svg>
          </div>

          <Transition name="dropdown">
            <div v-if="userMenuOpen" class="user-dropdown">
              <div class="dropdown-header">
                <strong>{{ currentUser?.name }}</strong>
                <span>{{ currentUser?.email }}</span>
              </div>
              <div class="dropdown-divider"></div>
              <button class="dropdown-item" @click="handleLogout">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" /><polyline points="16 17 21 12 16 7" /><line x1="21" y1="12" x2="9" y2="12" />
                </svg>
                Keluar
              </button>
            </div>
          </Transition>
        </div>
      </header>

      <!-- Content -->
      <main class="content-area">
        <router-view :current-user="currentUser" />
      </main>
    </div>
  </div>

  <!-- Loading State -->
  <div v-else class="admin-loader">
    <div class="loader-content">
      <div class="loader-spinner">
        <svg width="40" height="40" viewBox="0 0 48 48" fill="none">
          <rect width="48" height="48" rx="12" fill="url(#loadGrad)" />
          <path d="M16 32V20l8-6 8 6v12l-8 4-8-4z" fill="rgba(255,255,255,0.9)" />
          <defs>
            <linearGradient id="loadGrad" x1="0" y1="0" x2="48" y2="48">
              <stop stop-color="#6366F1" /><stop offset="1" stop-color="#8B5CF6" />
            </linearGradient>
          </defs>
        </svg>
      </div>
      <p>Memuat panel admin...</p>
    </div>
  </div>

  <AdminToast />
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useAuth } from '../../composables/useAuth';
import AdminToast from '../../components/AdminToast.vue';

const router = useRouter();
const route = useRoute();
const auth = useAuth();

const currentUser = computed(() => auth.currentUser.value);
const loading = ref(true);
const sidebarCollapsed = ref(false);
const sidebarMobileOpen = ref(false);
const userMenuOpen = ref(false);

const mainMenu = [
    {
        key: 'leads',
        to: '/webadmin',
        label: 'Leads',
        icon: '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>',
    },
    {
        key: 'blog',
        to: '/webadmin/blog',
        label: 'Blog & Artikel',
        icon: '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>',
    },
    {
        key: 'affiliates',
        to: '/webadmin/affiliates',
        label: 'Mitra Affiliate',
        icon: '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg>',
    },
];

const systemMenu = [
    {
        key: 'users',
        to: '/webadmin/users',
        label: 'Pengguna & Role',
        icon: '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
    },
    {
        key: 'stats',
        to: '/webadmin/stats',
        label: 'Statistik',
        icon: '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>',
    },
];

const menuMap = {
    '/webadmin': 'leads',
    '/webadmin/blog': 'blog',
    '/webadmin/affiliates': 'affiliates',
    '/webadmin/users': 'users',
    '/webadmin/stats': 'stats',
};

const pageTitles = {
    leads: 'Data Pendaftaran',
    blog: 'Blog & Artikel',
    affiliates: 'Mitra Affiliate',
    users: 'Pengguna & Role',
    stats: 'Statistik',
};

const activeMenu = ref('leads');
const currentPageTitle = computed(() => pageTitles[activeMenu.value] || 'Dashboard');

watch(() => route.path, (path) => {
    activeMenu.value = menuMap[path] || 'leads';
}, { immediate: true });

const avatarUrl = computed(() => {
    const name = encodeURIComponent(currentUser.value?.name || 'Admin');
    return `https://ui-avatars.com/api/?name=${name}&background=6366F1&color=fff&size=80&bold=true`;
});

const toggleSidebar = () => {
    sidebarCollapsed.value = !sidebarCollapsed.value;
};

const closeMobileSidebar = () => {
    sidebarMobileOpen.value = false;
};

const handleLogout = async () => {
    await auth.logout();
    window.location.href = '/login';
};

// Close user menu on outside click
const handleOutsideClick = (e) => {
    if (userMenuOpen.value && !e.target.closest('.topbar-right')) {
        userMenuOpen.value = false;
    }
};

onMounted(async () => {
    document.addEventListener('click', handleOutsideClick);

    // Auth is already checked by router guard, just load user data
    if (!auth.currentUser.value) {
        await auth.fetchUser();
    }

    if (!auth.isAuthenticated.value || !auth.isAdmin()) {
        router.push('/login');
        return;
    }

    loading.value = false;
});

onUnmounted(() => {
    document.removeEventListener('click', handleOutsideClick);
});
</script>

<style scoped>
/* ═══ VARIABLES ═══ */
.admin-shell {
  --sidebar-w: 260px;
  --sidebar-collapsed-w: 72px;
  --topbar-h: 64px;
  --primary: #6366F1;
  --primary-light: #EEF2FF;
  --surface: #F8FAFC;
  --border: #E2E8F0;
  --text: #1E293B;
  --text-muted: #64748B;

  display: flex;
  min-height: 100vh;
  background: var(--surface);
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
  color: var(--text);
}

/* ═══ SIDEBAR ═══ */
.sidebar {
  width: var(--sidebar-w);
  background: #fff;
  border-right: 1px solid var(--border);
  display: flex;
  flex-direction: column;
  position: fixed;
  top: 0;
  left: 0;
  height: 100vh;
  z-index: 100;
  transition: width 0.25s cubic-bezier(0.4, 0, 0.2, 1);
  overflow: hidden;
}

.sidebar.collapsed {
  width: var(--sidebar-collapsed-w);
}

.sidebar-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 20px 16px;
  border-bottom: 1px solid var(--border);
  min-height: 72px;
}

.sidebar-brand {
  display: flex;
  align-items: center;
  gap: 12px;
  overflow: hidden;
}

.brand-mark {
  flex-shrink: 0;
}

.brand-text {
  font-size: 1.1rem;
  font-weight: 800;
  color: var(--text);
  white-space: nowrap;
  letter-spacing: -0.02em;
}

.collapse-btn {
  background: none;
  border: none;
  cursor: pointer;
  padding: 6px;
  border-radius: 8px;
  color: var(--text-muted);
  transition: all 0.2s;
  flex-shrink: 0;
}

.collapse-btn:hover {
  background: var(--primary-light);
  color: var(--primary);
}

/* Navigation */
.sidebar-nav {
  flex: 1;
  padding: 16px 12px;
  overflow-y: auto;
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.nav-section {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.nav-section + .nav-section {
  margin-top: 20px;
  padding-top: 20px;
  border-top: 1px solid var(--border);
}

.nav-label {
  font-size: 0.68rem;
  font-weight: 800;
  color: #94A3B8;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  padding: 0 12px;
  margin-bottom: 8px;
  white-space: nowrap;
}

.nav-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 10px 12px;
  border-radius: 10px;
  color: var(--text-muted);
  font-weight: 600;
  font-size: 0.88rem;
  text-decoration: none;
  transition: all 0.15s ease;
  cursor: pointer;
  border: none;
  background: none;
  width: 100%;
  text-align: left;
  white-space: nowrap;
}

.nav-item:hover {
  background: var(--surface);
  color: var(--text);
}

.nav-item.active {
  background: var(--primary-light);
  color: var(--primary);
}

.nav-icon {
  flex-shrink: 0;
  width: 20px;
  height: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.nav-text {
  white-space: nowrap;
  overflow: hidden;
}

.nav-badge {
  margin-left: auto;
  background: var(--primary);
  color: #fff;
  font-size: 0.7rem;
  font-weight: 800;
  padding: 2px 8px;
  border-radius: 100px;
}

/* Sidebar Footer */
.sidebar-footer {
  padding: 12px;
  border-top: 1px solid var(--border);
}

.logout-item {
  color: #EF4444 !important;
}

.logout-item:hover {
  background: #FEF2F2 !important;
}

/* ═══ MAIN AREA ═══ */
.main-area {
  flex: 1;
  margin-left: var(--sidebar-w);
  transition: margin-left 0.25s cubic-bezier(0.4, 0, 0.2, 1);
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.sidebar.collapsed ~ .main-area,
.admin-shell:has(.sidebar.collapsed) .main-area {
  margin-left: var(--sidebar-collapsed-w);
}

/* ═══ TOPBAR ═══ */
.topbar {
  height: var(--topbar-h);
  background: #fff;
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 28px;
  position: sticky;
  top: 0;
  z-index: 50;
}

.topbar-left {
  display: flex;
  align-items: center;
  gap: 16px;
}

.mobile-menu-btn {
  display: none;
  background: none;
  border: none;
  cursor: pointer;
  padding: 6px;
  color: var(--text-muted);
  border-radius: 8px;
}

.mobile-menu-btn:hover {
  background: var(--surface);
}

.page-title h1 {
  font-size: 1.25rem;
  font-weight: 800;
  color: var(--text);
  margin: 0;
  letter-spacing: -0.02em;
}

.topbar-right {
  position: relative;
  display: flex;
  align-items: center;
}

.user-chip {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 6px 12px 6px 6px;
  border-radius: 100px;
  cursor: pointer;
  transition: background 0.15s;
  border: 1px solid var(--border);
}

.user-chip:hover {
  background: var(--surface);
}

.user-avatar {
  width: 32px;
  height: 32px;
  border-radius: 50%;
}

.user-name {
  font-weight: 600;
  font-size: 0.88rem;
  color: var(--text);
}

/* User Dropdown */
.user-dropdown {
  position: absolute;
  top: calc(100% + 8px);
  right: 0;
  background: #fff;
  border: 1px solid var(--border);
  border-radius: 12px;
  box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.15);
  min-width: 200px;
  overflow: hidden;
  z-index: 200;
}

.dropdown-header {
  padding: 14px 16px;
}

.dropdown-header strong {
  display: block;
  font-size: 0.9rem;
  color: var(--text);
}

.dropdown-header span {
  font-size: 0.8rem;
  color: var(--text-muted);
}

.dropdown-divider {
  height: 1px;
  background: var(--border);
}

.dropdown-item {
  display: flex;
  align-items: center;
  gap: 10px;
  width: 100%;
  padding: 12px 16px;
  border: none;
  background: none;
  cursor: pointer;
  font-size: 0.88rem;
  font-weight: 600;
  color: #EF4444;
  transition: background 0.15s;
}

.dropdown-item:hover {
  background: #FEF2F2;
}

/* ═══ CONTENT ═══ */
.content-area {
  flex: 1;
  padding: 32px;
  overflow-y: auto;
}

/* ═══ LOADING ═══ */
.admin-loader {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: var(--surface);
}

.loader-content {
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 16px;
}

.loader-spinner {
  animation: pulse 1.5s ease-in-out infinite;
}

@keyframes pulse {
  0%, 100% { transform: scale(1); opacity: 1; }
  50% { transform: scale(1.05); opacity: 0.7; }
}

.loader-content p {
  color: var(--text-muted);
  font-weight: 600;
  font-size: 0.9rem;
}

/* ═══ MOBILE BACKDROP ═══ */
.mobile-backdrop {
  display: none;
}

/* ═══ TRANSITIONS ═══ */
.fade-text-enter-active { transition: opacity 0.2s ease 0.1s; }
.fade-text-leave-active { transition: opacity 0.1s ease; }
.fade-text-enter-from, .fade-text-leave-to { opacity: 0; }

.fade-enter-active, .fade-leave-active { transition: opacity 0.2s; }
.fade-enter-from, .fade-leave-to { opacity: 0; }

.dropdown-enter-active { transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); }
.dropdown-leave-active { transition: all 0.15s ease; }
.dropdown-enter-from, .dropdown-leave-to { opacity: 0; transform: translateY(-8px) scale(0.95); }

/* ═══ RESPONSIVE ═══ */
@media (max-width: 1024px) {
  .sidebar {
    position: fixed;
    left: -280px;
    width: var(--sidebar-w) !important;
    box-shadow: none;
    transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s;
  }

  .sidebar.open {
    left: 0;
    box-shadow: 8px 0 30px rgba(0, 0, 0, 0.15);
  }

  .sidebar.collapsed {
    width: var(--sidebar-w) !important;
  }

  .collapse-btn {
    display: none;
  }

  .main-area {
    margin-left: 0 !important;
  }

  .mobile-menu-btn {
    display: flex;
  }

  .mobile-backdrop {
    display: block;
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.4);
    backdrop-filter: blur(4px);
    z-index: 90;
  }

  .content-area {
    padding: 24px 20px;
  }
}

@media (max-width: 640px) {
  .topbar {
    padding: 0 16px;
    height: 56px;
  }

  .page-title h1 {
    font-size: 1.1rem;
  }

  .user-name {
    display: none;
  }

  .user-chip {
    padding: 4px;
    border: none;
  }

  .content-area {
    padding: 16px 12px;
  }
}
</style>
