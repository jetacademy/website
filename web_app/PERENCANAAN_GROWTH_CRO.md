# 📋 PERENCANAAN PENGEMBANGAN KOMPREHENSIF
## Jetschool.id — Growth Hacking & Conversion Rate Optimization

**Tanggal:** 20 Juni 2026  
**Status:** Draft Perencanaan  
**Platform:** Laravel + Vue.js (SPA) + Vite  
**Target Market:** Sekolah & Yayasan Pendidikan di Indonesia  

---

## 📌 EXECUTIVE SUMMARY

Jetschool.id saat ini memiliki fondasi teknis yang solid dengan arsitektur modern (Laravel + Vue.js SPA), sistem affiliate, lead capture, blog, dan admin dashboard. Namun, terdapat **peluang besar yang belum tergarap** untuk meningkatkan konversi dari visitor menjadi pelanggan berbayar.

### Temuan Utama dari Audit:
| Aspek | Status Saat Ini | Potensi Improvement |
|-------|----------------|-------------------|
| Conversion Funnel | Linear (Hero → Demo Modal → WA) | Bisa diperkaya dengan multi-touch |
| Social Proof | Marquee trust bar (teks only) | Testimonial video, case study, logo wall |
| Lead Nurturing | Tidak ada (one-shot form) | Email sequence, retargeting |
| Analytics | Admin stats dasar | Event tracking, funnel analysis |
| SEO | Blog aktif, SSR via Blade | Schema markup, internal linking |
| Pricing Strategy | Single plan (Rp 5.000/siswa/bln) | Tiered pricing, trial, freemium |
| A/B Testing | Tidak ada | Infrastructure + experimentation |
| Exit Intent | Tidak ada | Popup, countdown, urgency |

### Target Bisnis 6 Bulan:
- **Lead generation:** +300% (dari baseline saat ini)
- **Conversion rate (lead → customer):** dari ~5% ke 15%+
- **Organic traffic:** +200% melalui SEO optimization
- **Affiliate revenue contribution:** 30% dari total akuisisi
- **Customer acquisition cost (CAC):** -40%

---

## 🗺️ 1. CONVERSION FUNNEL ANALYSIS

### 1.1 User Journey Map (Current State)

```
┌─────────────────────────────────────────────────────────────────────┐
│                    CURRENT FUNNEL (AS-IS)                           │
├─────────────────────────────────────────────────────────────────────┤
│                                                                     │
│  VISITOR ──→ HOMEPAGE ──→ DEMO MODAL ──→ WHATSAPP ──→ SALES CALL │
│     │            │              │              │            │       │
│     │            │              │              │            │       │
│  [Traffic]   [Bounce?]     [Form Fill]    [Manual]     [Close?]   │
│  Sources     ~85%          3 fields       Follow-up    ~20%       │
│                                                                     │
│  ALTERNATIVE PATH:                                                  │
│  VISITOR ──→ BLOG ──→ (No clear CTA) ──→ EXIT                    │
│  VISITOR ──→ /?ref=CODE ──→ HOMEPAGE ──→ DEMO MODAL              │
│                                                                     │
└─────────────────────────────────────────────────────────────────────┘
```

### 1.2 User Journey Map (Target State)

```
┌─────────────────────────────────────────────────────────────────────┐
│                    TARGET FUNNEL (TO-BE)                            │
├─────────────────────────────────────────────────────────────────────┤
│                                                                     │
│  STAGE 1: AWARENESS                                                 │
│  ├── Organic Search (SEO Blog + Landing Pages)                     │
│  ├── Social Media (IG, TikTok, FB Ads)                             │
│  ├── Affiliate Referrals (Mitra Jetschool)                         │
│  ├── Paid Ads (Google Ads, Meta Ads)                               │
│  └── Events/Webinars/Edukasi                                       │
│         │                                                           │
│         ▼                                                           │
│  STAGE 2: INTEREST                                                  │
│  ├── Homepage (Value Prop + Social Proof)                          │
│  ├── Solution Pages (by school type)                               │
│  ├── Blog Content (Educational + SEO)                              │
│  ├── Comparison Pages (vs competitors)                             │
│  └── Case Studies / Success Stories                                │
│         │                                                           │
│         ▼                                                           │
│  STAGE 3: CONSIDERATION                                             │
│  ├── Free Trial / Sandbox Demo                                     │
│  ├── Interactive Product Tour                                      │
│  ├── ROI Calculator                                                │
│  ├── Pricing Page (Tiered)                                         │
│  ├── Exit Intent Offer                                             │
│  └── Chat/Chatbot Engagement                                       │
│         │                                                           │
│         ▼                                                           │
│  STAGE 4: CONVERSION                                                │
│  ├── Demo Scheduling (Calendar Integration)                        │
│  ├── Self-Service Signup (Free Tier)                               │
│  ├── WhatsApp Consultation                                         │
│  └── Sales Call                                                    │
│         │                                                           │
│         ▼                                                           │
│  STAGE 5: RETENTION & EXPANSION                                    │
│  ├── Onboarding Email Sequence                                     │
│  ├── Feature Adoption Tracking                                     │
│  ├── Upsell/Cross-sell Triggers                                    │
│  └── Referral Program (Customer → Affiliate)                       │
│                                                                     │
└─────────────────────────────────────────────────────────────────────┘
```

