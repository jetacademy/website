<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

const articles = ref([]);
const loading = ref(true);
const activeCategory = ref('');
const currentPage = ref(1);
const lastPage = ref(1);
const totalPosts = ref(0);

const categories = ['Edukasi', 'Teknologi', 'Manajemen', 'Berita', 'Panduan'];

const loadPosts = async (page = 1) => {
    loading.value = true;
    try {
        const params = { page };
        if (activeCategory.value) params.category = activeCategory.value;
        
        const response = await axios.get('/api/posts', { params });
        const data = response.data;
        
        // Handle paginated response
        if (data.data) {
            articles.value = data.data;
            currentPage.value = data.current_page;
            lastPage.value = data.last_page;
            totalPosts.value = data.total;
        } else if (Array.isArray(data)) {
            articles.value = data;
            lastPage.value = 1;
        }
    } catch (e) {
        console.error(e);
        articles.value = [];
    } finally {
        loading.value = false;
    }
};

const setCategory = (cat) => {
    activeCategory.value = cat;
    currentPage.value = 1;
    loadPosts(1);
};

const goToPage = (page) => {
    if (page < 1 || page > lastPage.value) return;
    loadPosts(page);
    window.scrollTo({ top: 0, behavior: 'smooth' });
};

const pageNumbers = computed(() => {
    const pages = [];
    const total = lastPage.value;
    const current = currentPage.value;
    
    if (total <= 5) {
        for (let i = 1; i <= total; i++) pages.push(i);
    } else {
        pages.push(1);
        if (current > 3) pages.push('...');
        for (let i = Math.max(2, current - 1); i <= Math.min(total - 1, current + 1); i++) {
            pages.push(i);
        }
        if (current < total - 2) pages.push('...');
        pages.push(total);
    }
    return pages;
});

