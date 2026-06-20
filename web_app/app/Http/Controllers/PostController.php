<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\RateLimiter;

class PostController extends Controller
{
    // Whitelist kolom reaksi yang diizinkan (mencegah SQL injection)
    private const ALLOWED_REACTION_COLUMNS = [
        'suka' => 'count_suka',
        'tertawa' => 'count_tertawa',
        'sedih' => 'count_sedih',
        'marah' => 'count_marah',
    ];

    // Field yang diizinkan untuk mass assignment
    private const ALLOWED_POST_FIELDS = ['title', 'content', 'category', 'status', 'excerpt', 'image'];

    // Publik: Dapatkan daftar artikel aktif
    public function index(Request $request)
    {
        $query = Post::where('status', 'published')
            ->orderBy('created_at', 'desc');

        // Filter by category (whitelist)
        if ($request->filled('category')) {
            $allowedCategories = ['Edukasi', 'Teknologi', 'Manajemen', 'Berita', 'Panduan'];
            if (in_array($request->category, $allowedCategories)) {
                $query->where('category', $request->category);
            }
        }

        $posts = $query->paginate(9);

        return response()->json($posts);
    }

    // Publik: Dapatkan rincian artikel berdasarkan slug
    public function show($slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return response()->json($post);
    }

    // Admin: Dapatkan semua artikel (termasuk draft) dengan pagination & filter
    public function indexAdmin(Request $request)
    {
        $query = Post::orderBy('created_at', 'desc');

        // Filter by status (whitelist)
        if ($request->filled('status')) {
            $allowedStatuses = ['draft', 'published'];
            if (in_array($request->status, $allowedStatuses)) {
                $query->where('status', $request->status);
            }
        }

        // Filter by category (whitelist)
        if ($request->filled('category')) {
            $allowedCategories = ['Edukasi', 'Teknologi', 'Manajemen', 'Berita', 'Panduan'];
            if (in_array($request->category, $allowedCategories)) {
                $query->where('category', $request->category);
            }
        }

        // Search by title (sanitize LIKE wildcards)
        if ($request->filled('search')) {
            $searchTerm = str_replace(['%', '_'], ['', ''], $request->search);
            $query->where('title', 'like', '%' . $searchTerm . '%');
        }

        $perPage = min((int) $request->input('per_page', 10), 100); // Cap at 100
        $posts = $query->paginate($perPage);

        return response()->json($posts);
    }

    // Admin: Dapatkan satu artikel untuk di-edit
    public function showAdmin($id)
    {
        $post = Post::findOrFail($id);
        return response()->json($post);
    }

    /**
     * Sanitize image URL - hanya izinkan URL http/https yang aman
     */
    private function sanitizeImageUrl($url)
    {
        if (empty($url)) return null;

        // Hanya izinkan URL http/https
        if (!preg_match('/^https?:\/\//i', $url)) {
            return null;
        }

        // Blokir data URI dan javascript: scheme
        if (preg_match('/^(javascript|data|vbscript):/i', $url)) {
            return null;
        }

        // Validasi URL
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return null;
        }