### 1.3 Bottleneck Analysis

| Bottleneck | Impact | Root Cause |
|-----------|--------|-----------|
| **Blog → Exit (no CTA)** | HIGH | Artikel blog tidak memiliki CTA yang jelas |
| **Single pricing tier** | MEDIUM | Tidak ada entry point rendah untuk sekolah kecil |
| **No self-service trial** | HIGH | Sekolah harus melalui sales call dulu |
| **No email nurturing** | HIGH | Lead yang belum ready-to-buy tidak di-follow-up |
| **No exit intent** | MEDIUM | Visitor yang mau pergi tidak di-reengage |
| **No live chat** | MEDIUM | Pertanyaan real-time tidak terjawab |
| **No retargeting** | HIGH | Visitor yang sudah pernah datang tidak di-remarket |
| **Mobile conversion** | MEDIUM | Form demo kurang optimal di mobile |

---

## ⚡ 2. QUICK WINS (1-2 MINGGU) — HIGH IMPACT, LOW EFFORT

### 2.1 Tambahkan CTA di Setiap Blog Post
**Impact: ⭐⭐⭐⭐⭐ | Effort: ⭐ (2-3 jam)**

```
File: resources/js/views/BlogDetail.vue
```
- Tambahkan inline CTA banner di tengah dan akhir setiap artikel
- CTA: "Mau coba fitur ini di sekolah Anda? Jadwalkan demo gratis →"
- Link ke DemoModal atau WhatsApp langsung
- Expected lift: +15-25% blog-to-lead conversion

### 2.2 Sticky Bottom CTA Bar (Mobile)
**Impact: ⭐⭐⭐⭐⭐ | Effort: ⭐ (2 jam)**

```
File: resources/js/components/StickyCTA.vue (NEW)
```
- Floating bottom bar di mobile: "Jadwalkan Demo Gratis" button
- Muncul setelah scroll 30% halaman
- Selalu accessible tanpa harus scroll ke atas
- Expected lift: +20-30% mobile demo requests

### 2.3 Exit Intent Popup
**Impact: ⭐⭐⭐⭐ | Effort: ⭐⭐ (4-6 jam)**

```
File: resources/js/components/ExitIntentPopup.vue (NEW)
```
- Deteksi mouse leave (desktop) / back button (mobile)
- Offer: "Tunggu! Dapatkan ebook gratis: Panduan Digitalisasi Sekolah 2026"
- Capture email sebagai micro-commitment
- Expected lift: +5-10% lead recovery dari exiting visitors

### 2.4 Tambah Social Proof Section di Homepage
**Impact: ⭐⭐⭐⭐⭐ | Effort: ⭐⭐ (4-6 jam)**

```
File: resources/js/components/home/HomeTestimonials.vue (NEW)
```
- Logo wall sekolah yang sudah menggunakan (jika ada)
- 3 testimonial quotes dari kepala sekolah/yayasan
- Video testimonial singkat (jika tersedia)
- Statistik: "X sekolah, Y siswa, Z transaksi/bulan"
- Expected lift: +10-20% trust & conversion

### 2.5 Optimize Demo Modal Form
**Impact: ⭐⭐⭐⭐ | Effort: ⭐ (2 jam)**

```
File: resources/js/components/DemoModal.vue
```
- Tambah field "Jumlah Siswa" (qualify lead)
- Tambah dropdown "Peran Anda" (Kepsek, Yayasan, Admin, Guru)
- Tambah microcopy: "Demo gratis 14 hari, tanpa kartu kredit"
- Progress indicator: "Langkah 1 dari 2"
- Expected lift: +10% form completion + better lead qualification

### 2.6 WhatsApp Floating Button
**Impact: ⭐⭐⭐⭐ | Effort: ⭐ (1 jam)**

```
File: resources/js/components/WhatsAppFloat.vue (NEW)
```
- Floating WhatsApp button di kanan bawah
- Pre-filled message dengan context halaman
- Badge "Online" untuk urgency
- Expected lift: +15% direct inquiries

### 2.7 Tambah Urgency & Scarcity Elements
**Impact: ⭐⭐⭐ | Effort: ⭐ (2 jam)**

- Di pricing section: "Promo berlaku hingga [date]"
- Countdown timer untuk promo setup gratis
- "X sekolah mendaftar minggu ini" (dynamic counter)
- Expected lift: +5-10% conversion urgency

---

## 📈 3. MEDIUM-TERM OPTIMIZATION (1-3 BULAN)

### 3.1 Landing Pages per Segmen Sekolah
**Impact: ⭐⭐⭐⭐⭐ | Effort: ⭐⭐⭐ (2-3 minggu)**

```
Routes baru:
/solutions/sekolah-islam     → Landing page khusus madrasah/pesantren
/solutions/sekolah-nasional  → Landing page sekolah nasional
/solutions/yayasan           → Landing page untuk yayasan multi-unit
/solutions/sekolah-kecil     → Landing page sekolah <200 siswa
```