const formatDate = (dateString) => {
    if(!dateString) return '';
    return new Intl.DateTimeFormat('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }).format(new Date(dateString));
};

// Fungsi estimasi waktu baca
const readTime = (text) => {
    if (!text) return '3 menit';
    const words = text.replace(/(<([^>]+)>)/gi, "").split(' ').length;
    const time = Math.ceil(words / 225); // Rerata baca orang dewasa
    return `${time} min read`;
};

onMounted(() => {
    loadPosts();
});
</script>

<template>
  <div class="blog-magazine-page relative overflow-hidden">
    <!-- Ambient Background Elements for Premium Feel -->
    <div class="ambient-bg">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
    </div>
    <div class="grid-overlay"></div>

    <div class="container blog-container">
      
      <!-- HEADER/HERO MAGZ -->
      <header class="blog-header text-center slide-up stagger-1 relative z-10">
        <div class="badge-new mb-6 inline-flex mx-auto">
            <span class="pulse-dot"></span>
            Jetschool Newsroom
        </div>
        <h1 class="magz-title">
            The School <br/>
            <span class="gradient-text italic-serif">Insights & Innovation.</span>
        </h1>
        <p class="magz-subtitle">
            Perspektif, strategi, dan inovasi seputar ekosistem pendidikan digital masa depan. Baca artikel terbaru dari pakar kami.
        </p>
        
        <div class="category-filters mt-10">
            <button :class="['filter-btn', { active: activeCategory === '' }]" @click="setCategory('')">View All</button>
            <button v-for="cat in categories" :key="cat" :class="['filter-btn', { active: activeCategory === cat }]" @click="setCategory(cat)">{{ cat }}</button>
        </div>
      </header>

      <!-- Loading -->
      <div v-if="loading" class="loading-state slide-up stagger-2 relative z-10">
        <div class="spinner"></div>
        <p>Memuat wawasan terbaru...</p>
      </div>

      <!-- Empty State -->
      <div v-else-if="articles.length === 0" class="empty-state slide-up stagger-2 relative z-10">
        <div class="empty-icon">📝</div>
        <h3>Belum Ada Artikel</h3>
        <p v-if="activeCategory">Tidak ada artikel untuk kategori <strong>"{{ activeCategory }}"</strong>. <br/><br/><button @click="setCategory('')" class="link-reset btn-glow-small">Tampilkan Semua</button></p>
        <p v-else>Artikel akan segera tersedia, nantikan update selanjutnya.</p>
      </div>

      <template v-else>
      <!-- FEATURED POST (Berita Utama) -->
      <section v-if="articles.length > 0 && currentPage === 1" class="featured-post-section slide-up stagger-2 relative z-10">
        <div class="featured-post premium-glass card-hover-fx">
            <router-link :to="`/blog/${articles[0].slug}`" class="featured-img-wrapper">
                <img v-if="articles[0].image" :src="articles[0].image" :alt="articles[0].title" class="feat-img" />
                <div v-else class="featured-img-placeholder">
                    <h2>{{ articles[0].title.substring(0,30) }}...</h2>
                </div>
                <div class="featured-badge glass-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                    Spotlight
                </div>
            </router-link>
            <div class="featured-content">
                <div class="meta-data mb-4">
                    <span class="tag-pill">{{ articles[0].category || 'General' }}</span>
                    <span class="meta-group">
                        <span class="date">{{ formatDate(articles[0].published_at || articles[0].created_at) }}</span>
                        <span class="separator"></span>
                        <span class="read-time">{{ readTime(articles[0].content) }}</span>
                    </span>
                </div>
                <h2 class="featured-title">
                    <router-link :to="`/blog/${articles[0].slug}`">{{ articles[0].title }}</router-link>
                </h2>
                <p class="featured-excerpt">{{ articles[0].excerpt }}</p>
                
                <div class="featured-footer mt-8">
                    <router-link :to="`/blog/${articles[0].slug}`" class="read-more-link">
                        Baca Selengkapnya 
                        <span class="arrow-icon">→</span>
                    </router-link>
                </div>
            </div>
        </div>
      </section>

      <!-- ARTICLE GRID -->
      <section v-if="(currentPage === 1 && articles.length > 1) || currentPage > 1" class="article-grid slide-up stagger-3 relative z-10" :class="{ 'mt-20': currentPage === 1 }">
        
        <div v-if="currentPage === 1" class="grid-header max-w-full w-full col-span-full mb-4 flex justify-between items-end">
            <h3 class="text-2xl font-serif text-slate-900 mb-0">Artikel Terbaru</h3>
            <div class="h-px bg-slate-200 flex-grow ml-6 mb-3"></div>
        </div>

        <article v-for="post in (currentPage === 1 ? articles.slice(1) : articles)" :key="post.id" class="post-card premium-glass card-hover-fx">
            <router-link :to="`/blog/${post.slug}`" class="post-img-wrapper">
                <img v-if="post.image" :src="post.image" :alt="post.title" class="grid-img" />
                <div v-else class="post-img-placeholder">
                    <span>{{ post.category || 'Article' }}</span>
                </div>
                <div class="glass-badge pos-abs">{{ post.category || 'General' }}</div>
            </router-link>
            <div class="post-content">
                <div class="meta-data mb-3">
                    <span class="date">{{ formatDate(post.published_at || post.created_at) }}</span>
                    <span class="separator"></span>
                    <span class="read-time">{{ readTime(post.content) }}</span>
                </div>
                <h3 class="post-title">
                    <router-link :to="`/blog/${post.slug}`" class="line-clamp-2" :title="post.title">{{ post.title }}</router-link>
                </h3>
                <p class="post-excerpt line-clamp-3">{{ post.excerpt }}</p>
                
                <div class="mt-auto pt-6 flex items-center justify-between border-t border-slate-100/50">
                    <router-link :to="`/blog/${post.slug}`" class="card-link">
                        Baca <span class="arrow-icon">→</span>
                    </router-link>
                </div>
            </div>
        </article>
      </section>
      </template>

      <!-- PAGINATION -->
      <div v-if="lastPage > 1 && !loading" class="pagination slide-up stagger-4 relative z-10 mt-16 pb-8">
          <button class="page-btn prev-next" :disabled="currentPage <= 1" @click="goToPage(currentPage - 1)">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
            Prev
          </button>
          
          <div class="page-numbers">
            <template v-for="(p, idx) in pageNumbers" :key="idx">
                <span v-if="p === '...'" class="page-dots">...</span>
                <button v-else :class="['page-btn', { active: p === currentPage }]" @click="goToPage(p)">{{ p }}</button>
            </template>
          </div>

          <button class="page-btn prev-next" :disabled="currentPage >= lastPage" @click="goToPage(currentPage + 1)">
            Next
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
          </button>
      </div>

    </div>
  </div>
</template>

<style scoped>
/* 
 * PREMIUM ENTERPRISE BLOG THEME
 * Inspired by modern tech SaaS aesthetics 
 */

.blog-magazine-page {
    position: relative;
    padding: 160px 0 60px;
    background: #FAFAFA;
    min-height: 100vh;
    font-family: var(--sans, 'Inter', sans-serif);
}

.blog-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 24px;
    position: relative;
}

