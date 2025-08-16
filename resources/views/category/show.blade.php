@extends('layouts.public_app')

@section('title', 'Berita Kategori ' . $category->name)

@section('content')
    <h2 class="section-title">Berita Kategori: {{ $category->name }}</h2>
    <div class="news-grid">
        @forelse ($posts as $post)
            <div class="news-card">
                <a href="{{ route('post.show', $post->slug) }}">
                    <img src="{{ $post->image ?: 'https://via.placeholder.com/600x400?text=No+Image' }}" alt="{{ $post->title }}" class="news-image">
                </a>
                <div class="news-info">
                    <span class="news-category">{{ $post->category->name ?? 'Tanpa Kategori' }}</span>
                    <h3 class="news-title"><a href="{{ route('post.show', $post->slug) }}">{{ $post->title }}</a></h3>
                    <p class="news-excerpt">{{ Str::limit(strip_tags($post->content), 150) }}</p>
                    <div class="news-meta">
                        <span>Oleh: {{ $post->user->name ?? 'Anonim' }}</span>
                        <span>|</span>
                        <span>{{ $post->published_at?->diffForHumans() ?? 'Belum Dipublikasi' }}</span>
                    </div>
                </div>
            </div>
        @empty
            <p>Belum ada berita yang tersedia dalam kategori ini.</p>
        @endforelse
    </div>
    <div class="pagination">
        {{ $posts->links() }}
    </div>
@endsection