- Setiap landing page dengan messaging, pain points, dan CTA yang spesifik
- A/B test headline dan CTA per segmen
- SEO optimized untuk long-tail keywords
- Expected lift: +30-50% conversion rate vs generic homepage

### 3.2 Free Trial / Sandbox Environment
**Impact: ⭐⭐⭐⭐⭐ | Effort: ⭐⭐⭐⭐ (3-4 minggu)**

```
Route: /try-free atau /sandbox
```
- Self-service signup untuk trial 14 hari
- Pre-populated data dummy (siswa, kelas, nilai)
- Guided tour / onboarding checklist
- In-app upgrade prompt setelah trial
- Expected lift: +40-60% signups (lower barrier)

### 3.3 Email Nurture Sequence
**Impact: ⭐⭐⭐⭐⭐ | Effort: ⭐⭐⭐ (2-3 minggu)**

```
Infrastructure:
- Integration dengan email service (SendGrid/Mailgun/SES)
- Email templates & sequences
- Lead scoring system
```

**Sequence untuk lead baru:**
1. **Hari 0:** Thank you + konfirmasi demo + ebook gratis
2. **Hari 1:** Case study: "Bagaimana SMA X menghemat 20 jam/minggu"
3. **Hari 3:** Feature highlight: AI Grading + Deep Learning Module
4. **Hari 5:** Social proof: Testimonial video kepala sekolah
5. **Hari 7:** Urgency: Promo berakhir + reminder demo
6. **Hari 14:** Breakup email: "Masih tertarik?" + final offer

**Sequence untuk blog subscriber:**
1. Weekly educational content
2. Monthly product update
3. Quarterly webinar invitation

### 3.4 ROI Calculator
**Impact: ⭐⭐⭐⭐ | Effort: ⭐⭐⭐ (1-2 minggu)**

```
Route: /roi-calculator
Component: resources/js/components/ROICalculator.vue (NEW)
```
- Input: Jumlah siswa, jumlah guru, biaya admin saat ini
- Output: Estimasi penghematan waktu & biaya dengan Jetschool
- CTA: "Lihat simulasi lengkap → Jadwalkan Demo"
- Lead magnet: Download hasil kalkulasi via email
- Expected lift: +25% engagement dari decision makers

### 3.5 Interactive Product Tour
**Impact: ⭐⭐⭐⭐ | Effort: ⭐⭐⭐ (2 minggu)**

```
Component: resources/js/components/ProductTour.vue (NEW)
```
- Screenshot/walkthrough interaktif dari dashboard
- Highlight fitur utama dengan annotation
- "Before vs After" slider per fitur
- No login required — bisa diakses publik
- Expected lift: +20% time-on-site + engagement

### 3.6 Chatbot / Live Chat Integration
**Impact: ⭐⭐⭐⭐ | Effort: ⭐⭐ (1 minggu)**

- Integrasi Tawk.to / Crisp / Intercom (free tier available)
- Auto-trigger berdasarkan behavior (time on page, scroll depth)
- FAQ bot untuk pertanyaan umum (harga, fitur, demo)
- Handoff ke human agent untuk complex queries
- Expected lift: +15% engagement, +10% conversion

### 3.7 Retargeting & Remarketing Setup
**Impact: ⭐⭐⭐⭐⭐ | Effort: ⭐⭐ (1 minggu)**

```
Infrastructure:
- Meta Pixel / Facebook Ads tracking
- Google Ads conversion tracking
- Custom audience segmentation
```

**Audience segments:**
- Visited homepage but no demo request → Awareness ads
- Visited pricing but no conversion → Consideration ads
- Blog visitors → Content marketing ads
- Demo requested but no close → Retargeting ads

### 3.8 Affiliate Program Enhancement
**Impact: ⭐⭐⭐⭐ | Effort: ⭐⭐⭐ (2-3 minggu)**

```
Enhancements:
- Affiliate registration page (self-service signup)
- Marketing kit download (banners, copy, social posts)
- Tiered commission structure (silver/gold/platinum)
- Leaderboard & gamification
- Monthly payout automation
- Referral link shortener & QR code
```

### 3.9 Comparison Pages (vs Competitors)
**Impact: ⭐⭐⭐⭐ | Effort: ⭐⭐ (1 minggu)**

```
Routes:
/compare/jetschool-vs-siap    → Comparison page
/compare/jetschool-vs-schoolapp → Comparison page
/compare/why-jetschool         → General comparison
```

- Feature-by-feature comparison table
- Unbiased tone (acknowledge competitor strengths)
- Highlight unique differentiators (AI, whitelabel, all-in-one)
- CTA: "Buktikan sendiri → Free Trial"

---

## 🚀 4. LONG-TERM STRATEGIC INITIATIVES (3-6 BULAN)

### 4.1 Product-Led Growth (PLG) Engine
**Impact: ⭐⭐⭐⭐⭐ | Effort: ⭐⭐⭐⭐⭐ (2-3 bulan)**

