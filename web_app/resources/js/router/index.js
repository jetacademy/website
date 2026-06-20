import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue';
import { useAuth } from '../composables/useAuth';

const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/about',
        name: 'about',
        component: () => import('../views/About.vue')
    },
    {
        path: '/solutions',
        name: 'solutions',
        component: () => import('../views/Solutions.vue')
    },
    {
        path: '/security',
        name: 'security',
        component: () => import('../views/Security.vue')
    },
    {
        path: '/pricing',
        name: 'pricing',
        component: () => import('../views/Pricing.vue')
    },
    {
        path: '/contact',
        name: 'contact',
        component: () => import('../views/Contact.vue')
    },
    {
        path: '/privacy',
        name: 'privacy',
        component: () => import('../views/Privacy.vue')
    },
    {
        path: '/lockandlearnprivacy',
        name: 'lockandlearn-privacy',
        component: () => import('../views/LockAndLearnPrivacy.vue')
    },
    {
        path: '/terms',
        name: 'terms',
        component: () => import('../views/Terms.vue')
    },
    {
        path: '/affiliate',
        name: 'affiliate',
        component: () => import('../views/Affiliate.vue')
    },
    {
        path: '/affiliate/dashboard',
        name: 'affiliate-dashboard',
        component: () => import('../views/AffiliateDashboard.vue'),
        meta: { requiresAuth: true }
    },
    {
        path: '/login',
        name: 'admin-login',
        component: () => import('../views/AdminLogin.vue'),
        meta: { guestOnly: true }
    },
    {
        path: '/webadmin',
        component: () => import('../views/admin/AdminLayout.vue'),
        meta: { requiresAuth: true, requiresAdmin: true },
        children: [
            { path: '', name: 'admin-leads', component: () => import('../views/admin/AdminLeads.vue') },
            { path: 'blog', name: 'admin-blog', component: () => import('../views/admin/AdminBlog.vue') },
            { path: 'affiliates', name: 'admin-affiliates', component: () => import('../views/admin/AdminAffiliates.vue') },
            { path: 'users', name: 'admin-users', component: () => import('../views/admin/AdminUsers.vue') },
            { path: 'stats', name: 'admin-stats', component: () => import('../views/admin/AdminStats.vue') },
        ]
    },
    {
        path: '/blog',
        name: 'blog',
        component: () => import('../views/Blog.vue')
    },
    {
        path: '/blog/:slug',
        name: 'blog-detail',
        component: () => import('../views/BlogDetail.vue')
    }
];

const router = createRouter({
    history: createWebHistory('/'),
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition;
        } else if (to.hash) {
            return {
                el: to.hash,
                behavior: 'smooth',
            };
        } else {
            return { top: 0 };
        }
    }
});

// Navigation Guards
router.beforeEach(async (to, from, next) => {
    const auth = useAuth();

    // Fetch user if not yet loaded
    if (auth.isLoading.value) {
        await auth.fetchUser();
    }

    // Guest-only routes (login page) — redirect if already authenticated
    if (to.meta.guestOnly && auth.isAuthenticated.value) {
        if (auth.isAdmin()) {
            return next('/webadmin');
        }
        return next('/');
    }

    // Protected routes
    if (to.meta.requiresAuth) {
        if (!auth.isAuthenticated.value) {
            return next('/login');
        }

        // Admin-only routes
        if (to.meta.requiresAdmin && !auth.isAdmin()) {
            return next('/');
        }
    }

    next();
});

export default router;
