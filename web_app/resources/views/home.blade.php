<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- SEO Meta Tags -->
    @if(isset($post))
        <title>{{ $post->title }} — Jetschool Blog</title>
        <meta name="description" content="{{ $post->excerpt }}">
        <link rel="canonical" href="{{ url()->current() }}">

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="article">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="{{ $post->title }} — Jetschool Blog">
        <meta property="og:description" content="{{ $post->excerpt }}">
        <meta property="og:image"
            content="{{ $post->image ? (str_starts_with($post->image, 'http') ? $post->image : url($post->image)) : url('/images/jetschool_og.webp') }}">

        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ url()->current() }}">
        <meta property="twitter:title" content="{{ $post->title }} — Jetschool Blog">
        <meta property="twitter:description" content="{{ $post->excerpt }}">
        <meta property="twitter:image"
            content="{{ $post->image ? (str_starts_with($post->image, 'http') ? $post->image : url($post->image)) : url('/images/jetschool_og.webp') }}">
    @else
        <title>Jetschool — Sistem Operasi Digital Yayasan & Sekolah</title>
        <meta name="description"
            content="Platform pendidikan terpadu untuk yayasan dan sekolah di seluruh Indonesia. Mengelola akademik, keuangan, dan operasional dalam satu ekosistem.">
        <link rel="canonical" href="https://jetschool.id">

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="https://jetschool.id/">
        <meta property="og:title" content="Jetschool — Sistem Operasi Digital Yayasan & Sekolah">
        <meta property="og:description"
            content="Platform pendidikan terpadu untuk yayasan dan sekolah di seluruh Indonesia. Mengelola akademik, keuangan, dan operasional dalam satu ekosistem.">
        <meta property="og:image" content="{{ url('/images/jetschool_og.webp') }}">

        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="https://jetschool.id/">
        <meta property="twitter:title" content="Jetschool — Sistem Operasi Digital Yayasan & Sekolah">
        <meta property="twitter:description"
            content="Platform pendidikan terpadu untuk yayasan dan sekolah di seluruh Indonesia. Mengelola akademik, keuangan, dan operasional dalam satu ekosistem.">
        <meta property="twitter:image" content="{{ url('/images/jetschool_og.webp') }}">
    @endif

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- JSON-LD Structured Data -->
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "Organization",
        "name": "Jetschool",
        "url": "https://jetschool.id",
        "logo": "https://jetschool.id/images/jetschool_logo.png",
        "description": "Platform pendidikan terpadu untuk yayasan dan sekolah di seluruh Indonesia. Mengelola akademik, keuangan, dan operasional dalam satu ekosistem.",
        "contactPoint": {
            "@@type": "ContactPoint",
            "telephone": "+62-877-8626-4789",
            "contactType": "sales",
            "availableLanguage": "Indonesian"
        },
        "sameAs": [
            "https://www.instagram.com/jetschool.id/",
            "https://www.youtube.com/@jetschool"
        ]
    }
    </script>
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "WebSite",
        "name": "Jetschool",
        "url": "https://jetschool.id",
        "potentialAction": {
            "@@type": "SearchAction",
            "target": "https://jetschool.id/?s={search_term_string}",
            "query-input": "required name=search_term_string"
        }
    }
    </script>
    @if(isset($post) && $post)
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "BlogPosting",
        "headline": "{{ $post->title }}",
        "description": "{{ $post->excerpt }}",
        "image": "{{ $post->image ? (str_starts_with($post->image, 'http') ? $post->image : url($post->image)) : url('/images/jetschool_og.webp') }}",
        "datePublished": "{{ $post->published_at }}",
        "author": {
            "@@type": "Organization",
            "name": "Jetschool"
        },
        "publisher": {
            "@@type": "Organization",
            "name": "Jetschool",
            "logo": {
                "@@type": "ImageObject",
                "url": "https://jetschool.id/images/jetschool_logo.png"
            }
        }
    }
    </script>
    @endif
</head>

<body class="bg-slate-950">
    <div id="app"></div>
</body>

</html>