```
Components:
- Freemium tier (basic features, limited students)
- Self-service onboarding flow
- In-app upgrade triggers
- Usage-based pricing model
- Community/forum untuk user support
```

**Freemium Model:**
| Tier | Price | Features | Target |
|------|-------|----------|--------|
| Free | Rp 0 | 50 siswa, basic features | Sekolah kecil/pilot |
| Starter | Rp 3.000/siswa/bln | 200 siswa, core modules | Sekolah menengah |
| Professional | Rp 5.000/siswa/bln | Unlimited, all features | Sekolah besar |
| Enterprise | Custom | Whitelabel, API, SLA | Yayasan multi-unit |

### 4.2 Marketplace & Ecosystem
**Impact: ⭐⭐⭐⭐ | Effort: ⭐⭐⭐⭐⭐ (3-4 bulan)**

- Template marketplace (modul ajar, soal, RPP)
- Integration marketplace (API connectors)
- Consultant directory (implementasi partner)
- Revenue share model untuk contributors

### 4.3 AI-Powered Personalization
**Impact: ⭐⭐⭐⭐ | Effort: ⭐⭐⭐⭐ (2-3 bulan)**

- Personalized homepage based on visitor segment
- Dynamic content recommendation
- AI chatbot yang bisa demo fitur secara interaktif
- Predictive lead scoring
- Automated follow-up based on behavior

### 4.4 Webinar & Event Platform
**Impact: ⭐⭐⭐⭐ | Effort: ⭐⭐⭐ (2 bulan)**

```
Route: /webinars
```
- Monthly webinar: "Digitalisasi Sekolah" series
- Registration + reminder email sequence
- Recording library (gated content → lead gen)
- Live Q&A → direct engagement dengan prospects
- Partnership dengan dinas pendidikan / MGMP

### 4.5 Partnership & Channel Strategy
**Impact: ⭐⭐⭐⭐⭐ | Effort: ⭐⭐⭐⭐ (Ongoing)**

- Partnership dengan penerbit buku (bundling)
- Reseller program untuk konsultan pendidikan
- Integration dengan platform e-learning populer
- Government/NGO partnerships (program digitalisasi)
- University partnership (research & case studies)

### 4.6 Mobile-First PWA
**Impact: ⭐⭐⭐ | Effort: ⭐⭐⭐⭐ (2 bulan)**

- Progressive Web App untuk website
- Offline capability untuk area connectivity rendah
- Push notifications untuk engagement
- Install prompt untuk repeat visits
- Faster load times (critical untuk Indonesia)

---

## 🔧 5. TECHNICAL ROADMAP

### 5.1 Performance Optimization

| Priority | Task | Impact | Effort |
|----------|------|--------|--------|
| P0 | Image optimization (WebP + lazy loading) | Core Web Vitals | 2 hari |
| P0 | Code splitting per route (already lazy) | Initial load | 1 hari |
| P1 | CDN setup (Cloudflare/CloudFront) | Global speed | 1 hari |
| P1 | Server-side rendering untuk SEO pages | SEO + FCP | 1 minggu |
| P2 | Service Worker caching | Repeat visits | 3 hari |
| P2 | Database query optimization | API speed | 2 hari |

### 5.2 Analytics & Tracking Infrastructure

```
Stack yang direkomendasikan:
├── Google Analytics 4 (free, comprehensive)
├── Google Tag Manager (tag management)
├── Meta Pixel (Facebook/IG retargeting)
├── Hotjar / Microsoft Clarity (behavioral analytics, free tier)
├── Mixpanel / Amplitude (product analytics, free tier)
└── Custom event tracking via Vue composables
```

**Custom tracking composable:**
```javascript
// resources/js/composables/useAnalytics.js
export function useAnalytics() {
  const track = (event, properties) => {
    // GA4
    gtag('event', event, properties);
    // Meta Pixel
    fbq('trackCustom', event, properties);
    // Internal API
    axios.post('/api/analytics/events', { event, properties });
  };
  
  return { track };
}
```

### 5.3 SEO Infrastructure

| Task | Description | Priority |
|------|-------------|----------|
| Meta tags per page | Dynamic title, description, OG tags | P0 |
| Schema.org markup | Organization, Product, Article, FAQ | P0 |
| XML Sitemap | Auto-generated, submitted to GSC | P0 |
| Canonical URLs | Prevent duplicate content | P0 |
| Internal linking | Blog → Landing → Pricing → Demo | P1 |
| Page speed | Core Web Vitals optimization | P1 |
| Hreflang tags | Multi-language SEO (id, en, zh) | P2 |
| Structured data | Breadcrumbs, HowTo, Review | P2 |

### 5.4 A/B Testing Infrastructure

```
Recommended Stack:
- Option A: Google Optimize (free, sunset → use alternatives)
- Option B: PostHog (self-hosted, free, full-featured)
- Option C: Custom implementation (Vue feature flags)
```

**Custom Feature Flag System:**
```javascript
// resources/js/composables/useFeatureFlags.js
export function useFeatureFlags() {
  const flags = ref({});
  
  const init = async () => {
    const res = await axios.get('/api/feature-flags');
    flags.value = res.data.flags;
  };
  
  const isEnabled = (flag) => flags.value[flag] || false;
  
  return { init, isEnabled, flags };
}
```