/* ━ Ambient Background & Grid ━ */
.ambient-bg {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 800px;
    overflow: hidden;
    z-index: 0;
    pointer-events: none;
}
.blob {
    position: absolute;
    filter: blur(80px);
    border-radius: 50%;
    opacity: 0.6;
    animation: float 20s ease-in-out infinite;
}
.blob-1 {
    top: -100px; left: -10%;
    width: 600px; height: 600px;
    background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, rgba(99, 102, 241, 0) 70%);
}
.blob-2 {
    top: -50px; right: -5%;
    width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(249, 115, 22, 0.1) 0%, rgba(249, 115, 22, 0) 70%);
    animation-delay: -5s;
}
.blob-3 {
    top: 300px; left: 40%;
    width: 800px; height: 400px;
    background: radial-gradient(circle, rgba(20, 184, 166, 0.08) 0%, rgba(20, 184, 166, 0) 70%);
    animation-delay: -10s;
}

@keyframes float {
    0%, 100% { transform: translateY(0) scale(1); }
    50% { transform: translateY(20px) scale(1.05); }
}

.grid-overlay {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    background-image: 
        linear-gradient(to right, rgba(0,0,0,0.02) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(0,0,0,0.02) 1px, transparent 1px);
    background-size: 40px 40px;
    mask-image: linear-gradient(to bottom, black 0%, transparent 80%);
    -webkit-mask-image: linear-gradient(to bottom, black 0%, transparent 80%);
    z-index: 0;
    pointer-events: none;
}

/* ━ Header Typography ━ */
.badge-new {
    background: white;
    border: 1px solid rgba(0,0,0,0.05);
    padding: 6px 16px;
    border-radius: 100px;
    font-size: 0.85rem;
    font-weight: 600;
    color: #475569;
    box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    align-items: center;
    gap: 8px;
}
.pulse-dot {
    width: 8px; height: 8px;
    background: #10B981;
    border-radius: 50%;
    box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4);
    animation: pulse-dot 2s infinite;
}
@keyframes pulse-dot {
    0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
    70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
    100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
}

.magz-title {
    font-size: clamp(3rem, 6vw, 5rem);
    font-weight: 900;
    line-height: 1.1;
    letter-spacing: -0.02em;
    color: #0F172A;
    margin-bottom: 24px;
}

.italic-serif {
    font-family: var(--serif, 'Playfair Display', serif);
    font-style: italic;
    font-weight: 700;
}

.gradient-text {
    background: linear-gradient(135deg, #4F46E5 0%, #E11D48 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.magz-subtitle {
    font-size: 1.25rem;
    color: #64748B;
    max-width: 650px;
    margin: 0 auto;
    line-height: 1.7;
}

/* ━ Categor Filters ━ */
.category-filters {
    display: flex;
    justify-content: center;
    gap: 10px;
    flex-wrap: wrap;
}
.filter-btn {
    background: rgba(255, 255, 255, 0.6);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(0,0,0,0.06);
    padding: 10px 24px;
    border-radius: 100px;
    font-size: 0.95rem;
    font-weight: 600;
    color: #64748B;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    box-shadow: 0 4px 15px rgba(0,0,0,0.02);
}
.filter-btn:hover {
    transform: translateY(-2px);
    border-color: rgba(99, 102, 241, 0.3);
    color: #0F172A;
    box-shadow: 0 8px 25px rgba(0,0,0,0.05);
}
.filter-btn.active {
    background: #0F172A;
    color: white;
    border-color: #0F172A;
    box-shadow: 0 8px 25px rgba(15, 23, 42, 0.2);
}

/* ━ Premium Glass Components ━ */
.premium-glass {
    background: white;
    border: 1px solid rgba(226, 232, 240, 0.8);
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 10px 40px -10px rgba(15, 23, 42, 0.05),
                0 0 0 1px rgba(255,255,255,0.5) inset;
    position: relative;
    z-index: 1;
}

.card-hover-fx {
    transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1), 
                box-shadow 0.5s cubic-bezier(0.16, 1, 0.3, 1),
                border-color 0.5s ease;
}
.card-hover-fx:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 60px -15px rgba(15, 23, 42, 0.1),
                0 0 0 1px rgba(255,255,255,0.8) inset;
    border-color: rgba(99, 102, 241, 0.2);
}