        return $url;
    }

    /**
     * Process image upload to WebP format
     */
    private function processImageUpload($file)
    {
        $filename = Str::random(20) . '.webp';

        // Buat direktori blog jika belum ada
        if (!Storage::disk('images')->exists('blog')) {
            Storage::disk('images')->makeDirectory('blog');
        }

        $imageData = null;

        try {
            $imagePath = $file->getRealPath();
            $info = getimagesize($imagePath);

            if (!$info || !isset($info['mime'])) {
                return $this->fallbackImageStore($file, $filename);
            }

            switch ($info['mime']) {
                case 'image/jpeg':
                    $imageData = @imagecreatefromjpeg($imagePath);
                    break;
                case 'image/png':
                    $imageData = @imagecreatefrompng($imagePath);
                    if ($imageData) {
                        imagepalettetotruecolor($imageData);
                        imagealphablending($imageData, true);
                        imagesavealpha($imageData, true);
                    }
                    break;
                case 'image/webp':
                    $imageData = @imagecreatefromwebp($imagePath);
                    break;
                default:
                    return $this->fallbackImageStore($file, $filename);
            }

            if ($imageData) {
                $targetPath = base_path('../public_html/images/blog/' . $filename);
                $dir = dirname($targetPath);
                if (!is_dir($dir)) {
                    mkdir($dir, 0755, true);
                }
                imagewebp($imageData, $targetPath, 80);
                imagedestroy($imageData);
                return '/images/blog/' . $filename;
            }
        } catch (\Exception $e) {
            // Log error dan fallback
            \Log::warning('Image processing failed: ' . $e->getMessage());
        }

        return $this->fallbackImageStore($file, $filename);
    }

    /**
     * Fallback: store image without GD processing
     */
    private function fallbackImageStore($file, $filename)
    {
        $path = $file->storeAs('blog', $filename, 'images');
        return Storage::disk('images')->url($path);
    }

    // Admin: Simpan artikel baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string',
            'status' => 'required|in:draft,published',
            'image_file' => 'nullable|image|max:2048',
            'image' => 'nullable|url|max:2048',
        ]);

        // Only allow specific fields (prevent mass assignment)
        $data = $request->only(self::ALLOWED_POST_FIELDS);

        // Generate slug from title
        $baseSlug = Str::slug($request->input('title'));
        $slug = $baseSlug;
        $counter = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        $data['slug'] = $slug;

        // Auto generate excerpt if not provided
        if (empty($data['excerpt'])) {
            $data['excerpt'] = Str::limit(strip_tags($request->input('content')), 150);
        }

        // Handle Image upload
        if ($request->hasFile('image_file')) {
            $data['image'] = $this->processImageUpload($request->file('image_file'));
        } else if ($request->filled('image')) {
            $data['image'] = $this->sanitizeImageUrl($request->image);
        }

        if ($data['status'] == 'published') {
            $data['published_at'] = now();
        }

        $post = Post::create($data);

        return response()->json(['message' => 'Post created successfully', 'post' => $post], 201);
    }

    // Admin: Perbarui artikel
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string',
            'status' => 'required|in:draft,published',
            'image_file' => 'nullable|image|max:2048',
            'image' => 'nullable|url|max:2048',
        ]);

        // Only allow specific fields (prevent mass assignment)
        $data = $request->only(self::ALLOWED_POST_FIELDS);

        if ($request->input('title') !== $post->title) {
            $baseSlug = Str::slug($request->input('title'));
            $slug = $baseSlug;
            $counter = 1;
            while (Post::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            $data['slug'] = $slug;
        }

        if (empty($data['excerpt'])) {
            $data['excerpt'] = Str::limit(strip_tags($request->input('content')), 150);
        }

        // Handle Image upload
        if ($request->hasFile('image_file')) {
            $data['image'] = $this->processImageUpload($request->file('image_file'));

            // Hapus gambar lama jika ada
            if ($post->image && str_starts_with($post->image, '/images/')) {
                $oldPath = str_replace('/images/', '', $post->image);
                Storage::disk('images')->delete($oldPath);
            }
        } else if ($request->filled('image')) {
            $data['image'] = $this->sanitizeImageUrl($request->image);
        }

        if ($data['status'] == 'published' && !$post->published_at) {
            $data['published_at'] = now();
        }

        $post->update($data);

        return response()->json(['message' => 'Post updated successfully', 'post' => $post]);
    }

    // Admin: Hapus artikel
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ($post->image && str_starts_with($post->image, '/images/')) {
            $oldPath = str_replace('/images/', '', $post->image);
            Storage::disk('images')->delete($oldPath);
        }

        $post->delete();
        return response()->json(['message' => 'Post deleted successfully']);
    }

    // Publik: Tambah reaksi ke artikel (dengan rate limiting)
    public function react(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:suka,tertawa,sedih,marah',
            'action' => 'required|in:add,remove'
        ]);

        // Rate limiting: max 30 reactions per minute per IP
        $throttleKey = 'reaction:' . $request->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 30)) {
            return response()->json([
                'message' => 'Terlalu banyak reaksi. Coba lagi nanti.',
            ], 429);
        }
        RateLimiter::hit($throttleKey, 60);

        $post = Post::findOrFail($id);

        // Use whitelist mapping untuk mencegah SQL injection
        $column = self::ALLOWED_REACTION_COLUMNS[$request->type] ?? null;
        if (!$column) {
            return response()->json(['message' => 'Invalid reaction type.'], 422);
        }

        if ($request->action === 'add') {
            $post->increment($column);
        } else {
            if ($post->$column > 0) {
                $post->decrement($column);
            }
        }

        return response()->json([
            'message' => 'Reaction updated',
            'reactions' => [
                'suka' => $post->count_suka,
                'tertawa' => $post->count_tertawa,
                'sedih' => $post->count_sedih,
                'marah' => $post->count_marah,
            ]
        ]);
    }
}