### 5.5 Scalability Considerations

| Component | Current | Target | Action |
|-----------|---------|--------|--------|
| Web Server | Single | Load balanced | Nginx + horizontal scaling |
| Database | MySQL single | Read replicas | Separate read/write |
| Cache | None | Redis | Session + query cache |
| Queue | Sync | Redis/Horizon | Email, notifications |
| Storage | Local | S3-compatible | Media, uploads |
| CDN | None | Cloudflare | Static assets, images |

---

## 📝 6. CONTENT STRATEGY

### 6.1 Blog Content Calendar

| Kategori | Frekuensi | Tujuan | Contoh Topik |
|----------|-----------|--------|-------------|
| **Educational** | 2x/minggu | SEO + Authority | "Cara Membuat Modul Ajar Kurikulum Merdeka" |
| **Product** | 1x/minggu | Conversion | "Fitur AI Grading: Koreksi 1000 Soal dalam 5 Menit" |
| **Case Study** | 2x/bulan | Trust | "SMA X Hemat 20 Jam/Minggu dengan Jetschool" |
| **Industry** | 2x/bulan | Thought Leadership | "Tren EdTech 2026: Apa yang Harus Sekolah Siapkan" |
| **How-To** | 1x/minggu | Engagement | "Tutorial: Setup Payment Gateway di Jetschool" |

### 6.2 SEO Keyword Strategy

**Primary Keywords (High Intent):**
- "sistem manajemen sekolah"
- "aplikasi sekolah online"
- "software manajemen sekolah"
- "SPP online payment school"
- "CBT ujian online sekolah"

**Long-tail Keywords (Content):**
- "cara membuat e-rapor kurikulum merdeka"
- "sistem penilaian otomatis untuk guru"
- "aplikasi manajemen yayasan pendidikan"
- "payment gateway SPP sekolah"
- "modul ajar deep learning AI"

**Local/Intent Keywords:**
- "aplikasi sekolah terbaik di Indonesia"
- "software sekolah harga terjangkau"
- "digitalisasi sekolah 2026"

### 6.3 Lead Magnet Ideas

| Lead Magnet | Format | Target | Distribution |
|-------------|--------|--------|-------------|
| Panduan Digitalisasi Sekolah 2026 | PDF Ebook | Kepsek, Yayasan | Blog, Exit intent |
| Template Modul Ajar Kurikulum Merdeka | Downloadable | Guru | Blog, Social |
| ROI Calculator Sekolah | Interactive | Yayasan, Kepsek | Landing page |
| Checklist Kesiapan Akreditasi | PDF | Admin Sekolah | Blog, Email |
| Webinar Recording Library | Video | All segments | Gated content |
| Comparison Guide (Excel) | Spreadsheet | Decision maker | Pricing page |

### 6.4 Thought Leadership

- **Guest posting** di portal pendidikan (Kompas Pendidikan, Detik Edu)
- **Podcast interview** dengan founder di podcast EdTech Indonesia
- **Conference speaking** di event pendidikan (ANV, ATPSI, APSI)
- **Research report** tahunan: "State of School Digitalization in Indonesia"
- **Community building** di Telegram/WhatsApp group untuk kepala sekolah

---

## 📊 7. ANALYTICS & TRACKING PLAN

### 7.1 Key Metrics Dashboard

```
┌─────────────────────────────────────────────────────────────┐
│                    METRICS HIERARCHY                         │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  NORTH STAR METRIC:                                         │
│  └── Monthly Recurring Revenue (MRR)                       │
│                                                             │
│  PRIMARY METRICS:                                           │
│  ├── Total Leads Generated (monthly)                       │
│  ├── Lead → Customer Conversion Rate                       │
│  ├── Customer Acquisition Cost (CAC)                       │
│  └── Monthly Active Schools                                │
│                                                             │
│  SECONDARY METRICS:                                         │
│  ├── Website Traffic (organic, paid, referral)             │
│  ├── Demo Requests per Day                                 │
│  ├── Blog → Lead Conversion Rate                           │
│  ├── Affiliate-Sourced Revenue %                           │
│  ├── Average Deal Size                                     │
│  └── Sales Cycle Length (days)                             │
│                                                             │
│  TERTIARY METRICS:                                          │
│  ├── Page Load Time (Core Web Vitals)                      │
│  ├── Time on Site                                          │
│  ├── Bounce Rate per Page                                  │
│  ├── Exit Intent Capture Rate                              │
│  ├── Email Open/Click Rates                                │
│  └── NPS / Customer Satisfaction                           │
│                                                             │
└─────────────────────────────────────────────────────────────┘
```

### 7.2 Events to Track