.glass-badge {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    padding: 6px 14px;
    border-radius: 100px;
    font-size: 0.8rem;
    font-weight: 700;
    color: #0F172A;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.pos-abs {
    position: absolute;
    top: 20px;
    left: 20px;
    z-index: 2;
}

/* ━ Featured Post ━ */
.featured-post-section {
    margin-top: 60px;
    margin-bottom: 60px;
}
.featured-post {
    display: grid;
    grid-template-columns: 1.1fr 0.9fr;
    min-height: 480px;
}

.featured-img-wrapper {
    position: relative;
    height: 100%;
    min-height: 400px;
    overflow: hidden;
    background: #0F172A; /* Dark fallback */
    display: block;
}
.featured-img-wrapper::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(to right, transparent, rgba(0,0,0,0.05));
    pointer-events: none;
    z-index: 1;
}

.feat-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1), filter 0.5s ease;
}
.card-hover-fx:hover .feat-img {
    transform: scale(1.05);
}

.featured-img-placeholder {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    background: linear-gradient(135deg, #1E1B4B, #312E81);
    color: white;
    padding: 40px;
    text-align: center;
}
.featured-img-placeholder h2 {
    font-family: var(--serif, serif);
    font-size: 2.5rem;
    opacity: 0.5;
    line-height: 1.2;
}

.featured-badge {
    position: absolute;
    top: 32px; left: 32px;
    z-index: 2;
}

.featured-content {
    padding: 64px 56px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    background: white;
}

/* Meta Data styling */
.meta-data {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    font-size: 0.85rem;
}
.tag-pill {
    background: #EEF2FF;
    color: #4F46E5;
    padding: 4px 12px;
    border-radius: 6px;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}
.meta-group {
    display: flex;
    align-items: center;
    color: #64748B;
    font-weight: 600;
}
.separator {
    width: 4px; height: 4px;
    border-radius: 50%;
    background: #CBD5E1;
    margin: 0 10px;
}

.featured-title {
    font-family: var(--serif, serif);
    font-size: clamp(2rem, 3vw, 2.75rem);
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 20px;
    letter-spacing: -0.01em;
}
.featured-title a {
    color: #0F172A;
    background-image: linear-gradient(#0F172A, #0F172A);
    background-size: 0% 2px;
    background-repeat: no-repeat;
    background-position: left bottom;
    transition: background-size 0.3s ease, color 0.3s ease;
}
.featured-title a:hover {
    color: #4F46E5;
}
.card-hover-fx:hover .featured-title a {
    background-size: 100% 2px;
}

.featured-excerpt {
    font-size: 1.15rem;
    color: #475569;
    line-height: 1.7;
    margin: 0;
}

.read-more-link {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-weight: 700;
    color: white;
    background: #0F172A;
    padding: 14px 28px;
    border-radius: 100px;
    text-decoration: none;
    font-size: 1rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(15, 23, 42, 0.2);
}
.read-more-link:hover {
    background: #4F46E5;
    box-shadow: 0 8px 25px rgba(79, 70, 229, 0.3);
    transform: translateY(-2px);
}
.arrow-icon {
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
.read-more-link:hover .arrow-icon, 
.card-hover-fx:hover .card-link .arrow-icon {
    transform: translateX(6px);
}

/* ━ Article Grid ━ */
.article-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 32px;
}

.post-card {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.post-img-wrapper {
    position: relative;
    height: 240px;
    background: #F8FAFC;
    overflow: hidden;
    display: block;
}
.grid-img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}
.card-hover-fx:hover .grid-img {
    transform: scale(1.08);
}
.post-img-placeholder {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    background: linear-gradient(135deg, #F1F5F9, #E2E8F0);
    color: #94A3B8;
    font-weight: 700;
    font-size: 1.2rem;
}

.post-content {
    padding: 32px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
    background: white;
}

.post-title {
    font-family: var(--serif, serif);
    font-size: 1.4rem;
    font-weight: 800;
    line-height: 1.35;
    margin-bottom: 12px;
    letter-spacing: -0.01em;
}
.post-title a {
    color: #0F172A;
    transition: color 0.3s;
}
.card-hover-fx:hover .post-title a {
    color: #4F46E5;
}

.post-excerpt {
    color: #64748B;
    line-height: 1.6;
    font-size: 1.05rem;
    margin-bottom: 24px;
}

/* Utilities */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;  
    overflow: hidden;
}
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;  
    overflow: hidden;
}

.card-link {
    font-weight: 700;
    color: #4F46E5;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.95rem;
}

/* ━ Pagination ━ */
.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 16px;
    border-top: 1px solid #E2E8F0;
    padding-top: 40px;
}
.page-numbers {
    display: flex;
    gap: 8px;
    background: white;
    padding: 8px;
    border-radius: 100px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    border: 1px solid #F1F5F9;
}
.page-btn {
    min-width: 44px;
    height: 44px;
    border-radius: 50%;
    border: none;
    background: transparent;
    font-weight: 600;
    color: #64748B;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 16px;
}
.page-btn:hover:not(:disabled) {
    background: #F1F5F9;
    color: #0F172A;
}
.page-btn.active {
    background: #0F172A;
    color: white;
    box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);
}
.prev-next {
    background: white;
    border: 1px solid #E2E8F0;
    border-radius: 100px;
    border: none;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    border: 1px solid #F1F5F9;
    gap: 8px;
    font-size: 0.95rem;
}
.prev-next:hover:not(:disabled) {
    border-color: #CBD5E1;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.06);
}
.page-dots {
    color: #94A3B8;
    font-weight: 700;
    display: flex;
    align-items: center;
    padding: 0 4px;
}

