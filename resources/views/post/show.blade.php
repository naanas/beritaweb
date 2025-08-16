@extends('layouts.public_app')

@section('title', $post->title)

@section('content')
    <article class="post-detail">
        <header class="post-header">
            <h1 class="post-title">{{ $post->title }}</h1>
            <div class="post-meta">
                <span>Kategori: <a href="#">{{ $post->category->name ?? 'Tanpa Kategori' }}</a></span>
                <span>|</span>
                <span>Oleh: {{ $post->user->name ?? 'Anonim' }}</span>
                <span>|</span>
                <span>{{ $post->published_at?->format('d F Y H:i') ?? 'Belum Dipublikasi' }}</span>
            </div>
            @if($post->image)
                <img src="{{ $post->image }}" alt="{{ $post->title }}" class="post-image">
            @endif
        </header>

        <div class="post-content">
            {!! nl2br(e($post->content)) !!}
        </div>

        <hr>

        <section class="comments-section">
            <h3 class="comments-title">Komentar ({{ $post->comments->count() }})</h3>
            @forelse ($post->comments as $comment)
                <div class="comment-card">
                    <div class="comment-meta">
                        <strong>{{ $comment->user->name ?? $comment->author_name ?? 'Tamu' }}</strong> pada {{ $comment->created_at->format('d M Y, H:i') }}
                    </div>
                    <p class="comment-content">{{ $comment->content }}</p>
                </div>
            @empty
                <p>Belum ada komentar untuk berita ini.</p>
            @endforelse

            {{-- Formulir Komentar --}}
            <div class="comment-form-container">
                <h4>Tambahkan Komentar</h4>
                @if (Session::has('success_message'))
                    <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                        {{ Session::get('success_message') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- **PERBAIKI BAGIAN INI** --}}
                <form action="{{ route('comments.store', $post) }}" method="POST" class="comment-form">
                    @csrf {{-- **INI PENTING!** Laravel CSRF token untuk keamanan --}}
                    <div class="form-group">
                        <label for="name">Nama:</label>
                        <input type="text" id="name" name="author_name" value="{{ old('author_name') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="author_email" value="{{ old('author_email') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="comment">Komentar:</label>
                        <textarea id="comment" name="content" rows="5" required>{{ old('content') }}</textarea>
                    </div>
                    <button type="submit" class="btn-submit">Kirim Komentar</button>
                </form>
            </div>
        </section>
    </article>
@endsection