| Event | Category | Trigger Point |
|-------|----------|--------------|
| `page_view` | Navigation | Every route change |
| `cta_click` | Conversion | Every CTA button click |
| `demo_modal_open` | Conversion | DemoModal opened |
| `demo_form_submit` | Conversion | Lead form submitted |
| `whatsapp_redirect` | Conversion | WA link clicked |
| `blog_read` | Content | Blog post viewed |
| `pricing_view` | Conversion | Pricing page viewed |
| `exit_intent_show` | Recovery | Exit popup triggered |
| `exit_intent_convert` | Recovery | Exit popup CTA clicked |
| `affiliate_click` | Affiliate | Referral link clicked |
| `affiliate_signup` | Affiliate | New affiliate registered |
| `calculator_use` | Engagement | ROI calculator used |
| `chat_open` | Engagement | Live chat opened |
| `chat_message` | Engagement | Chat message sent |
| `trial_signup` | Conversion | Free trial started |
| `trial_activate` | Engagement | First meaningful action in trial |

### 7.3 Funnel Metrics

```
Funnel Stage        | Metric                    | Target
--------------------|---------------------------|--------
Awareness           | Monthly unique visitors   | 50,000+
Interest            | Pages per session         | 3+
Consideration       | Demo modal opens/visit    | 5%+
Intent              | Form submissions          | 2%+ of visitors
Conversion          | Lead → Customer           | 15%+
Revenue             | ARPU (Average Rev/User)   | Growing
Retention           | Monthly churn rate        | <3%
Advocacy            | NPS Score                 | 50+
```

### 7.4 Reporting Cadence

| Report | Frequency | Audience | Content |
|--------|-----------|----------|---------|
| Daily Dashboard | Daily | Sales team | New leads, follow-ups needed |
| Weekly Metrics | Weekly | Management | KPI trends, conversion rates |
| Monthly Report | Monthly | Stakeholders | Full funnel analysis, ROI |
| Quarterly Review | Quarterly | Board | Strategy, growth rate, forecasts |

---

## 🧪 8. A/B TESTING PLAN

### 8.1 Testing Framework

```
Hypothesis → Design → Implement → Run → Analyze → Iterate

Tools: PostHog (self-hosted) atau Google Optimize alternative
Duration: Minimum 2 weeks per test (statistical significance)
Sample size: Minimum 1000 visitors per variant
```

### 8.2 Prioritized Test Backlog

| # | Hypothesis | Variant A | Variant B | Metric | Priority |
|---|-----------|-----------|-----------|--------|----------|
| 1 | Hero headline affects conversion | "Sistem Operasi Digital untuk Sekolah Masa Depan" | "Hemat 20 Jam/Minggu. Kelola Sekolah dalam 1 Platform." | Demo requests | P0 |
| 2 | CTA button text affects clicks | "Jadwalkan Demo →" | "Coba Gratis 14 Hari →" | CTA click rate | P0 |
| 3 | Pricing display affects perception | Single price (Rp 5.000) | Tiered pricing (Free/Starter/Pro) | Conversion rate | P0 |
| 4 | Social proof placement | No testimonials | Testimonials after features | Time on page, conversion | P1 |
| 5 | Form length affects completion | 3 fields (current) | 5 fields (qualified) | Form completion rate | P1 |
| 6 | Exit intent offer type | No exit popup | Ebook offer popup | Lead recovery rate | P1 |
| 7 | Landing page segment | Generic homepage | Segment-specific landing | Conversion rate | P1 |
| 8 | WhatsApp vs Demo form | WA redirect only | Demo form + WA option | Lead quality | P2 |
| 9 | Video vs Static hero | Static dashboard image | 30-sec product video | Engagement rate | P2 |
| 10 | Color scheme CTA | Indigo/Purple gradient | Green/Teal gradient | CTA click rate | P2 |

### 8.3 Testing Calendar (First Quarter)

```
Minggu 1-2:  Setup analytics infrastructure + tracking
Minggu 3-4:  Test #1 (Hero headline)
Minggu 5-6:  Test #2 (CTA button text) — winner vs new variant
Minggu 7-8:  Test #3 (Pricing display)
Minggu 9-10: Test #4 (Social proof placement)
Minggu 11-12: Test #5 (Form length) + analyze Q1 results
```

---

## 📅 9. PRIORITIZED ROADMAP

### Phase 1: Foundation (Minggu 1-2)
| Task | Impact | Effort | Owner |
|------|--------|--------|-------|
| Blog CTA integration | ⭐⭐⭐⭐⭐ | 2 jam | Dev |
| Sticky mobile CTA bar | ⭐⭐⭐⭐⭐ | 2 jam | Dev |
| WhatsApp floating button | ⭐⭐⭐⭐ | 1 jam | Dev |
| GA4 + GTM setup | ⭐⭐⭐⭐⭐ | 4 jam | Dev |
| Meta Pixel installation | ⭐⭐⭐⭐ | 2 jam | Dev |
| Exit intent popup | ⭐⭐⭐⭐ | 4 jam | Dev |
| Social proof section | ⭐⭐⭐⭐⭐ | 4 jam | Dev + Content |
| SEO meta tags + schema | ⭐⭐⭐⭐ | 4 jam | Dev |

**Expected Result:** +30-50% lead generation improvement