/* ━ States ━ */
.loading-state, .empty-state {
    text-align: center;
    padding: 100px 20px;
}
.spinner {
    width: 40px; height: 40px;
    border: 3px solid rgba(99, 102, 241, 0.2);
    border-top-color: #4F46E5;
    border-radius: 50%;
    margin: 0 auto 20px;
    animation: spin 1s linear infinite;
}
@keyframes spin { 100% { transform: rotate(360deg); } }
.loading-state p { color: #64748B; font-weight: 500; font-size: 1.1rem; }

.empty-icon {
    font-size: 4rem;
    margin-bottom: 24px;
    opacity: 0.5;
}
.empty-state h3 {
    font-size: 1.8rem;
    color: #0F172A;
    margin-bottom: 12px;
    font-weight: 800;
}
.empty-state p {
    color: #64748B;
    font-size: 1.1rem;
}
.btn-glow-small {
    background: #0F172A;
    color: white;
    padding: 10px 24px;
    border-radius: 100px;
    font-weight: 600;
    margin-top: 10px;
    box-shadow: 0 4px 15px rgba(15, 23, 42, 0.2);
    transition: all 0.3s;
}
.btn-glow-small:hover {
    background: #4F46E5;
    transform: translateY(-2px);
}

.page-btn:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

/* ━ Animations ━ */
.slide-up {
    opacity: 0;
    transform: translateY(40px);
    animation: slideUpAnim 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
@keyframes slideUpAnim {
    to { opacity: 1; transform: translateY(0); }
}
.stagger-1 { animation-delay: 0.1s; }
.stagger-2 { animation-delay: 0.2s; }
.stagger-3 { animation-delay: 0.3s; }
.stagger-4 { animation-delay: 0.4s; }

/* ━ Responsive ━ */
@media (max-width: 1024px) {
    .featured-post {
        grid-template-columns: 1fr;
        height: auto;
    }
    .featured-img-wrapper {
        min-height: 400px;
    }
    .featured-content {
        padding: 48px;
    }
    .article-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .blog-magazine-page {
        padding: 120px 0 60px;
    }
    .magz-title {
        font-size: 2.8rem;
    }
    .magz-subtitle {
        font-size: 1.1rem;
    }
    .featured-img-wrapper {
        min-height: 300px;
    }
    .featured-content {
        padding: 40px 32px;
    }
    .featured-title {
        font-size: 1.8rem;
    }
    .article-grid {
        grid-template-columns: 1fr;
        gap: 24px;
    }
    .prev-next {
        font-size: 0;
        padding: 0 12px;
    }
}
</style>
