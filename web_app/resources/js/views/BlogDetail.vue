<script setup>
import { ref, onMounted, computed, watch } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
import DOMPurify from 'dompurify';

const route = useRoute();
const post = ref(null);
const recommendations = ref([]);
const loading = ref(true);

const reactions = ref({ suka: 0, tertawa: 0, sedih: 0, marah: 0 });
const userReaction = ref(null);
const showReactionPicker = ref(false);

const totalReactions = computed(() => {
    return reactions.value.suka + reactions.value.tertawa + reactions.value.sedih + reactions.value.marah;
});

const currentEmoji = computed(() => {
    if (userReaction.value === 'suka') return '❤️';
    if (userReaction.value === 'tertawa') return '😂';
    if (userReaction.value === 'sedih') return '😢';
    if (userReaction.value === 'marah') return '😡';
    return null;
});

// Sanitize HTML content to prevent XSS
const sanitizeContent = (html) => {
    if (!html) return '';
    return DOMPurify.sanitize(html, {
        ALLOWED_TAGS: ['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'strong', 'em', 'u', 'a', 'img', 'ul', 'ol', 'li', 'blockquote', 'code', 'pre', 'br', 'hr'],
        ALLOWED_ATTR: ['href', 'src', 'alt', 'title', 'class', 'target', 'rel'],
        ADD_ATTR: { 'a': ['target', 'rel'] }
    });
};

const loadPost = async () => {
    loading.value = true;
    try {
        const slug = route.params.slug;
        const response = await axios.get(`/api/posts/${slug}`);
        post.value = response.data;
        // Sanitize content before rendering
        post.value.content = sanitizeContent(post.value.content);
        document.title = post.value.title + ' - Jetschool Insights';

        reactions.value = {
            suka: post.value.count_suka || 0,
            tertawa: post.value.count_tertawa || 0,
            sedih: post.value.count_sedih || 0,
            marah: post.value.count_marah || 0
        };

        if (post.value) {
            const saved = localStorage.getItem(`jetschool_post_react_${post.value.id}`);
            if (saved) userReaction.value = saved;
            
            // Fetch recommendations
            const recResp = await axios.get('/api/posts', { params: { per_page: 3 } });
            if (recResp.data && recResp.data.data) {
                // Exclude current post
                recommendations.value = recResp.data.data.filter(p => p.id !== post.value.id).slice(0, 3);
            }
        }
    } catch (e) {
        console.error('Failed to load post', e);
    } finally {
        loading.value = false;
    }
};

const addReaction = async (type) => {
    if (!post.value) return;
    const action = userReaction.value === type ? 'remove' : 'add';
    const oldReaction = userReaction.value;
    try {
        if (action === 'remove') {
            reactions.value[type] = Math.max(0, reactions.value[type] - 1);
            userReaction.value = null;
            localStorage.removeItem(`jetschool_post_react_${post.value.id}`);
        } else {
            if (oldReaction) {
                reactions.value[oldReaction] = Math.max(0, reactions.value[oldReaction] - 1);
            }
            reactions.value[type]++;
            userReaction.value = type;
            localStorage.setItem(`jetschool_post_react_${post.value.id}`, type);
        }
        showReactionPicker.value = false;
        const response = await axios.post(`/api/posts/${post.value.id}/react`, { type, action });
        if (response.data && response.data.reactions) {
            reactions.value = response.data.reactions;
        }
    } catch (e) {
        console.error('Reaction error:', e);
    }
};

const shareTo = (platform) => {
    const url = encodeURIComponent(window.location.href);
    const text = encodeURIComponent(post.value?.title || 'Baca di Jetschool Insights');
    let shareUrl = '';
    if(platform === 'wa') shareUrl = `https://api.whatsapp.com/send?text=${text} ${url}`;
    if(platform === 'tw') shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${text}`;
    if(platform === 'fb') shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
    if(platform === 'li') shareUrl = `https://www.linkedin.com/shareArticle?mini=true&url=${url}&title=${text}`;
    if(shareUrl) { window.open(shareUrl, '_blank', 'width=600,height=400'); }
};

const formatDate = (dateString) => {
    if(!dateString) return '';
    return new Intl.DateTimeFormat('id-ID', { day: '2-digit', month: 'long', year: 'numeric' }).format(new Date(dateString));
};

const readTime = (text) => {
    if (!text) return '5 min';
    const words = text.replace(/(<([^>]+)>)/gi, "").split(' ').length;
    const time = Math.ceil(words / 200);
    return `${time} menit membaca`;
};

// Re-fetch when slug changes (for recommendations)
watch(() => route.params.slug, () => {
    loadPost();
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

onMounted(() => {
    loadPost();
    window.scrollTo({ top: 0, behavior: 'instant' });
});
</script>

<template>
  <div class="blog-viewer">
    <!-- ─── LOADING STATE ─── -->
    <div v-if="loading" class="loader-full">
        <div class="cosmic-spinner"></div>
    </div>
    
    <div v-else-if="!post" class="error-container container">
        <div class="error-msg">
            <h1>404</h1>
            <p>Narasi tidak ditemukan.</p>
            <router-link to="/blog" class="btn btn-outline">Kembali ke Blog</router-link>
        </div>
    </div>

    <!-- ─── ARTICLE CONTENT ─── -->
    <div v-else class="article-page">
        <!-- Section 1: Hero (Dark) -->
        <section class="article-hero">
            <div class="container hero-inner">
                <nav class="bread">
                    <router-link to="/">Beranda</router-link> <span>/</span> 
                    <router-link to="/blog">Blog</router-link>
                </nav>
                
                <div class="hero-main">
                    <span class="cat-label">{{ post.category }}</span>
                    <h1 class="title-serif">{{ post.title }}</h1>
                    
                    <div class="author-meta">
                        <div class="auth-box">
                            <span class="auth-avatar">J</span>
                            <div class="auth-info">
                                <span class="auth-name">Jetschool Editor</span>
                                <time class="auth-date">{{ formatDate(post.published_at) }}</time>
                            </div>
                        </div>
                        <span class="auth-read">{{ readTime(post.content) }} Baca</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 2: Visual & Body (Light) -->
        <section class="article-reader">
            <div class="container reader-inner">
                
                <!-- Main Image -->
                <div class="hero-image">
                    <img v-if="post.image" :src="post.image" :alt="post.title" />
                    <div v-else class="img-placeholder"></div>
                </div>

                <div class="reader-layout">
                    <!-- Left: Interaction Bar -->
                    <aside class="interact-aside">
                        <div class="sticky-tools">
                            <div class="reaction-tool">
                                <div v-if="showReactionPicker" class="reaction-overlay" @click="showReactionPicker = false"></div>
                                <transition name="fade-scale">
                                    <div v-if="showReactionPicker" class="reaction-box">
                                        <button @click="addReaction('suka')" class="r-btn">❤️</button>
                                        <button @click="addReaction('tertawa')" class="r-btn">😂</button>
                                        <button @click="addReaction('sedih')" class="r-btn">😢</button>
                                        <button @click="addReaction('marah')" class="r-btn">😡</button>
                                    </div>
                                </transition>
                                
                                <button @click="showReactionPicker = !showReactionPicker" :class="['react-trigger', { 'active': userReaction }]">
                                    <span v-if="userReaction" class="active-emoji">{{ currentEmoji }}</span>
                                    <svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 9V5a3 3 0 00-3-3l-4 9v11h11.28a2 2 0 002-1.7l1.38-9a2 2 0 00-2-2.3zM7 22H4a2 2 0 01-2-2v-7a2 2 0 012-2h3"></path></svg>
                                    <span class="react-count">{{ totalReactions }}</span>
                                </button>
                            </div>

                            <div class="share-tools">
                                <button @click="shareTo('wa')" class="s-btn wa"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg></button>
                                <button @click="shareTo('fb')" class="s-btn fb"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></button>
                            </div>
                        </div>
                    </aside>

                    <!-- Center: Article Body -->
                    <article class="article-text">
                        <div class="prose-main" v-html="post.content"></div>
                        
                        <div class="tags-wrap">
                            <span v-for="tag in ['Gaya Belajar', 'Inovasi', post.category]" :key="tag" class="tag">#{{ tag }}</span>
                        </div>
                    </article>

                    <!-- Right: Widget Sidebar -->
                    <aside class="sidebar-aside">
                        <div class="sticky-widget">
                            <div class="widget rec-box">
                                <h3 class="widget-title">Baca Selanjutnya</h3>
                                <div class="rec-stack">
                                    <router-link v-for="rec in recommendations" :key="rec.id" :to="`/blog/${rec.slug}`" class="rec-card">
                                        <div class="rec-info">
                                            <span class="rec-cat">{{ rec.category }}</span>
                                            <p class="rec-title">{{ rec.title }}</p>
                                        </div>
                                    </router-link>
                                </div>
                                <router-link to="/blog" class="btn-more">Lihat Semua Wawasan →</router-link>
                            </div>

                            <div class="widget promo-box">
                                <h3>Digitalisasi Sekolah Kini Lebih Mudah</h3>
                                <p>Coba gratis semua fitur Jetschool selama 14 hari.</p>
                                <a href="#" @click.prevent="openDemoModal" class="btn btn-glow">Jadwalkan Demo</a>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </section>
    </div>
  </div>
</template>

<style scoped>
.blog-viewer { min-height: 100vh; background: var(--page); }

/* ─── HERO (DARK) ─── */
.article-hero {
    background: var(--hero-bg); color: white;
    padding: 160px 0 100px; position: relative; overflow: hidden;
}
.hero-inner { max-width: 900px; text-align: center; }

.bread { margin-bottom: 32px; font-size: 0.9rem; font-weight: 600; color: var(--ink-white-soft); }
.bread a:hover { color: white; }
.bread span { margin: 0 10px; opacity: 0.5; }

.cat-label { 
    display: inline-block; padding: 6px 18px; background: rgba(99, 102, 241, 0.2);
    border: 1px solid rgba(99, 102, 241, 0.3); border-radius: 100px;
    color: #818CF8; font-size: 0.8rem; font-weight: 800; text-transform: uppercase;
    letter-spacing: 0.1em; margin-bottom: 24px;
}

.title-serif {
    font-family: var(--serif); font-size: clamp(2.5rem, 6vw, 4.2rem);
    line-height: 1.1; margin-bottom: 40px; color: white;
}

.author-meta { 
    display: flex; align-items: center; justify-content: center; gap: 32px;
    padding-top: 32px; border-top: 1px solid rgba(255,255,255,0.1);
}
.auth-box { display: flex; align-items: center; gap: 14px; text-align: left; }
.auth-avatar { 
    width: 44px; height: 44px; background: var(--indigo); border-radius: 50%;
    display: flex; align-items: center; justify-content: center; font-weight: 800; font-family: var(--display);
}
.auth-name { display: block; font-weight: 700; font-size: 1rem; color: white; }
.auth-date { font-size: 0.85rem; color: var(--ink-white-soft); }
.auth-read { font-size: 0.9rem; font-weight: 600; color: var(--ink-white-soft); }

/* ─── READER (LIGHT) ─── */
.article-reader { background: var(--page); padding-bottom: 120px; }
.reader-inner { max-width: 1200px; }

.hero-image {
    margin: -60px auto 80px; width: 100%; height: 600px;
    border-radius: var(--r-xl); overflow: hidden; box-shadow: var(--sh-xl);
    position: relative; z-index: 5;
}
.hero-image img { width: 100%; height: 100%; object-fit: cover; }
.img-placeholder { width: 100%; height: 100%; background: #eee; }

.reader-layout {
    display: grid; grid-template-columns: 80px 1fr 320px; gap: 64px; align-items: start;
}

/* Interactions */
.sticky-tools { position: sticky; top: 120px; display: flex; flex-direction: column; align-items: center; gap: 32px; }
.react-trigger {
    width: 60px; height: 100px; border-radius: 100px; border: 1px solid var(--border);
    background: white; display: flex; flex-direction: column; align-items: center; justify-content: center;
    gap: 12px; cursor: pointer; transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
.react-trigger:hover { transform: translateY(-3px); border-color: var(--indigo); box-shadow: var(--sh-md); }
.react-trigger.active { background: var(--indigo-light); border-color: var(--indigo); }
.react-trigger svg { color: var(--ink-muted); width: 22px; }
.react-trigger.active svg { color: var(--indigo); }
.react-count { font-size: 0.85rem; font-weight: 800; color: var(--ink); }
.active-emoji { font-size: 1.8rem; }

.reaction-box {
    position: absolute; left: 70px; top: 0; background: white; border-radius: 100px;
    padding: 8px 16px; display: flex; gap: 10px; border: 1px solid var(--border);
    box-shadow: var(--sh-lg); z-index: 100;
}
.r-btn { font-size: 1.8rem; border: none; background: none; cursor: pointer; transition: transform 0.2s; }
.r-btn:hover { transform: scale(1.3) translateY(-4px); }

.share-tools { display: flex; flex-direction: column; gap: 12px; }
.s-btn { 
    width: 44px; height: 44px; border-radius: 50%; border: 1px solid var(--border);
    background: white; color: var(--ink-muted); display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all 0.2s;
}
.s-btn:hover { background: var(--ink); color: white; border-color: var(--ink); transform: scale(1.1); }

/* Prose Body */
.article-text { max-width: 800px; }
.prose-main { 
    font-family: var(--sans); font-size: 1.25rem; line-height: 1.8; color: var(--ink-soft); 
}
:deep(.prose-main h2) { font-family: var(--serif); font-size: 2.2rem; color: var(--ink); margin: 2em 0 1em; letter-spacing: -0.01em; }
:deep(.prose-main p) { margin-bottom: 2em; }
:deep(.prose-main blockquote) {
    margin: 3em 0; padding: 2em 3rem; background: var(--surface);
    border-left: 4px solid var(--indigo); border-radius: 0 var(--r-md) var(--r-md) 0;
    font-family: var(--serif); font-size: 1.6rem; font-style: italic; color: var(--ink);
}
:deep(.prose-main img) { border-radius: var(--r-lg); margin: 3em 0; }

.tags-wrap { margin-top: 64px; display: flex; gap: 12px; border-top: 1px solid var(--border); padding-top: 32px; }
.tag { font-weight: 700; color: var(--ink-muted); font-size: 0.95rem; }

/* Sidebar Widgets */
.sticky-widget { position: sticky; top: 120px; display: flex; flex-direction: column; gap: 40px; }
.widget { border-radius: var(--r-lg); padding: 32px; }
.rec-box { background: white; border: 1px solid var(--border); }
.widget-title { font-family: var(--serif); font-size: 1.2rem; margin-bottom: 24px; color: var(--ink); }

.rec-stack { display: flex; flex-direction: column; gap: 20px; }
.rec-card { text-decoration: none; display: block; border-bottom: 1px solid var(--border-light); padding-bottom: 20px; }
.rec-card:last-child { border-bottom: none; padding-bottom: 0; }
.rec-cat { display: block; font-size: 0.65rem; font-weight: 800; color: var(--indigo); text-transform: uppercase; margin-bottom: 6px; }
.rec-title { font-size: 0.95rem; font-weight: 700; color: var(--ink); line-height: 1.4; transition: color 0.2s; }
.rec-card:hover .rec-title { color: var(--indigo); }

.btn-more { display: block; margin-top: 24px; text-align: center; font-weight: 700; color: var(--indigo); font-size: 0.9rem; }

.promo-box { background: var(--hero-bg); color: white; }
.promo-box h3 { color: white; font-family: var(--serif); font-size: 1.4rem; margin-bottom: 12px; }
.promo-box p { color: var(--ink-white-soft); font-size: 0.95rem; margin-bottom: 24px; line-height: 1.5; }
.promo-box .btn { width: 100%; border: 1px solid rgba(255,255,255,0.2); }

/* Loading & Error */
.loader-full { height: 60vh; display: flex; align-items: center; justify-content: center; }
.cosmic-spinner { 
    width: 48px; height: 48px; border: 3px solid var(--border); border-top-color: var(--indigo); 
    border-radius: 50%; animation: spin 1s infinite linear; 
}
@keyframes spin { to { transform: rotate(360deg); } }

.error-container { padding: 120px 0; text-align: center; }
.error-msg h1 { font-size: 6rem; opacity: 0.2; margin-bottom: 20px; }

/* Transitions */
.fade-scale-enter-active { animation: fs-in 0.35s cubic-bezier(0.34, 1.56, 0.64, 1); }
.fade-scale-leave-active { animation: fs-in 0.2s reverse ease-in; }
@keyframes fs-in { from { opacity: 0; transform: scale(0.7) translateX(-20px); } to { opacity: 1; transform: scale(1) translateX(0); } }

.reaction-overlay { position: fixed; inset: 0; z-index: 90; }

@media (max-width: 1200px) {
    .reader-layout { grid-template-columns: 1fr 300px; gap: 40px; }
    .interact-aside { display: none; }
}
@media (max-width: 1024px) {
    .hero-image { height: 400px; margin-top: -30px; }
    .reader-layout { grid-template-columns: 1fr; }
    .sidebar-aside { margin-top: 40px; }
    .sticky-widget { position: static; }
}
@media (max-width: 768px) {
    .article-hero { padding: 120px 0 80px; }
    .title-serif { font-size: 2.2rem; }
    .author-meta { flex-direction: column; gap: 20px; }
    .hero-image { height: 260px; margin-bottom: 40px; }
    .prose-main { font-size: 1.15rem; }
}
</style>