### Phase 2: Optimization (Minggu 3-6)
| Task | Impact | Effort | Owner |
|------|--------|--------|-------|
| Landing pages per segment | ⭐⭐⭐⭐⭐ | 2 minggu | Dev + Content |
| Email nurture setup | ⭐⭐⭐⭐⭐ | 1 minggu | Dev + Marketing |
| ROI Calculator | ⭐⭐⭐⭐ | 1 minggu | Dev |
| Live chat integration | ⭐⭐⭐⭐ | 3 hari | Dev |
| Retargeting campaigns | ⭐⭐⭐⭐⭐ | 1 minggu | Marketing |
| A/B testing framework | ⭐⭐⭐⭐ | 1 minggu | Dev |
| First A/B tests | ⭐⭐⭐⭐ | Ongoing | Dev + Marketing |
| Comparison pages | ⭐⭐⭐⭐ | 1 minggu | Dev + Content |

**Expected Result:** +100-150% conversion improvement

### Phase 3: Scale (Bulan 3-6)
| Task | Impact | Effort | Owner |
|------|--------|--------|-------|
| Free trial / sandbox | ⭐⭐⭐⭐⭐ | 1 bulan | Dev team |
| Affiliate program v2 | ⭐⭐⭐⭐ | 2 minggu | Dev + Marketing |
| Webinar platform | ⭐⭐⭐⭐ | 1 bulan | Dev + Marketing |
| Freemium tier launch | ⭐⭐⭐⭐⭐ | 2 bulan | Full team |
| AI personalization | ⭐⭐⭐⭐ | 1 bulan | Dev team |
| Partnership program | ⭐⭐⭐⭐⭐ | Ongoing | Business Dev |
| PWA implementation | ⭐⭐⭐ | 1 bulan | Dev team |

**Expected Result:** +300% total growth, sustainable acquisition engine

---

## 📊 10. KPIs & SUCCESS METRICS

### 10.1 North Star Metrics

| KPI | Current (Est.) | 3-Month Target | 6-Month Target |
|-----|----------------|----------------|----------------|
| Monthly Leads | ~20-50 | 150+ | 300+ |
| Lead → Customer Rate | ~5% | 10% | 15% |
| Monthly New Schools | ~2-5 | 15-20 | 30-45 |
| MRR Growth | Baseline | +50% | +200% |
| Organic Traffic | Baseline | +100% | +200% |

### 10.2 Channel-Specific KPIs

| Channel | KPI | Target (6 bulan) |
|---------|-----|------------------|
| **Organic/SEO** | Monthly organic visitors | 30,000+ |
| **Blog** | Blog → Lead rate | 3%+ |
| **Paid Ads** | ROAS (Return on Ad Spend) | 5x+ |
| **Affiliate** | % revenue from affiliates | 30%+ |
| **Email** | Open rate / Click rate | 40% / 8% |
| **WhatsApp** | Response rate | 60%+ |
| **Demo** | Show-up rate | 70%+ |
| **Trial** | Trial → Paid rate | 25%+ |

### 10.3 Financial KPIs

| KPI | Target |
|-----|--------|
| CAC (Customer Acquisition Cost) | < Rp 500.000 |
| LTV (Lifetime Value) | > Rp 5.000.000 |
| LTV:CAC Ratio | > 10:1 |
| Payback Period | < 3 bulan |
| Gross Margin | > 80% |

---

## 👥 11. RESOURCE REQUIREMENTS

### 11.1 Team Composition

| Role | FTE | Responsibilities |
|------|-----|-----------------|
| **Full-Stack Developer** | 1-2 | Feature development, integrations |
| **Content Marketer** | 1 | Blog, landing pages, email sequences |
| **Growth/Performance Marketer** | 1 | Ads, SEO, A/B testing, analytics |
| **Sales/SDR** | 1-2 | Lead follow-up, demo delivery, closing |
| **Designer (part-time)** | 0.5 | Landing pages, ad creatives, assets |

### 11.2 Tools & Services Budget (Monthly)

| Tool | Purpose | Cost (IDR) |
|------|---------|-----------|
| Google Analytics 4 | Web analytics | Free |
| Google Tag Manager | Tag management | Free |
| Hotjar / Clarity | Behavioral analytics | Free-500K |
| PostHog | Product analytics + A/B testing | Free (self-hosted) |
| SendGrid / Mailgun | Email delivery | 200K-500K |
| Tawk.to / Crisp | Live chat | Free-300K |
| Cloudflare | CDN + Security | Free-200K |
| Canva Pro | Design assets | 150K |
| Meta/Google Ads | Paid acquisition | 3-10 Juta |
| **Total** | | **~5-12 Juta/bulan** |

### 11.3 Infrastructure Costs

| Component | Current | After Optimization |
|-----------|---------|-------------------|
| Hosting/Server | Existing | +500K-1Jt (scaling) |
| CDN | None | Free-200K |
| Database | Existing | +300K (read replica) |
| Email Service | None | 200-500K |
| **Total Additional** | | **~1-2 Juta/bulan** |

---

## ⚠️ 12. RISK ASSESSMENT

### 12.1 Risk Matrix

| Risk | Probability | Impact | Mitigation |
|------|-------------|--------|-----------|
| **Low conversion despite optimization** | Medium | High | Continuous A/B testing, pivot messaging |
| **Technical debt slows development** | Medium | Medium | Prioritize quick wins first, refactor incrementally |
| **SEO changes hurt rankings** | Low | High | Test changes incrementally, monitor GSC |
| **Affiliate fraud/abuse** | Medium | Medium | Verification system, manual review |
| **Competitor launches similar features** | Medium | Medium | Focus on unique differentiators (AI, whitelabel) |
| **Team capacity constraints** | High | High | Phase approach, outsource non-core tasks |
| **Email deliverability issues** | Low | Medium | Use reputable ESP, warm up domain |
| **Free trial abuse** | Medium | Low | Usage limits, verification, manual review |
| **Data privacy compliance** | Low | High | Regular audit, PDP law compliance |
| **Market timing (economic downturn)** | Low | Medium | Flexible pricing, focus on cost-saving narrative |

### 12.2 Dependencies

| Dependency | Critical? | Alternative |
|-----------|-----------|------------|
| Sales team availability | YES | Automated demo videos |
| Content creation capacity | YES | AI-assisted content + freelance |
| Server scalability | MEDIUM | Cloud auto-scaling |
| Affiliate recruitment | MEDIUM | Paid acquisition as backup |
| School decision-maker access | HIGH | Multi-channel approach |

### 12.3 Contingency Plans

1. **If lead gen doesn't improve in 4 weeks:** Pivot messaging, test new segments, increase paid budget
2. **If conversion rate stays <5%:** Add free trial, reduce friction, simplify pricing
3. **If technical issues block features:** Use no-code tools (Typeform, Calendly) as interim
4. **If budget is constrained:** Focus on organic/SEO + affiliate (lowest CAC channels)

---

## 🎯 13. IMMEDIATE ACTION ITEMS (This Week)

### Hari 1-2: Analytics Setup
- [ ] Install Google Analytics 4 + GTM
- [ ] Setup Meta Pixel
- [ ] Install Microsoft Clarity (free behavioral analytics)
- [ ] Create custom events tracking plan

### Hari 3-4: Quick Win Implementation
- [ ] Add CTA to all existing blog posts
- [ ] Implement sticky mobile CTA bar
- [ ] Add WhatsApp floating button
- [ ] Add social proof section to homepage

### Hari 5-7: Optimization
- [ ] Implement exit intent popup
- [ ] Optimize demo modal (add qualifying fields)
- [ ] Add SEO meta tags to all pages
- [ ] Submit sitemap to Google Search Console

### Hari 7-14: Content & Testing
- [ ] Write 3 SEO-optimized blog posts (targeting primary keywords)
- [ ] Create comparison page (Jetschool vs manual/Excel)
- [ ] Setup first A/B test (hero headline)
- [ ] Draft email nurture sequence

---

## 📎 APPENDIX

### A. Technology Stack Summary
```
Frontend:  Vue.js 3 + Vue Router + Vue I18n + Vite
Backend:   Laravel 11 + PHP 8.x
Database:  MySQL
Auth:      Laravel Sanctum (SPA authentication)
Styling:   Custom CSS (scoped)
i18n:      Indonesian, English, Chinese
Deployment: TBD (recommend: Laravel Forge + DigitalOcean/AWS)
```

### B. Existing Features Inventory
```
✅ Homepage (Hero, Value Prop, Features, Modules, Pricing, Comparison, Whitelabel)
✅ Blog system (CRUD, reactions, SEO-friendly URLs)
✅ Affiliate system (registration, tracking, dashboard, commissions)
✅ Lead capture (demo modal, form, WhatsApp redirect)
✅ Admin dashboard (leads, blog, affiliates, users, stats)
✅ Multi-language support (ID, EN, ZH)
✅ Role-based access (admin, affiliate, user)
✅ Contact page, About, Solutions, Security, Privacy, Terms
✅ Responsive design (mobile-first)
```

### C. Competitive Landscape
```
Competitors:
- SIAP Online (established, basic features)
- SchoolApp (moderate features)
- E-School (niche player)
- Custom Excel/spreadsheet (status quo)

Jetschool Differentiators:
- AI-powered (grading, tutor, module generation)
- All-in-one (7+ modules integrated)
- Whitelabel mobile app
- Payment gateway integration
- Deep Learning approach (Kurikulum Merdeka)
- Affordable pricing (Rp 5.000/siswa/bulan)
- SOS Anti-Bullying system
```

### D. Glossary
```
CAC    = Customer Acquisition Cost
LTV    = Lifetime Value
MRR    = Monthly Recurring Revenue
PLG    = Product-Led Growth
ROAS   = Return on Ad Spend
NPS    = Net Promoter Score
ARPU   = Average Revenue Per User
SDR    = Sales Development Representative
GSC    = Google Search Console
PWA    = Progressive Web App
```

---

*Dokumen ini bersifat living document — akan di-update secara berkala berdasarkan hasil implementasi dan data real.*

**Next Review:** 2 minggu setelah implementasi Phase 1  
**Owner:** Product/Growth Team  
**Stakeholders:** Founder, Sales, Marketing, Engineering
